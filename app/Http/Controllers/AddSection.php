<?php

namespace App\Http\Controllers;

use App\Models\section;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddSection extends Controller
{
    public function addsection(Request $request) 
    {
        $section = new sections();
        $section->section = $request->section;

        $section->save();

        return back();
    }

    // public function hidid(Request $request)
    // {
    //     $hidID = $request->hiddedID;

    //     return view('admin.section', compact('hidID'));

    // }

    public function delete_section(Request $request, $id)
    {
        $section = sections::find($id);

        $section->delete();
        return redirect()->back()->with('success', 'successfully delete');
    }

    public function showSection(Request $request, $id)
    {
        $students = DB::table('users')
                    ->join('sections', 'sections.id', "=", 'users.section_id')
                    ->where('sections.id', $id)
                    ->get();

        $section = sections::select('section')->where('id', $id)->first();
        $secNum = $section->section;
    
        
        return view('forms.show_section', compact('students', 'secNum'));

    }

    public function secStatus(Request $request)
    {
        
        $room = $request->lab;
        $prof = $request->profname;
        $subj = $request->subject;
        $secID = $request->section_id;

        session()->put('labrooms',$room);
        session()->put('sprof',$prof);
        session()->put('ssubj',$subj);
        session()->put('ssecID',$secID);

        

        // $lab = session()->get('labrooms');
        // dd($lab);
        // dd($room, $prof, $subj, $secID);
        $status = sections::find($secID);
        $status->status = '1';
        $status->save();

        $message = $status->section.' is allowed to use laboratory';
        return redirect()->back()->with('allow', $message);

    }
    public function sectionStatus(Request $request, $sectionID)
    {
        $status = sections::find($sectionID);
        $status->status = '0';
        $status->save();

        $message = $status->section.' is not allowed to use laboratory';
        return redirect()->back()->with('notallow', $message);

    }
}
