<?php

namespace App\Http\Controllers;

use App\Models\sections;
use App\Models\units;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditController extends Controller
{
    public function editpc(Request $request, $pcid, $lid){
        // dd($lid);
        $pc = units::find($lid);
        // dd($pc);

        $pc->status = $request->status;
        $pc->issue = $request->issue;

        $pc->update();

        return redirect('/room/view/'.$pcid)->with('updated', 'Updated Successfully');
    }
    public function editpcstatus(Request $request, $pcid, $lid){
        // dd($lid);
        $pc = units::find($lid);
        // dd($pc);

        $pc->status = $request->status;
        $pc->issue = $request->issue;

        $pc->update();

        return redirect()->back();

        return redirect('instructor/editpc/'.$pcid)->with('updated', 'Updated Successfully');
    }

    public function edit_users(Request $request, $id)
    {
        $edit = DB::table('users')
                ->join('sections', 'sections.id', "=", 'users.section_id')
                ->where('users.id', $id)
                ->get();

        $sections = sections::get();
        return view('forms.edit_users', compact('edit', 'id','sections'));
    }

    public function update_user(Request $request, $id)
    {
        $update_student = Users::find($id);

        $update_student->fname = $request->fname;
        $update_student->mname = $request->mname;
        $update_student->lname = $request->lname;
        $update_student->email = $request->email;
        $update_student->section_id = $request->section;
        $update_student->course = $request->course;

        $update_student->update();

        return redirect('/users')->with('updated', 'Updated Successfully');
    }
}
