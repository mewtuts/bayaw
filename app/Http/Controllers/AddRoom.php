<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\rooms;
use App\Models\units;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class AddRoom extends Controller
{
    public function lab(Request $request)
    {
        $lab = new rooms();
        $lab->room = $request->lab;

        $lab->save();
        return back()->with('added_lab', 'Seccessfull Added');
    }

    public function show(Request $request, $lid){

        $units = units::where('room_id',$lid)->get();

        return view('admin.roomshow', compact('units', 'lid'));
        // $explode = explode(",", $id);
        // $laboratory_number = $explode[0];
        // $units = units::where('room_id', $explode[0])->get();
        // $labnum = rooms::where('id', $laboratory_number)->get('room');
        // // dd($labnum);
        // return view('admin.roomshow', compact('units', 'labnum', 'laboratory_number'));
    }
    public function instructor_showpc(Request $request, $roomID){

        $units = DB::table('units')
            ->where('room_id',$roomID)
            ->get();
        // dd($units);

        $date1 = Carbon::now();
        $ymd = $date1->format('Y-m-d');

        $attendance = Logs::
        where('created_at', 'like', '%'.$ymd.'%')
        ->where('room', $roomID)
        ->get();

        // $units = units::where('room_id',$roomID)->get();
        return view('forms.instructor_editunits', compact('units', 'roomID', 'attendance'));
    }

    public function attendance(Request $request, $roomID)
    {
        $date1 = Carbon::now();
        $ymd = $date1->format('Y-m-d');

        $attendance = Logs::
        where('created_at', 'like', '%'.$ymd.'%')
        ->where('room', $roomID)
        ->get();

        return view('forms.attendance', compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        // Retrieve the record to update
        $pc = units::findOrFail($id);

        // Update the record with the new data
        $pc->status = $request->status;
        $pc->issue = $request->issue;
        $pc->save();

        // Redirect the user back to the previous page with a success message
        return view('admin.roomshow', compact('pc'));
    }

    public function show_form($lid,$pcid){
        // $explode = explode(",", $labid);
        // $laboratory_number = $explode[0];
        // //$units = units::where('room_id', $explode[0])->get();
        $pc = units::find($pcid);
        // dd($pc);
        return view('forms.pcstatus', compact('pcid', 'pc', 'lid'));
    }

    public function show_form_edit($roomID,$pcid){
        // $explode = explode(",", $labid);
        // $laboratory_number = $explode[0];
        // //$units = units::where('room_id', $explode[0])->get();
        $pc = units::find($pcid);
        // dd($pc);

        return view('forms.showformedit', compact('pcid', 'pc', 'roomID'));
    }

}
