<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Scheduling\AppointmentController;
use App\Http\Controllers\ZipAjaxController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Models\NPPRegistration\NPPRegisteredPatient;
use App\Models\NPPRegistration\NPPtoElirtPatient;
use App\Models\Scheduling\EventDay;
use App\Models\Scheduling\Event;
use App\Models\EmailDomainsForEvents;
use App\Models\Scheduling\Biz;
use App\Models\Scheduling\Appointment;
use App\Models\Clients\SearchAccount;
use App\Models\Clients\Account;
use App\Models\Clients\CustomRegistration;
use App\Models\LabTests\Questions\AoeQuestion;
use DB;

class NulirtPatientPortalAPIController extends Controller
{
    /**
     * Queries all the appointment data for a user
     * @param Request $request
     * @return json object
     */
    public function getAllAppointmentsForUser(Request $request)
    {
        $associated_patients_appointments = Appointment::whereIn('appointments.NPP_registered_patient_id', $request->all())
            ->join('event_days', 'appointments.event_day_id', '=', 'event_days.id')
            ->join('events', 'event_days.event_id', '=', 'events.id')
            ->where('event_days.deleted_at', '=', null)
            ->get(['events.*','event_days.event_date AS appointment_date','event_days.id AS time_slot_id', 'event_days.start_time AS appointment_time']);
        return response($associated_patients_appointments, 201);
    }

    /**
     * Queries all the Event meta data, such locations, custom registration, logo...
     * @param Request $request
     * @return json object
     */
    public function getEvent(Request $request)
    {
        $event = Event::where('events.id', $request->id)
      ->join('accounts', 'accounts.id', '=', 'events.account_id')
      ->join('custom_registrations', 'custom_registrations.account_id', '=', 'events.account_id')
      ->first(['events.*','accounts.*',	'custom_registrations.*','events.id as event_id']);
        $event['nulirt_logo_file_path'] =$this->getLogoUrl($request->id);
        return response($event, 201);
        ;
    }

    /**
     * Queries all the Event available, this function is primarily used with IUO controller.
     * @param Request $request
     * @return json object
     */
    public function getAllEvents(Request $request)
    {
        $event = Event::all();
        return response($event, 201);
    }

    /**
     * This is currently not a feature, but when it comes back it will check if
     * a user has the correct email domain for registration.
     * @param Request $request
     * @return json object
     */
    public function getEmailDomainsForEvents(Request $request)
    {
        $domain = EmailDomainsForEvents::where('account_id', $request->event_id)->get();
        if (count($domain) == 0) {
            $response = [
              'status'=>"no restriction",
              'count'=>count($domain)

            ];
        } else {
            $response = [
              'status'=>"restriction",
              'EmailDomainsForEvents'=>$domain
            ];
        }
        return response($response, 201);
    }

    /**
     * Queries all the Event dates available, so the NPP user can make a selection.
     * @param Request $request
     * @return json object
     */
    public function getEventDays(Request $request)
    {
        $event_days  = EventDay::where('event_id', $request->event_id)
              ->where('active', 1)
              ->where('event_date', '>=', date('Y-m-d'))
              ->where(function ($q) {
                  $q
                  ->whereRaw('max_per_event > num_taken')
                  ->orWhere('max_per_event', 0);
              })
              ->orderBy('event_date')
              ->orderBy('start_time')
              ->get();

        return response($event_days, 201);
    }

    /**
     * Not sure if this is being used
     */
    public function check_appointment_time(Request $request)
    {
        $event_day = Biz::get_event_day_by($request->event_id, $request->date, $request->time);
        $is_it_open = $this->checkAllow($event_day);
        // This is in the rare condition that we have two people signing up at the
        // exact same time.
        if ($is_it_open != false) {
            $response = [
            'status'=>$is_it_open
          ];
        } else {
            $response = $event_day;
        }

        return response($event_day, 201);
    }

    /**
     * Creates an appointment for the NPP user
     * @param Request $request
     * @return json object
     */
    public function makeAppointment(Request $request)
    {
        Appointment::insert([
        'event_day_id'=>$request->event_day_id,
        'NPP_registered_patient_id'=>0,
        'is_confirmed'=>1,
        'confirm_token'=> $request->confirm_token
        ]);

        $response = [
           'status'=>"no errors"
        ];

        return response($response, 201);
    }

    /**
     * deletes the NPP user appointment
     * @param Request $request
     * @return json object
     */
    public function userCancelAppointment(Request $request)
    {
        Appointment::where('event_day_id', $request->id)->delete();
        $response = [
           'status'=>"no errors",
        ];

        return response($response, 201);
    }

    /**
     * TODO: are we using this function?
     * @param Request $request
     * @return json object
     */
    public function confirm_appointment(Request $request)
    {
        $associated_patients_appointments = Appointment::whereIn('appointments.NPP_registered_patient_id', $request->NPP_registered_patient_id)
            ->join('NPP_registered_patients', 'appointments.NPP_registered_patient_id', '=', 'NPP_registered_patients.id')
            ->join('event_days', 'appointments.event_day_id', '=', 'event_days.id')
            ->join('events', 'event_days.event_id', '=', 'events.account_id')
            ->where('event_days.deleted_at', '=', null)
            ->get(['NPP_registered_patients.*','events.*','event_days.event_date AS appointment_date','event_days.id AS time_slot_id', 'event_days.start_time AS appointment_time']);

        return response($response, 201);
    }

