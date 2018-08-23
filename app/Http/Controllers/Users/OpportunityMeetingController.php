<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Http\Requests\MeetingRequest;
use App\Models\Meeting;
use App\Models\Company;
use App\Models\Opportunity;
use App\Models\Option;
use App\Models\User;
use App\Repositories\CompanyRepository;
use App\Repositories\MeetingRepository;
use App\Repositories\OptionRepository;
use App\Repositories\UserRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\URL;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use yajra\Datatables\Datatables;

class OpportunityMeetingController extends UserController
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

	/**
     * OpportunityMeetingController constructor.
     * @param MeetingRepository $meetingRepository
     * @param CompanyRepository $companyRepository
     * @param UserRepository $userRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(MeetingRepository $meetingRepository,
                                CompanyRepository $companyRepository,
                                UserRepository $userRepository,
                                OptionRepository $optionRepository)
    {
        parent::__construct();

        $this->meetingRepository = $meetingRepository;
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
        $this->optionRepository = $optionRepository;

        view()->share('type', 'opportunitymeeting');

    }

    /**
     * Display a listing of the resource.
     *
     * @param Opportunity $opportunity
     * @return \Illuminate\Http\Response
     */
    public function index(Opportunity $opportunity)
    {
        $title = trans('meeting.opportunity_meetings');
        return view('user.opportunitymeeting.index', compact('title', 'opportunity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Opportunity $opportunity)
    {
        $title = trans('meeting.opportunity_new');

        $this->generateParams();

        return view('user.opportunitymeeting.create', compact('title', 'opportunity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Opportunity $opportunity
     * @param MeetingRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Opportunity $opportunity, MeetingRequest $request)
    {
        $opportunity->meetings()->create($request->all(), ['user_id' => $this->user->id]);

        return redirect("opportunitymeeting/" . $opportunity->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Opportunity $opportunity , Meeting $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Opportunity $opportunity, Meeting $meeting)
    {
        $title = trans('meeting.opportunity_edit');

        $this->generateParams();

        return view('user.opportunitymeeting.create', compact('title', 'meeting', 'opportunity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MeetingRequest|Request $request
     * @param Opportunity $opportunity
     * @param  Meeting $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(MeetingRequest $request, Opportunity $opportunity, Meeting $meeting)
    {
        $meeting->all_day = ($request->all_day) ? $request->all_day : 0;
        $meeting->update($request->except('attendees'));

        return redirect("opportunitymeeting/" . $opportunity->id);
    }


    public function delete(Opportunity $opportunity, Meeting $meeting)
    {
        $title = trans('meeting.opportunity_delete');
        return view('user.opportunitymeeting.delete', compact('title', 'meeting', 'opportunity'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Opportunity $opportunity , Meeting $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opportunity $opportunity, Meeting $meeting)
    {
        $meeting->delete();
        return redirect('opportunitymeeting/' . $opportunity->id);
    }

    public function data(Opportunity $opportunity)
    {
        $meetings = $opportunity->meetings()
            ->with('responsible')
            ->get()
            ->filter(function ($meeting) {
                return ($meeting->privacy=='Everyone' || ($meeting->privacy=='Only me' && $meeting->responsible_id==$this->user->id));
            })
            ->map(function ($meeting) use ($opportunity) {
                return [
                    'id' => $meeting->id,
                    'meeting_subject' => $meeting->meeting_subject,
                    'starting_date' => $meeting->starting_date,
                    'ending_date' => $meeting->ending_date,
                    'meeting_type_id' => $opportunity->id,
                    'responsible' => isset($meeting->responsible) ? $meeting->responsible->full_name : 'N/A'
                ];
            });

        return Datatables::of($meetings)
            ->add_column('actions', '<a href="{{ url(\'opportunitymeeting/\' . $meeting_type_id . \'/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning "></i> </a>
                                     <a href="{{ url(\'opportunitymeeting/\' . $meeting_type_id . \'/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i> </a>')
            ->remove_column('id')
            ->remove_column('meeting_type_id')
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

        view()->share('show_times', $show_times);
        view()->share('privacy', $privacy);
        view()->share('staffs', $staffs);
        view()->share('companies', ($companies + $staffs));
    }

    public function calendar(Opportunity $opportunity)
    {
        $title = trans('meeting.opportunity_meetings');
        return view('user.opportunitymeeting.calendar', compact('title', 'opportunity'));
    }

    public function calendar_data(Opportunity $opportunity)
    {
        $events = array();
        $meetings = $opportunity->meetings()
            ->with('responsible')
            ->get()
            ->map(function ($meeting) use ($opportunity) {
                return [
                    'id' => $meeting->id,
                    'title' => $meeting->meeting_subject,
                    'start_date' => $meeting->starting_date,
                    'end_date' => $meeting->ending_date,
                    'meeting_type_id' => $opportunity->id,
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
