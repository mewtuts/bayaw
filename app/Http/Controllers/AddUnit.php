<?php

namespace App\Http\Controllers;

use App\Exports\UnitsExport;
use App\Imports\UnitsImport;
use App\Models\rooms;
use App\Models\units;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class AddUnit extends Controller
{
    public function addunit(Request $request)
    {
        $units = new units();
        $units->room_id = $request->lab_num;
        $units->pc_number = $request->pc_num;
        $units->status = $request->status;
        $units->issue = $request->issue;

        if (!$units->save()) {
            return redirect()->back();
        }
        else{
            return redirect()->back();
        }
    }

    public function importForm()
    {
        $array[] = 0;
        for ($i=1; $i <= 40; $i++) { 
            $array[] = $i;
        }

        $rooms = rooms::select('id','room')->get();
        // dd($rooms);
        $unit = units::get();
        
        // $lab = DB::table('units')
        //     ->join('rooms', 'rooms.id', '=', 'units.room_id')
        //     ->selectRaw('count(pc_number) as pc')
        //     ->groupBy('rooms.id')
        //     ->update(['rooms.available_unit' => DB::raw('pc_number')]);
        // DB::table('units')
        //     ->join('rooms', 'rooms.id', '=', 'units.room_id')
        //     ->selectRaw('rooms.room, count(pc_number) as pc')
        //     ->groupBy('room_id')
        //     ->update(['table1.count' => DB::raw('count')]);
        // $units = DB::table('units')
        //     ->join('rooms', 'rooms.id', '=', 'units.room_id')
        //     ->selectRaw('count(*) as pc')
        //     ->groupBy('rooms.room')
        //     ->get();
        // dd($units);


        return view('admin.room', compact('unit','rooms','array'));
    }

    public function SaveImportFile(Request $request)
    {
        FacadesExcel::import(new UnitsImport,$request->import_file);
        return redirect()->back()->with('imported', 'Imported Successfully');
    }

    public function ExportFile()
    {
        $date = Carbon::now();
        $dates = $date->format('Y-M-d l H:i');
        return FacadesExcel::download(new UnitsExport, $dates.' '.'Units-Record.xlsx');
        return redirect()->back()->with('imported', 'Imported Successfully');
    }

    public function generateUnit(Request $request)
    {
        
        for ($i=$request->from; $i <= $request->to; $i++) { 
            $unit = new units();
            $unit->pc_number = $i;
            $unit->room_id = $request->roomid;
            $unit->save();
        }
        
        // $lab = new rooms();

        // $units = DB::table('units')
        //     ->join('rooms', 'rooms.id', '=', 'units.room_id')
        //     ->selectRaw('count(*) as pc')
        //     ->groupBy('rooms.room')
        //     ->get();
        
        // $lab->available_unit = $units;

        // $lab->update();
        return redirect()->back();

    }
}
