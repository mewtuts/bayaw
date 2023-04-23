<?php

namespace App\Http\Controllers;

use App\Models\schedules;
use App\Models\sections;
use App\Models\subjects;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddSchedule extends Controller
{
    public function addschedule(Request $request) 
    {
        //pagsasave ng schedule sa schedule table
        $sched = new schedules();
        $sched->day = $request->m.$request->t.$request->w.$request->th.$request->f;
        $sched->start_time = $request->start_time;
        $sched->end_time = $request->end_time;
        $sched->room = $request->lab_num;
        $sched->instructor = $request->instructor;
        $sched->section_id = $request->section;
        $sched->subject_id = $request->subject;
        $sched->users_id = $request->user_id;
        
        $sched->save();
        return redirect()->back();
    }
    public function delete_sched(Request $request, $id)
    {
        
        $schedule = schedules::find($id);

        $schedule->delete();
        return redirect()->back()->with('success', 'successfully delete schedule');

    }
}
