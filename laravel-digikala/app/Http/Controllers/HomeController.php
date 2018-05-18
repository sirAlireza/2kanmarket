<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function user_edit()
    {
        $id=Auth::user()->id;
        $have_info = DB::table('users_informations')->where('user_id', $id)->first();
        if($have_info)
        {
            $name=$have_info->name;
            $lastname=$have_info->lastname;
            $birthday=$have_info->birthday;
            $phone=$have_info->phone;
            $person_id=$have_info->person_id;
            $moaref_id=$have_info->moaref_id;
            return view("user/user_edit",['name' => $name,"lastname" => $lastname,"birthday"=>$birthday,"phone"=>$phone,"person_id"=>$person_id,"moaref_id"=>$moaref_id]);
        }
        return view('user/user_edit');
    }
    public function user()
    {
        $id=Auth::user()->id;
        $have_info = DB::table('users_informations')->where('user_id', $id)->first();

        if($have_info)
        {
        $name=$have_info->name;
        $lastname=$have_info->lastname;
        $birthday=$have_info->birthday;
        $phone=$have_info->phone;
        $person_id=$have_info->person_id;
        $moaref_id=$have_info->moaref_id;
        return view("user/user",['name' => $name,"lastname" => $lastname,"birthday"=>$birthday,"phone"=>$phone,"person_id"=>$person_id,"moaref_id"=>$moaref_id]);
        }


        return view("user/user_edit");
    }


    public function user_edit_info(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:15',
            'lastname' => 'required|min:2|max:20',
            'birtday' => 'date',
            'phone' => 'required|digits:11',
            'person_id' => 'required|digits:10',
            'moaref_id' => 'required|digits:5',
//            'password' => 'confrim',



        ]);

        $id=Auth::user()->id;
        $have_info = DB::table('users_informations')->where('user_id', $id)->first();
        $name = $request->input('name');
        $lastname = $request->input('lastname');
        $birthday = $request->input('birthday');
//        $pass1 = $request->input('password1');
//        $pass2 = $request->input('password2');
        $phone = $request->input('phone');
        $person_id = $request->input('person_id');
        $moaref_id = $request->input('moaref_id');

        //echo $have_info->name;
        if($have_info=="[]")
            {
                //insert
                DB::table('users_informations')->insert(
                    ['name' => $name, 'lastname' => $lastname,'birthday' => $birthday,'phone' => $phone ,'person_id' => $person_id,'moaref_id' => $moaref_id,'user_id' => $id]

                );
            }
        else
            {
                //update
                DB::table('users_informations')
                    ->where('id', $id)
                    ->update(['name' => $name, 'lastname' => $lastname,'birthday' => $birthday,'phone' => $phone ,'person_id' => $person_id,'moaref_id' => $moaref_id,'user_id' => $id]);
        }

        return redirect('user');
    }
    public function user_edit_pass(Request $request)
    {
        $id=Auth::user()->id;
        $request->validate(['password' => 'confirmed|min:5|max:15']);
        $pass=bcrypt($request->input("password"));
        DB::table('users')
            ->where('id', $id)
            ->update(['password' => $pass]);
        
        return redirect('user');

    }
}
