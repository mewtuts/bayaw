<?php

namespace App\Http\Controllers;

use App\Models\units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableditController extends Controller
{
    function index()
    {
        $data = DB::table('units')->get();
        return view('practice.InlineEditTbale', compact('data'));
    }

    function action(Request $request)
    {
        dd($request->id);
        if($request->ajax())
        {
            if($request->action == 'edit')
            {
                $updated = units::find($request->id);
                $updated->status = $request->status;
                $updated->issue = $request->issue;

                $updated->save();

                return redirect()->back();

            }
            return response()->json($request);
        }
    }
}
