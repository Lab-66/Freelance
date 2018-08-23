<?php

namespace App\Http\Controllers\Users;

use App\Events\Call\CallCreated;
use App\Http\Controllers\UserController;
use App\Http\Requests\CallRequest;
use App\Models\Call;
use App\Repositories\CallRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Sentinel;
use App\Http\Requests;
use yajra\Datatables\Datatables;
use DB;

class CallController extends UserController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CallRepository
     */
    private $callRepository;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    public function __construct(UserRepository $userRepository,
                                CallRepository $callRepository,
                                CompanyRepository $companyRepository)
    {
        parent::__construct();

        $this->middleware('authorized:logged_calls.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:logged_calls.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:logged_calls.delete', ['only' => ['delete']]);

        $this->userRepository = $userRepository;
        $this->callRepository = $callRepository;
        $this->companyRepository = $companyRepository;

        view()->share('type', 'call');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
        $title = trans('call.calls');
        return view('user.call.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('call.new');

        $this->generateParams();

        return view('user.call.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CallRequest $request)
    {
        $call = $this->callRepository->create($request->all());
        event(new CallCreated($call));
		
        return redirect("call");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Call $call
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call)
    {
		
        $title = trans('call.edit');

        $this->generateParams();

        return view('user.call.create', compact('title', 'call'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Call $call
     * @return \Illuminate\Http\Response
     */
    public function update(CallRequest $request, Call $call)
    {
        $call->update($request->all());

        return redirect("call");
    }


    public function delete(Call $call)
    {
        $title = trans('call.delete');
        return view('user.call.delete', compact('title', 'call'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Call $call
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call)
    {
        $call->delete();
        return redirect('call');
    }

    public function data()
    {
        $calls = $this->callRepository->getAll()
            ->with('user', 'company')
            ->get()
            ->map(function ($call) {
                return [
                    'id' => $call->id,
                    'date' => $call->date,
					'timepicker1' => $call->timepicker1,
                    'call_summary' => $call->call_summary,
                    'duration' => $call->duration,
                    'company' => isset($call->company) ? $call->company->name : '',
                    'user' => isset($call->user) ? $call->user->full_name : '',
                ];
            });
        return Datatables::of($calls)
            ->add_column('actions', '@if(Sentinel::getUser()->hasAccess([\'logged_calls.write\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'call/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning "></i> </a>
                                     @endif
                                     @if(Sentinel::getUser()->hasAccess([\'logged_calls.delete\']) || Sentinel::inRole(\'admin\'))
                                     <a href="{{ url(\'call/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i> </a>
                                     @endif')
            ->remove_column('id')
            ->make();
    }

    private function generateParams()
    {
        $companies = ['' => trans('dashboard.select_company')] +
            $this->companyRepository->getAll()->orderBy("name", "asc")->lists('name', 'id')->toArray();

        $staffs = ['' => trans('dashboard.select_staff')] +
            $this->userRepository->getStaff()->lists('full_name', 'id')->toArray();
        view()->share('staffs', $staffs);
        view()->share('companies', $companies);
    }

}
