<?php

namespace App\Http\Controllers;

use App\Models\subjects;
use Illuminate\Http\Request;

class AddSubject extends Controller
{
    public function addsubject(Request $request)
    {
        $subject = new subjects();
        $subject->subject = $request->subject;
        $subject->subject_code = $request->subject_code;

        $subject->save();

        return back();
    }

    public function delete_subject(Request $request, $id)
    {
        $subject = subjects::find($id);

        $subject->delete();
        return redirect()->back()->with('success', 'successfully delete subject');
    }
}
