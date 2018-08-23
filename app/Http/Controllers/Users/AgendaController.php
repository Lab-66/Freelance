<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Repositories\ContractRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\MeetingRepository;
use App\Repositories\OpportunityRepository;
use App\Repositories\PriceListRepository;
use App\Repositories\PriceListVersionRepository;
use App\Repositories\QuotationRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Sentinel;
use App\Http\Requests;
use Illuminate\Support\Facades\URL;
use DB;
use App\Models\Agenda;

class AgendaController extends UserController
{
	public function agenda(){
		$datas = DB::table('agenda')->get();
		view()->share('agenda', $datas);
		view()->share('type', 'agenda');
		return View('user.agenda.index',array('title' => 'Office 365 Agenda Sync'));////
	}
	public function eventsPhp(){
		//print_r($_REQUEST);
		$results = DB::table("agenda")->get();
		$events = array();
		foreach($results as $row){
			$event = new \stdClass();
			$event->name = $row->name;
			$event->image = $row->image;
			$event->day = date('j', strtotime($row->start_date));
			$event->month = date('n', strtotime($row->start_date));
			$event->year = date('Y', strtotime($row->start_date));
			if (!$row->end_date || ($row->end_date == '0000-00-00')) {
				$event->duration = 1; // If end_time is blank -> event's duration = 1 (day).	
			} else {
				if (date('Ymd', strtotime($row->start_date)) == date('Ymd', strtotime($row->end_date))) { // If start date and end date are same day -> event's duration = 1 (day).
					$event->duration = 1;
				} else {
					$start_day = date('Y-m-d', strtotime($row->start_date));
					$end_day = date('Y-m-d', strtotime($row->end_date));
					$event->duration = ceil(abs(strtotime($end_day) - strtotime($start_day)) / 86400) + 1; // Get event's duration = days between start date and end date.
				}
			}
			$event->time = $row->time;
			$event->color = $row->color;
			$event->location = $row->location;
			$event->description = utf8_encode($row->description);
			array_push($events, $event);
		}
		return json_encode($events);
	}
	public function createAgenda(){
		view()->share('type', 'agenda');
		return View('user.agenda.create',array('title' => 'Create a new agenda'));
	}
	public function store(){
		DB::table('agenda')->insert([
				['title' => $_REQUEST['title'],
				 'location' => $_REQUEST['location'],
				 'date' => $_REQUEST['date'],
				 'start_time' => $_REQUEST['start_time'],
				 'end_time' => $_REQUEST['end_time'],
				 'status' => 0
				 ]
			]);
		return redirect("agenda");
	}
	public function data(){
		
		$datas = DB::table('agenda')->get();
		view()->share('agenda', $datas);
        
	}
	public function status($id){
		DB::table('agenda')
            ->where('agenda_id', $id)
            ->update(['status' => 1]);	
			header("Location: "."http://93.158.221.197/files/public/agenda");
			exit;
	}
	public function working($id){
		DB::table('agenda')
            ->where('agenda_id', $id)
            ->update(['status' => 2]);	
			header("Location: "."http://93.158.221.197/php-calendar/home.php");
			exit;
	}
}
