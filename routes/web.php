<?php

use App\Http\Controllers\AddRoom;
use App\Http\Controllers\AddSchedule;
use App\Http\Controllers\AddSection;
use App\Http\Controllers\AddSubject;
use App\Http\Controllers\AddUnit;
use App\Http\Controllers\EditController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\TableditController;
use App\Models\Logs;
use App\Models\proflogs;
use App\Models\rooms;
use App\Models\schedules;
use App\Models\sections;
use App\Models\subjects;
use App\Models\units;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Row;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Logs::truncate();
// proflogs::truncate();
// practice field

Route::get('/tabledit', [TableditController::class, 'index']);

Route::post('tabledit/action', [TableditController::class, 'action'])->name('tabledit/action');

Route::get('/practice/try', function(){
    $stud = DB::table('logs')
            ->select('logs.pcnum','units.status','units.issue','logs.room','logs.user_id',)
            ->join('units','units.pc_number', '=','logs.pcnum')
            ->where('room', 4)
            ->get();

            dd($stud);
    return view('practice.try', compact('id'));
});
// end of practice

// index
Route::get('/', function() {
    $logs = Logs::get();
    return view('welcome', compact('logs'));
});

// signup
Route::get('/signup', function() {
    return view('signup');
});
Route::post('/register', [SignUpController::class, 'SignUp']);
Route::post('/update/data', [SignUpController::class, 'update'])->name('updateinfo');

//login
Route::post('/login/user', [LoginController::class, 'login'])->name('login');
Route::get('/instructor/dashboard', function()
{
    $user_mname = Session::get('user_firstname');
    $user_lname = Session::get('user_lastname');
    $user_id = Session::get('user_id');

    $date = Carbon::now();
    $asianDate = $date->format('H:i');
    $asianDateDay = $date->format('l');

    $schedule1 = Users::join('schedules', 'schedules.instructor', '=', 'users.id')
    ->where('schedules.start_time', '<=', $asianDate)
    ->where('schedules.end_time', '>=', $asianDate)
    ->where('schedules.day', 'like', '%'.$asianDateDay.'%')
    ->where('schedules.instructor', $user_id)
    ->first();

    if ( empty($schedule1) ) {

        $rid = 0;
        $sid = 0;
        $unit[] = 0;
        return back()->with('noSched', 'You dont have schedule at the moment');

    } else {

        $rid =  $schedule1->room;

        $unit = units::where('room_id', $schedule1->room)->get();

        $sid = $schedule1->id;

        $date = Carbon::now();
        $timein = $date = $date->format('H:i:s');
        $date1 = Carbon::now();
        $ymd = $date1 = $date1->format('Y:m:d');

        $schedule = schedules::find($sid);

        $lab_number = $schedule->room;
        $s_Day = $schedule->day;
        $s_StartTime = $schedule->start_time;
        $s_EndTime = $schedule->end_time;
        $s_Room = $schedule->room;

        $subject = subjects::find($schedule->subject_id);

        $subject_name = $subject->subject;
        $subject_code = $subject->subject_code;
        $section = sections::find($schedule->section_id);
        $section_name = $section->section;

        session()->put('name', $user_mname.' '.$user_lname);
        session()->put('s_Day', $s_Day);
        session()->put('start_time', $timein);
        session()->put('subject_name', $subject_name);
        session()->put('section_name', $section_name);
        session()->put('s_Room', $s_Room);

        $student_logs = Logs::whereBetween('start_time', [$s_StartTime,$s_EndTime])
        ->where('day',$s_Day)
        ->where('section',$section_name)
        ->where('subject',$subject_name)
        ->where('room',$s_Room)
        ->get();

        $units = units::where('room_id',$s_Room)->get();

        $studentList = Logs::
        where('created_at', '>=', $ymd.' '.$s_StartTime)
        ->where('created_at', '<=', $ymd.' '.$s_EndTime)
        ->where('section', $section_name)
        ->where('room', $s_Room)
        ->get();

        return view('forms.instructor_log', compact('section_name','schedule', 'unit','rid', 'units', 'sid', 'student_logs', 'studentList'));
    }

});

//login to student dashboard
Route::get('/student/dashboard', function(){
    $sections = sections::get();
    return view('student.studentdashboard', compact('sections'));
});

//logout
Route::get('/logouts', [LoginController::class, 'logout'])->name('logout');


// admin navigations
Route::get('/dashboard', function () {
    $logs = Logs::get();
    $sections = sections::get();
    return view('admin.dashboard', compact('logs', 'sections'));
});

Route::get('/addsched', function (){

    return view('admin.addsched', [
        'sections' => sections::get(),
        'subjects' => subjects::get(),
        'rooms' => rooms::get(),
        'instructors' => DB::table('users')
                ->join('usertypes', 'usertypes.id', "=", 'users.usertype_id')
                ->where('usertype', "=", 'Instructor')
                ->get(),
        'schedules' => DB::table('schedules')
                ->select('schedules.id', 'schedules.day', 'schedules.start_time', 'schedules.end_time', 'rooms.room', 'users.fname', 'users.lname', 'subjects.subject')
                ->join('subjects', 'subjects.id', "=", 'schedules.subject_id')
                ->join('users', 'users.id', "=", 'schedules.instructor')
                ->join('rooms', 'rooms.id', "=", 'schedules.room')
                ->get(),

    ]);

});

Route::get('/section', function (){
    $room = rooms::get();
    $subject = subjects::get();
    $instructor = DB::table('users')
                ->join('usertypes', 'usertypes.id', "=", 'users.usertype_id')
                ->where('usertype', "=", 'Instructor')
                ->get();
    return view('admin.section', [
        'sections' => sections::get(),
        'rooms' => $room,
        'subjects' => $subject,
        'instructors' => $instructor

    ]);
});

