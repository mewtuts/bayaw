<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\proflogs;
use App\Models\rooms;
use App\Models\schedules;
use App\Models\sections;
use App\Models\subjects;
use App\Models\units;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session as FacadesSession;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;
use Illuminate\Support\Facades\Session;
use Psy\Command\WhereamiCommand;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

use function PHPUnit\Framework\isEmpty;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        if (isset($request->login))
        {
            $sections = sections::get();
            $user = DB::table('users')
                ->select()
                ->join('usertypes', 'usertypes.id', "=", 'users.usertype_id')
                ->where('username', $request->username)
                ->where('password', $request->password)
                ->first();


            if ($user)
            {
                switch ($user->usertype) {
                    case 'Student':
                    // JOINING USERS & USERTYPES TABLE TO GATHER DATA.
                        $instructors = DB::table('users')
                        ->join('usertypes', 'usertypes.id', "=", 'users.usertype_id')
                        ->where('usertype', "=", 'Instructor')
                        ->get();

                        $pc = units::get();
                        $room = DB::table('rooms')->get();
                        $subject = subjects::get();
                    // JOINING UNITS & ROOMS TO GATHER DATA.
                        $lab = DB::table('units')
                        // ->select('rooms.id','rooms.room','units.id','units.pc_number')
                        ->join('rooms', 'rooms.id', '=', 'units.room_id')
                        ->get()
                        ->groupBy('room_id');

                        session()->put('user_firstname', $user->fname);
                        session()->put('user_lastname', $user->lname);
                        session()->put('user_id', $user->id);
                    // JOINING USERS & SECTIONS TO GATHER DATA.
                        $sec = DB::table('users')
                        ->join('sections','sections.id','=','users.section_id')
                        ->where('username', Session::get('user_firstname'))
                        ->first();

                        $secID = $sec->id;
                        $lab = session()->get('labrooms');
                        $subjects = session()->get('ssubj');
                        $profesor = session()->get('sprof');
                        $sectionIDs = session()->get('ssecID');
                    // JOINING UNITS & ROOMS TABLE TO GATHER DATA.
                        $pcs = DB::table('units')
                        ->join('rooms','rooms.id','units.room_id')
                        ->where('units.room_id', $lab)
                        ->get();
                    // GETTING ONLY SPECIFIC ROOM.
                        $rom = rooms::where('id',$lab)->first();
                    // DECLARING ASIAN DATE TO A VARIABLE.
                        $date = Carbon::now();
                        $asianDate = $date->format('H:i');
                        $asianDateDay = $date->format('l');
                    // GETTING USER (STUDENT) SCHEDULE.
                        $schedule = Users::join('schedules', 'schedules.instructor', '=', 'users.id')
                        ->where('schedules.section_id', $user->section_id)
                        ->where('schedules.start_time', '<=', $asianDate)
                        ->where('schedules.end_time', '>=', $asianDate)
                        ->where('schedules.day', 'like', '%'.$asianDateDay.'%')
                        ->get();
                    // GETTING ONLY ONE ROW USER SCHEDULE.
                        $schedule1 = Users::join('schedules', 'schedules.instructor', '=', 'users.id')
                        ->where('schedules.section_id', $user->section_id)
                        ->where('schedules.start_time', '<=', $asianDate)
                        ->where('schedules.end_time', '>=', $asianDate)
                        ->where('schedules.day', 'like', '%'.$asianDateDay.'%')
                        ->first();
                    // MAKING A CONDITION, FOR CHECKING A USER/STUDENT IF HE/SHE HAS SCHEDULE THIS DAY.
                        if(empty($schedule1)){
                            $rid = 0;
                            $sid = 0;
                            $unit[] = 0;
                            $STIME = 0;
                            $ETIME = 0;
                            $SEC = 0;
                            $LAB = 0;
                        }else{
                            $rid =  $schedule1->room;
                            $unit = units::where('room_id', $schedule1->room)->get();
                            $sid = $schedule1->id;
                        // VARIABLE FOR CHECKING AVAILABLE PC TO USE.
                            $STIME = $schedule1->start_time;
                            $ETIME = $schedule1->end_time;
                            $SEC = $sec->section;
                            $LAB = $schedule1->room;

                        }
                    // REDIRECT THE USER/STUDENT INTO STUDENT HOME PAGE.
                        return view('student.student', compact('STIME','ETIME','SEC','LAB','schedule','sectionIDs','profesor','subjects','lab','secID','pcs', 'unit', 'rid', 'sid', 'sections','sec', 'lab','instructors','room','rom','subject','pc'));
                        break;


                    /** <-----------LOGIN AS INSTRUCTOR-------------->  */
                    case 'Instructor':
                        session()->put('user_firstname', $user->fname);
                        session()->put('user_lastname', $user->lname);
                        session()->put('user_id', $user->id);
                        $user_mname = Session::get('user_firstname');
                        $user_lname = Session::get('user_lastname');

                        $date = Carbon::now();
                        $asianDate = $date->format('H:i');
                        $asianDateDay = $date->format('l');

                        $schedule1 = Users::join('schedules', 'schedules.instructor', '=', 'users.id')
                        ->where('schedules.start_time', '<=', $asianDate)
                        ->where('schedules.end_time', '>=', $asianDate)
                        ->where('schedules.day', 'like', '%'.$asianDateDay.'%')
                        ->where('schedules.instructor', $user->id)
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
                            // dd($units);

                            $studentList = Logs::
                            where('created_at', '>=', $ymd.' '.$s_StartTime)
                            ->where('created_at', '<=', $ymd.' '.$s_EndTime)
                            ->where('section', $section_name)
                            ->where('room', $s_Room)
                            ->get();

                            return view('forms.instructor_log', compact('section_name','schedule', 'unit','rid', 'units', 'sid', 'student_logs', 'studentList'));
                        }
                        break;
                    /** <-----------END LOGIN AS INSTRUCTOR-------------->  */


                    /** <----------------LOGIN AS ADMIN------------------>  */
                    case 'Admin':
                        session()->put('user_firstname', $user->fname);
                        $logs = Logs::get();
                        return view('admin.dashboard', compact('logs', 'sections'));
                        break;
                    /** <---------------END LOGIN AS ADMIN-------------->  */


                    default:
                        return Redirect("pages/login")->with('message', 'Something went wrong');
                }
            }
            else
            {
                return redirect()->back()->with('err', 'Something Went Wrong');
            }
        }
        else
        {
            // return view('welcome')->with('message', 'something went wromg');
        }
    }

    public function logout()
    {
        // Session::flush();
        return view('welcome');
    }

    // public function customLogout(Request $request)
    // {
    //     $this->guard()->logout();
    //     $request->session()->invalidate();
    //     return redirect('welcome');
    // }
}
