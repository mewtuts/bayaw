<?php

namespace App\Http\Controllers;

use App\Exports\LogsExport;
use App\Models\Logs;
use App\Models\proflogs;
use App\Models\rooms;
use App\Models\schedules;
use App\Models\sections;
use App\Models\subjects;
use App\Models\units;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class LogsController extends Controller
{
    public function refresh_table()
    {
        $user_mname = Session::get('user_firstname');
        $user_lname = Session::get('user_lastname');

        $mylogs = proflogs::where('name', $user_mname.' '.$user_lname)->orderBy('created_at', 'desc')->first();
        $room = $mylogs->room;
        $proflogs_id = $mylogs->id;
        $units = units::where('room_id',$room)->get();

        $tableData = units::where('room_id',$room)->get();;

        // Return the data as JSON
        return response()->json($tableData);
    }

    public function prof_logs()
    {
        return view('forms.instructor_log');
    }

    public function log(Request $request){
        $user_id = Session::get('user_id');
        $user_mname = Session::get('user_firstname');
        $user_lname = Session::get('user_lastname');
        $sid = $request->sid;
        $rid = $request->rid;
        $pcnum = $request->pcnum;
    // HOUR, MINUTE AND SECOND.
        $date = Carbon::now();
        $timein = $date = $date->format('H:i:s');
    // YEAR, MONTH AND DAY.
        $date1 = Carbon::now();
        $ymd = $date1 = $date1->format('Y:m:d');
    // GETTING USER/STUDENT SCHEDULE.
        $schedule = schedules::find($sid);
        $s_Day = $schedule->day;
        $s_StartTime = $schedule->start_time;
        $s_EndTime = $schedule->end_time;
        $s_Room = $schedule->room;
        $schedID = Session::get('id');
    // FINDING SCHEDULE INSTRUCTOR OF THE USER/STUDENT.
        $instructor = Users::find($schedule->instructor);
        $instructor_name = $instructor->fname.' '.$instructor->lname;
    // GATHERING SUBJECT INFO OF THE USER/STUDENT.
        $subject = subjects::find($schedule->subject_id);
        $subject_name = $subject->subject;
        $subject_code = $subject->subject_code;
    // KNOWING THE USER/STUDENT SECTION.
        $section = sections::find($schedule->section_id);
        $section_name = $section->section;

    // CHECKING THE SELECTED PC, IF IT IS ALREADY SELECTED BY THE OTHER STUDENT/USER.
        $pcChecking = Logs::
        where('pcnum', $pcnum)
        ->where('created_at', '>=', $ymd.' '.$s_StartTime)
        ->where('created_at', '<=', $ymd.' '.$s_EndTime)
        ->count();
        if ( $pcChecking <= 0 ) {

            // kapag wala pang gumamit
            $log = new Logs();
            $log->user_id = $user_mname.' '.$user_lname;
            $log->day = $s_Day;
            $log->start_time = $timein;
            $log->pcnum = $pcnum;
            $log->subject = $subject_name;
            $log->section = $section_name;
            $log->room = $s_Room;
            $log->instructor = $instructor_name;
            $log->save();
            return redirect('/users/timein');

        } else {

            // kapag meron ng gumamit
            return redirect()->back();

        }
    // END OF CHECKING THE SELECTED PC, IF IT IS ALREADY SELECTED BY THE OTHER STUDENT/USER.
    }

    public function instructor_log(Request $request){
        $user_id = Session::get('user_id');
        $user_mname = Session::get('user_firstname');
        $user_lname = Session::get('user_lastname');

        $sid = $request->sid;
        $rid = $request->rid;
        $pcnum = $request->pcnum;

        $date = Carbon::now();
        $timein = $date = $date->format('H:i:s');

        $date1 = Carbon::now();
        $ymd = $date1->format('Y-m-d');

        $schedule = schedules::find($sid);
        $lab_number = $schedule->room;
        $s_Day = $schedule->day;
        $s_StartTime = $schedule->start_time;
        $s_EndTime = $schedule->end_time;
        $s_Room = $schedule->room;

        $instructor = Users::find($schedule->instructor);
        $instructor_name = $instructor->fname.' '.$instructor->lname;

        $subject = subjects::find($schedule->subject_id);
        $subject_name = $subject->subject;
        $subject_code = $subject->subject_code;

        $section = sections::find($schedule->section_id);
        $section_name = $section->section;

        $log = new Logs();
        $log->user_id = $user_mname.' '.$user_lname;
        $log->day = $s_Day;
        $log->start_time = $timein;
        $log->pcnum = $pcnum;
        $log->subject = $subject_name;
        $log->section = $section_name;
        $log->room = $s_Room;
        $log->instructor = $instructor_name;
        $log->save();

        $SchedID = $request->sid;
        $mylogs = Logs::where('user_id', $user_mname.' '.$user_lname)->orderBy('created_at', 'desc')->first();
        $roomID = $mylogs->room;

        $logs = Logs::whereBetween('start_time', [$s_StartTime, $s_EndTime])->where('room',$lab_number)->where('day', $s_Day)->where('subject',$subject_name)->get();

        $log = Logs::where('instructor');
        $units = units::where('room_id',$roomID)->get();

        return view('forms.instructor_log', compact('mylogs', 'roomID', 'units','sid'));

        // return redirect('/instructor/timein');

    }

    public function instruc_timein(Request $request)
    {
        $user_id = Session::get('user_id');
        $user_mname = Session::get('user_firstname');
        $user_lname = Session::get('user_lastname');

        $sid = $request->sid;
        // dd($sid);
        $rid = $request->rid;
        $pcnum = $request->pcnum;

        $date = Carbon::now();
        $timein = $date = $date->format('H:i:s');

        $schedule = schedules::find($sid);
        $lab_number = $schedule->room;
        $s_Day = $schedule->day;
        $s_StartTime = $schedule->start_time;
        $s_EndTime = $schedule->end_time;
        $s_Room = $schedule->room;

        $instructor = Users::find($schedule->instructor);
        $instructor_name = $instructor->fname.' '.$instructor->lname;

        $subject = subjects::find($schedule->subject_id);
        // dd($subject);
        $subject_name = $subject->subject;

        $section = sections::find($schedule->section_id);
        $section_name = $section->section;

        $mylogs = Logs::where('user_id', $user_mname.' '.$user_lname)->orderBy('created_at', 'desc')->first();
        $roomID = $mylogs->room;

        $logs = Logs::whereBetween('start_time', [$s_StartTime, $s_EndTime])->where('room',$lab_number)->where('day', $s_Day)->where('subject',$subject_name)->get();

        // dd($logs);

        $log = Logs::where('instructor');
        $units = units::where('room_id',$roomID)->get();

        return view('forms.attendance', compact('mylogs', 'roomID', 'units','sid','logs'));
    }

    public function allowedtimein(Request $request)
    {

        $user_id = Session::get('user_id');
        $user_mname = Session::get('user_firstname');
        $user_lname = Session::get('user_lastname');

        $sid = $request->sid;
        $rid = $request->rid;
        $pcnum = $request->pcnum;
        $secID = $request->secID;

        $section = sections::find($secID);
        $sec_name = $section->section;
        // dd($schedule);;

        $date = Carbon::now();
        $timein = $date = $date->format('H:i:s');

        $day = Carbon::now();
        $araw = $day = $day->format('l');

        $log = new Logs();
        $log->user_id = $user_mname.' '.$user_lname;
        $log->day = $araw;
        $log->start_time = $timein;
        $log->pcnum = $request->pcnum;
        $log->subject = $request->subj;
        $log->room = $request->labnum;
        $log->instructor = $request->instruc;
        $log->section = $sec_name;
        // dd($request->subj, $request->labnum, $request->instruc);
        $log->save();

        return redirect('/users/timein');
    }

    public function timeout(Request $request){
        $date = Carbon::now();
        $timeout = $date = $date->format('H:i:s');

        $log = Logs::find($request->logid);
        $log->end_time = $timeout;
        $log->feedback = $request->feedback;
        $log->save();

        $request->session()->forget('user_firstname');
        $request->session()->forget('user_lastname');
        $request->session()->forget('user_id');

        return redirect('/logouts');
    }

    public function instructor_timeout(Request $request){

        $date = Carbon::now();
        $timeout = $date = $date->format('H:i:s');

        $pName = Session::get('name');
        $day = Session::get('s_Day');
        $timeIn = Session::get('start_time');
        $subject = Session::get('subject_name');
        $section = Session::get('section_name');
        $room = Session::get('s_Room');

        $storeLog = new proflogs();
        $storeLog->name = $pName;
        $storeLog->day = $day;
        $storeLog->start_time = $timeIn;
        $storeLog->end_time = $timeout;
        $storeLog->subject = $subject;
        $storeLog->section = $section;
        $storeLog->room = $room;
        $storeLog->feedback = $request->feedbacks;
        $storeLog->save();

        $request->session()->forget('name');
        $request->session()->forget('s_Day');
        $request->session()->forget('start_time');
        $request->session()->forget('subject_name');
        $request->session()->forget('section_name');
        $request->session()->forget('user_firstname');
        $request->session()->forget('user_lastname');
        $request->session()->forget('user_id');

        return redirect('/logouts');
    }

    public function ExportLogs()
    {
        $date = Carbon::now();
        $dates = $date->format('Y-M-d l H:i');
        return Excel::download(new LogsExport, $dates.' '.'Logs.xlsx');
        return redirect()->back()->with('imported', 'Imported Successfully');
    }

    public function StudentAttendance()
    {
        $date = Carbon::now();
        $timein = $date = $date->format('H:i:s');

        $attendance = Logs::find('start_time', $timein);
        // dd($attendance);


    }
}
