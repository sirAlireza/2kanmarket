<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\UserRequest;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UserController extends Controller
{
   public function index(Request $request)
   {
       $user=User::orderBy('id','DESC')->paginate(10);
       return View('admin.user_list',['user'=>$user]);
   }
   public function destroy($id)
   {
      $user=User::findOrFail($id);
      $user->delete();
      return redirect()->back();
   }
   public function show($id)
   {
       $user=User::findOrFail($id);
       $order=Order::where(['user_id'=>$id])->orderBy('id','DESC')->get();
       $total_price=Order::where(['user_id'=>$id,'pay_status'=>1])->sum('price');

       $have_info = DB::table('users_informations')->where('user_id', $id)->first();

       if($have_info) {
           $name = $have_info->name;
           $lastname = $have_info->lastname;
           $birthday = $have_info->birthday;
           $phone = $have_info->phone;
           $person_id = $have_info->person_id;
           $moaref_id = $have_info->moaref_id;
           return View('admin.show_user_data', ['user' => $user, 'order' => $order, 'total_price' => $total_price,'name' => $name,"lastname" => $lastname,"birthday"=>$birthday,"phone"=>$phone,"person_id"=>$person_id,"moaref_id"=>$moaref_id]);
       }
       return View('admin.show_user_data',['user'=>$user,'order'=>$order,'total_price'=>$total_price]);
   }
   public function create()
   {
       return View('admin.create_user');
   }
   public function store(UserRequest $request)
   {
      $user=new User($request->all());
      $user->password=bcrypt($request->get('password'));
      $user->saveOrFail();
      $url='admin/user/'.$user->id.'/edit';
      return redirect($url);
   }
   public function edit($id)
   {
       $user=User::findOrFail($id);
       return View('admin..update_user',['user'=>$user]);
   }
   public function update(UserRequest $request,$id)
   {
       $user=User::find($id);
       $user->username=$request->get('username');
       if(!empty($request->get('password')))
       {
           $user->password=bcrypt($request->get('username'));
       }
       $user->role=$request->get('role');
       $user->update();
       $url='admin/user/'.$user->id.'/edit';
       return redirect($url);
   }
}
