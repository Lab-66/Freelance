<?php

namespace App\Http\Controllers\Users;

use App\Events\Meeting\MeetingCreated;
use App\Http\Controllers\UserController;
use App\Http\Requests\MeetingRequest;
use App\Models\Meeting;
use App\Models\Option;
use App\Repositories\CompanyRepository;
use App\Repositories\MeetingRepository;
use App\Repositories\OptionRepository;
use App\Repositories\UserRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\URL;
use Sentinel;
use App\Http\Requests;
use yajra\Datatables\Datatables;

class MeetingController extends UserController
{
    /**
     * @var MeetingRepository
     */
    private $meetingRepository;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    public function __construct(MeetingRepository $meetingRepository,
                                CompanyRepository $companyRepository,
                                UserRepository $userRepository,
                                OptionRepository $optionRepository)
    {
        $this->middleware('authorized:meetings.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:meetings.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:meetings.delete', ['only' => ['delete']]);

        parent::__construct();

        $this->meetingRepository = $meetingRepository;
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
        $this->optionRepository = $optionRepository;

        view()->share('type', 'meeting');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('meeting.meetings');

        return view('user.meeting.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('meeting.new');

        $this->generateParams();

        return view('user.meeting.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MeetingRequest $request
     * @return \Illuminate\Http\Response
     * @internal param $
     */
    public function store(MeetingRequest $request)
    {
        $meting = $this->meetingRepository->create($request->all());

        event(new MeetingCreated($meting));

        return redirect("meeting");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Meeting $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        $title = trans('meeting.edit');

        $this->generateParams();

        return view('user.meeting.create', compact('title', 'meeting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MeetingRequest $request
     * @param  Meeting $meeting
     * @return \Illuminate\Http\Response
     * @internal param $
     */
    public function update(MeetingRequest $request, Meeting $meeting)
    {
        $meeting->all_day = ($request->all_day) ? $request->all_day : 0;
        $meeting->update($request->all());
        return redirect("meeting");
    }


    public function delete(Meeting $meeting)
    {
        $title = trans('meeting.delete');
        return view('user.meeting.delete', compact('title', 'meeting'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Meeting $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return redirect('meeting');
    }

    public function data()
    {
        $meetings = $this->meetingRepository->getAll()
            ->with('responsible')
            ->get()
            ->filter(function ($meeting) {
                return ($meeting->privacy=='Everyone' || ($meeting->privacy=='Only me' && $meeting->responsible_id==$this->user->id));
            })
            ->map(function ($meeting) {
                return [
                    'id' => $meeting->id,
                    'meeting_subject' => $meeting->meeting_subject,
                    'starting_date' => $meeting->starting_date,
                    'ending_date' => $meeting->ending_date,
                    'responsible' => isset($meeting->responsible) ? $meeting->responsible->full_name : '',
                ];
            });
        return Datatables::of($meetings)
            ->add_column('actions', ' @if(Sentinel::getUser()->hasAccess([\'meetings.write\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'meeting/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}" >
                                            <i class="fa fa-fw fa-pencil text-warning"></i>  </a>
                                     @endif
                                     @if(Sentinel::getUser()->hasAccess([\'meetings.delete\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'meeting/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i> </a>
                                     @endif')
            ->remove_column('id')
            ->make();
    }

    private function generateParams()
    {
        $companies = $this->companyRepository->getAll()->orderBy("name", "asc")->lists('name', 'id')->toArray();

        $staffs = ['' => trans('dashboard.select_staff')] +
            $this->userRepository->getStaff()->lists('full_name', 'id')->toArray();

        $privacy = $this->optionRepository->getAll()
            ->where('category', 'privacy')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->lists('title', 'value')->toArray();

        $show_times = $this->optionRepository->getAll()
            ->where('category', 'show_times')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->lists('title', 'value')->toArray();

        view()->share('privacy', $privacy);
        view()->share('show_times', $show_times);
        view()->share('staffs', $staffs);
        view()->share('companies', $companies);
    }

    public function calendar()
    {
        $title = trans('meeting.meetings');
        return view('user.meeting.calendar', compact('title', 'opportunity'));
    }

    public function calendar_data()
    {
        $events = array();
        $meetings = $this->meetingRepository->getAll()
            ->with('responsible')
            ->latest()->get()
            ->filter(function ($meeting) {
                return ($meeting->privacy=='Everyone' || ($meeting->privacy=='Only me' && $meeting->responsible_id==$this->user->id));
            })
            ->map(function ($meeting) {
                return [
                    'id' => $meeting->id,
                    'title' => $meeting->meeting_subject,
                    'start_date' => $meeting->starting_date,
                    'end_date' => $meeting->ending_date,
                    'type' => 'meeting'
                ];
            });
        foreach ($meetings as $d) {
            $event = [];
            $start_date = date(Settings::get('date_format'),(is_numeric($d['start_date'])?$d['start_date']:strtotime($d['start_date'])));
            $end_date = date(Settings::get('date_format'),(is_numeric($d['end_date'])?$d['end_date']:strtotime($d['end_date'])));
            $event['title'] = $d['title'];
            $event['id'] = $d['id'];
            $event['start'] = $start_date;
            $event['end'] = $end_date;
            $event['allDay'] = true;
            $event['description'] = $d['title'] . '&nbsp;<a href="' . url($d['type'] . '/' . $d['id'] . '/edit') . '" class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o">&nbsp;</i></a>';
            array_push($events, $event);
        }
        return json_encode($events);
    }
}