Route::get('/subject', function (){
    return view('admin.subject', [
        'subjects' => subjects::get()
    ]);
});

Route::get('/users', function (){
    $user = Users::count();
    $genNumber = $user+1;
    $idnumber = date('Ymd').$genNumber;
    return view('admin.users', [
        'sections' => sections::get(),
        'users' => DB::table('users')
                ->join('usertypes', 'usertypes.id', "=", 'users.usertype_id')
                ->get(),
        'idnumber' => $idnumber

    ]);
});

//addsection
Route::post('/addsection', [AddSection::class, 'addsection'])->name('addsec');
//addsubject
Route::post('/addsubject', [AddSubject::class, 'addsubject'])->name('addsub');
// addschedule
Route::post('/schedule', [AddSchedule::class, 'addschedule']);
// add laboratories
Route::post('/addlab', [AddRoom::class, 'lab'])->name('add_lab');
//add units on each laboratories
Route::post('/addunits', [AddUnit::class, 'addunit'])->name('addpc');
//generate units
Route::post('/generate', [AddUnit::class, 'generateUnit'])->name('generateUnit');

//delete section
Route::get('/section/delete/{id}', [AddSection::class, 'delete_section']);
//delete subject
Route::get('/subject/delete/{id}', [AddSubject::class, 'delete_subject']);
//delete users
Route::get('/users/delete/{id}', [SignUpController::class, 'delete_user']);
//delete schedules
Route::get('/schedule/delete/{id}', [AddSchedule::class, 'delete_sched']);

//view student list na naka time in
Route::get('instruc/timein', [LogsController::class, 'instruc_timein']);

//showing form for edting pc status
Route::get('/edit/sfufps/{labID}/{pcid}', [AddRoom::class, 'show_form']);
//showing form for editing pc status on instructor side
Route::get('/edit/instructorPC/{roomID}/{pcid}', [AddRoom::class, 'show_form_edit']);

// edit pc status and issue
Route::post('/edit_pc/{pcid}/{labID}', [EditController::class, 'editpc']);
// edit pc status and issue on instructor side
Route::post('/edit_unit/{pcid}/{roomID}', [EditController::class, 'editpcstatus']);

//allow status of each sections
// Route::get('/section/status/{sectionID}', [AddSection::class, 'secStatus']);
Route::post('/section/status/', [AddSection::class, 'secStatus']);
// Route::get('/hiddenID', [AddSection::class, 'hidid']);

//not allow status of each sections
Route::get('/status/section/{secID}', [AddSection::class, 'sectionStatus']);


//route for viewing specific lab details
Route::get('/room/view/{labID}', [AddRoom::class, 'show']);

//instructor view units
Route::get('/instructor/editpc/{roomID}', [AddRoom::class, 'instructor_showpc']);

//attendance
Route::get('/attendance/po/{roomID}', [AddRoom::class, 'attendance']);

//route for viewing students under that specific section
Route::get('/section/view/{id}', [AddSection::class, 'showSection']);

// edit user
Route::get('/edit/user/{id}', [EditController::class, 'edit_users']);
Route::post('/update/user/{id}', [EditController::class, 'update_user']);

//import units
Route::get('/import/form', [AddUnit::class, 'importForm']);
Route::post('/import/save', [AddUnit::class, 'SaveImportFile']);

// export units
Route::get('/export/file', [AddUnit::class, 'ExportFile']);

// export logs
Route::get('/export/logs',[LogsController::class, 'ExportLogs']);

//import users
Route::post('/save/import/users', [SignUpController::class, 'SaveUsersImport']);

//route for time in time out
Route::post('/users/log', [LogsController::class, 'log'])->name('log');
//instructor time in and time out
Route::post('/instructor/log', [LogsController::class, 'instructor_log'])->name('logs');
Route::get('/proflogs', [LogsController::class, 'prof_logs']);


Route::get('/instructor/editspcs', function() {
    return redirect('/instructor/timein');
});


// route for time in na inallow ni admin
Route::post('/allowed/log', [LogsController::class, 'allowedtimein']);

// for redirect to student_logs.blade.php
Route::get('/users/timein', function(){
    $user_id = Session::get('user_id');
    $user_mname = Session::get('user_firstname');
    $user_lname = Session::get('user_lastname');
    $mylogs = Logs::where('user_id', $user_mname.' '.$user_lname)->orderBy('created_at', 'desc')->first();
    // dd($mylogs);
    return view('forms.student_logs', compact('mylogs'));

});
//redirect to instructor_log.blade.php
Route::get('/instructor/timein', function(Request $request){
    // $SchedID = Session::get('SecID');
    $SchedID = $request->sid;
    // dd($SchedID);
    $user_id = Session::get('user_id');
    $user_mname = Session::get('user_firstname');
    $user_lname = Session::get('user_lastname');
    $mylogs = Logs::where('user_id', $user_mname.' '.$user_lname)->orderBy('created_at', 'desc')->first();
    $roomID = $mylogs->room;
    // dd($sub);
    $time = $mylogs->start_time;
    $one_hour_later = date('H:i:s', strtotime('+1 hour', strtotime($time)));

    $logs = Logs::whereBetween('start_time', [$time, $one_hour_later])->where('room',$roomID)->get();

    $log = Logs::where('instructor');
    $units = units::where('room_id',$roomID)->get();
    return view('forms.instructor_log', compact('mylogs', 'roomID', 'units','logs'));

});

//student logout with logs after time in
Route::post('/users/timeout', [LogsController::class, 'timeout']);

// instructor logout and logs after time out
Route::post('/instructor/timeout', [LogsController::class, 'instructor_timeout']);

//refresh table hahaha
Route::get('/get-updated-table-data', [LogsController::class, 'refresh_table']);
