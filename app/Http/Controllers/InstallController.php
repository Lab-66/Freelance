<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallSettingsEmailRequest;
use App\Http\Requests\InstallSettingsRequest;
use App\Models\Option;
use App\Repositories\InstallRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Swift_SmtpTransport;
use Swift_TransportException;

class InstallController extends Controller
{
	/**
	 * @var InstallRepository
	 */
	private $installRepository;

	/**
	 * InstallController constructor.
	 * @param InstallRepository $installRepository
	 */
	public function __construct(InstallRepository $installRepository)
	{

		$this->installRepository = $installRepository;
	}

	public function index()
	{
		return view('install.start');
	}

	public function requirements()
	{
		$requirements = $this->installRepository->getRequirements();
		$allLoaded = $this->installRepository->allRequirementsLoaded();

		return view('install.requirements', compact('requirements', 'allLoaded'));
	}

	public function permissions()
	{
		if (!$this->installRepository->allRequirementsLoaded()) {
			return redirect('install/requirements');
		}

		$folders = $this->installRepository->getPermissions();
		$allGranted = $this->installRepository->allPermissionsGranted();

		return view('install.permissions', compact('folders', 'allGranted'));
	}

	public function database()
	{
		if (!$this->installRepository->allRequirementsLoaded()) {
			return redirect('install/requirements');
		}

		if (!$this->installRepository->allPermissionsGranted()) {
			return redirect('install/permissions');
		}

		return view('install.database');
	}

	public function installation(Request $request)
	{
		if (!$this->installRepository->allRequirementsLoaded()) {
			return redirect('install/requirements');
		}

		if (!$this->installRepository->allPermissionsGranted()) {
			return redirect('install/permissions');
		}

		$dbCredentials = $request->only('host', 'username', 'password', 'database');

		if (!$this->installRepository->dbCredentialsAreValid($dbCredentials)) {
			return redirect('install/database')
				->withInput(array_except($dbCredentials, 'password'))
				->withErrors(trans("install.connection_established"));
		}
		Settings::set('install.db_credentials', $dbCredentials,60);

		return view('install.installation');
	}

	public function install()
	{
		try {
			$db = Settings::get('install.db_credentials');

			$path = base_path('.env');
			$env = file($path);

			$env = str_replace('DB_HOST='.env('DB_HOST'), 'DB_HOST='.$db['host'], $env);
			$env = str_replace('DB_DATABASE='.env('DB_DATABASE'), 'DB_DATABASE='.$db['database'], $env);
			$env = str_replace('DB_USERNAME='.env('DB_USERNAME'), 'DB_USERNAME='.$db['username'], $env);
			$env = str_replace('DB_PASSWORD='.env('DB_PASSWORD'), 'DB_PASSWORD='.$db['password'], $env);

			file_put_contents($path, $env);

			$this->installRepository->setDatabaseCredentials($db);

			config(['app.debug' => true]);

			Artisan::call('key:generate');

			$this->installRepository->dbDropSettings();

			Artisan::call('migrate', ['--force' => true]);
			Artisan::call('db:seed', ['--force' => true]);

			return redirect('install/settings');

		} catch (\Exception $e) {
			@unlink(base_path('.env'));
			\Log::error($e->getMessage());
			\Log::error($e->getTraceAsString());

			return redirect('install/error');
		}
	}

	public function disable()
	{
		$foldersDisable = $this->installRepository->getDisablePermissions();
		$allDisableGranted = $this->installRepository->allDisablePermissionsGranted();

		return view('install.disable', compact('foldersDisable','allDisableGranted'));
	}
	public function settings()
	{
		Settings::forget('install.db_credentials');

		$currency = Option::where('category', 'currency')->lists('title', 'value')->toArray();

		return view('install.settings', compact('currency'));
	}

	public function settingsSave(InstallSettingsRequest $request)
	{
		Settings::set('site_name', $request->site_name);

		Settings::set('site_email', $request->site_email);

		Settings::set('currency', $request->currency);

		$admin = Sentinel::registerAndActivate(array(
			'email' => $request->email,
			'password' => $request->password,
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
		));
		$admin->user_id = $admin->id;
		$admin->save();

		$role = Sentinel::findRoleBySlug('admin');
		$role->users()->attach($admin);

		return redirect('install/email_settings');
	}

	public function settingsEmail()
	{
		return view('install.mail_settings');
	}

	public function settingsEmailSave(InstallSettingsEmailRequest $request)
	{
		try {
			if ($request->email_driver == 'smtp') {
				$transport = Swift_SmtpTransport::newInstance($request->email_host, $request->email_port, 'ssl');
				$transport->setUsername($request->email_username);
				$transport->setPassword($request->email_password);
				$mailer = \Swift_Mailer::newInstance($transport);
				$mailer->getTransport()->start();
			}
			foreach ($request->except('_token') as $key => $value) {
				Settings::set($key, $value);
			}
			file_put_contents(storage_path('installed'), 'Welcome to LCRM');

			return redirect('install/complete');

		} catch (Swift_TransportException $e) {
			return redirect()->back()->withErrors($e->getMessage());
		} catch (\Exception $e) {
			return redirect()->back()->withErrors($e->getMessage());
		}
	}

	public function complete()
	{
		return view('install.complete');
	}

	public function error()
	{
		return view('install.error');
	}
}
