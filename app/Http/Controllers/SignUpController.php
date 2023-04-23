<?php

namespace App\Http\Controllers;

use App\Imports\UserImports;
use App\Models\sections;
use App\Models\User;
use App\Models\Users;
use App\Models\Usertypes;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SignUpController extends Controller
{
    public function SignUp(Request $request)
    {
        $user = Users::count();
        $genNumber = $user+1;
        $idnumber = date('Ymd').$genNumber;
        
        if ($request->user_type == 'Student') {
            $type_of_user = new Usertypes();
            $type_of_user->usertype = $request->user_type;
            $type_of_user->save();

            $type_of_user_id = Usertypes::select('id')->orderBy('created_at', 'desc')->first();

            $user = new Users();
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->lname = $request->lname;
            $user->id_number = $idnumber;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = $request->password;
            $user->course = $request->course;
            $user->usertype_id = $type_of_user_id->id;
            $user->section_id = $request->section;

            if (!$user->save()) {
                return redirect()->back();
            }
            else{
                return redirect()->back()->with('message', 'Registered Successfully');
            }
            
        }
        
        elseif ($request->user_type == 'Instructor') {
            $type_of_user = new Usertypes();
            $type_of_user->usertype = $request->user_type;

            if (!$type_of_user->save()) 
            {
                return view('signup');
            }
            else
            {
                $type_of_user_id = Usertypes::select('id')->orderBy('created_at', 'desc')->first();

                $user = new Users();
                $user->fname = $request->fname;
                $user->mname = $request->mname;
                $user->lname = $request->lname;
                $user->id_number = $idnumber;
                $user->email = $request->email;
                $user->username = $request->username;
                $user->password = $request->password;
                $user->usertype_id = $type_of_user_id->id;

                $user->save();

                return redirect()->back()->with('message', 'Registered Successfully');
            }
        }
        
        elseif ($request->user_type == 'Admin') {
            $type_of_user = new Usertypes();
            $type_of_user->usertype = $request->user_type;

            if (!$type_of_user->save()) 
            {
                return view('signup');
            }
            else
            {
                $type_of_user_id = Usertypes::select('id')->orderBy('created_at', 'desc')->first();

                $user = new Users();
                $user->fname = $request->fname;
                $user->mname = $request->mname;
                $user->lname = $request->lname;
                $user->id_number = $idnumber;
                $user->email = $request->email;
                $user->username = $request->username;
                $user->password = $request->password;
                $user->usertype_id = $type_of_user_id->id;
                $user->section_id = $request->id;

                $user->save();

                return redirect()->back()->with('message', 'Registered Successfully');
            }
        }
    }

    public function update(Request $request)
    {
        //condtion on comparing the user inputed id number over the id number stored on database
        $user_item = Users::select('id')->where('id_number', $request->id_number)->first();
        // dd($user_item);
        if ($user_item === null) {

            return back()->with('fail', 'ID Number is not enrolled');
        }
        else{
            
            $user = Users::find($user_item->id);
        
            $user->update([
                'email' => $request->email,
                'username' => $request->username,
                'password' => $request->password
            ]);
                return redirect('/');
        }
        
        
    }

    public function delete_user(Request $request, $id)
    {
        $users = Users::find($id);

        $users->delete();
        return redirect()->back()->with('success', 'successfully delete');
    }

    public function importuserform()
    {
        return view('admin.users');
    }

    public function SaveUsersImport(Request $request)
    {
        Excel::import(new UserImports,$request->import_file);
        return redirect()->back()->with('imported', 'Imported Successfully');
    }

    
}