    /**
     * The appointment is made before it is associated to an NPP patient.
     * Hence the code has to comeback associate the NPP patient id with the appointment time.
     * @param Request $request
     * @return json object
     */
    public function updateAppointmentWithNPPPatientId(Request $request)
    {
        // TODO need a safe guard
        Appointment::where('confirm_token', $request->appointment_token)->update(array('NPP_registered_patient_id' => $request->NPP_registered_patient_id));
        $response=Appointment::where('confirm_token', $request->appointment_token)
        ->join('event_days', 'appointments.event_day_id', '=', 'event_days.id')
        ->join('events', 'event_days.event_id', '=', 'events.id')
        ->get(['appointments.NPP_registered_patient_id','events.*','event_days.event_date AS appointment_date','event_days.id AS time_slot_id', 'event_days.start_time AS appointment_time']);

        return response($response, 201);
    }

    /**
     * Retrieve search account data
     * @param Request $request
     * @return json object
     */
    public function getSearchAccount(Request $request)
    {
        $account = SearchAccount::find($request->account_id);
        return response($account, 201);
    }

    /**
     * Query for consent questions associated to an account
     * @param Request $request
     * @return json object
     */
    public function getAccountConsents(Request $request)
    {
        $account = Account::where('id', $request->account_id)->first();
        $consents = $account->consents()->orderBy('sort_order')->get();
        return response($consents, 201);
    }

    /**
     * Query for AOE questions associated to an account
     * @param Request $request
     * @return json object
     */
    public function getAOEQuestions(Request $request)
    {
        //check to see if there are custom registrations
        $q = "SELECT aoe_questions.code FROM custom_registrations, accounts,	aoe_question_custom_registration, aoe_questions where accounts.id = custom_registrations.account_id 	and custom_registrations.account_id = $request->account_id and aoe_question_custom_registration.custom_registration_id = custom_registrations.id and aoe_question_custom_registration.aoe_question_id = aoe_questions.id ";
        $get_AOE_codes = DB::connection()->select($q);

        //if no results are found just return COVID questions
        if (empty($get_AOE_codes)) {
            $codes = AoeQuestion::COVID_CODES;
            $questions = AoeQuestion::with('aoeAnswers')->whereIn('code', $codes)->orderBy('aoe_questions.sort_order')->get();
            return response($questions, 201);
        } else {
            // turn this into an array
            $simple_array =array();
            foreach ($get_AOE_codes as $AOE_code) {
                $simple_array[] = $AOE_code->code;
            }
            $questions = AoeQuestion::with('aoeAnswers')->whereIn('code', $simple_array)->orderBy('aoe_questions.sort_order')->get();
            return response($questions, 201);
        }
    }

    /**
     * Validate the consent question by the NPP user were answered correctly
     * @param Request $request
     * @return json object
     */
    public function getAccountWithConsentsForValidiation(Request $request)
    {
        $account = Account::with('consents')->find($request->get('account_id'));
        return response($account, 201);
    }

    /**
     * Validate the zip and retrieve County and State data
     * @param Request $request
     * @return json object
     */
    public function getZipValidiation(Request $request)
    {
        $locationInfo = (new ZipAjaxController())->show($request->get('zip'));

        if (empty($locationInfo->original)) {
            $response = [
            'city'=>null,
            'state'=>null
          ];
        } else {
            $response = [
              'city'=>$locationInfo->original['city'],
              'state'=>$locationInfo->original['state']
            ];
        }

        return response($response, 201);
    }

    /**
     * Validate array to ensure the event is active, expired, or has time slots available
     * @param array $event_day
     * @param  App\Models\Scheduling\Biz: event_day_has_slots_open
     * @return string
     */
    public function checkAllow($event_day)
    {
        if (!$event_day) {
            return 'Event day not found';
        }
        if (!$event_day->active) {
            return 'Not active';
        }

        $today = date('Y-m-d');
        if (date('Y-m-d', strtotime($event_day->event_date)) < $today) {
            return 'Expired';
        }

        if (!Biz::event_day_has_slots_open($event_day->id)) {
            return 'No slots open';
        }

        return false;
    }

    public const UPLOADS_IMAGES_EVENTS = 'uploads/images/events';
    public const MIMES = ['jpg', 'png', 'jpeg', 'gif'];

    /**
     * Validate url path
     * @param INT $event_id, $get_rpath
     * @return string $get_rpath
     */
    public function getLogoPath($event_id, $get_rpath = 0)
    {
        foreach (self::MIMES as $mime) {
            $rpath = self::UPLOADS_IMAGES_EVENTS."/$event_id.$mime";
            $fpath = config('filesystems.disks.public.root').'/'.$rpath;

            if (File::exists($fpath)) {
                $logo_path = $fpath;
                break;
            }
        }

        if (empty($logo_path)) {
            return null;
        }

        return $get_rpath ? $rpath : $fpath;
    }

    /**
     * get url path for image associated with event
     * @param INT $event_id
     * @return string $logo_path
     */
    public function getLogoUrl($event_id)
    {
        $logo_path = $this->getLogoPath($event_id, 1);

        return $logo_path
            ? Storage::url($logo_path)
            : null;
    }
}
