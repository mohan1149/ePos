<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Setting;


class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function listUsers()
    {
        if(auth()->user()->role === 3){
            try {
                $users = User::where('role',1)->get();
                return view('users.index',['users'=>$users]);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            return abort(403);
        }
    }
    
    public function addUser(){
        if(auth()->user()->role === 3){
            try {
                return view('users.create');
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            return abort(403);
        }
        
    }

    public  function storeUser(Request $request)
    {
        if(auth()->user()->role === 3){
            try {
                $user = new User();
                $avatar = $request->file('avatar');
                $image_name  = uniqid().'.'.$avatar->getClientOriginalExtension();
                $destination = 'storage/avatars';
                $avatar->move($destination, $image_name);
                $url = $request->getSchemeAndHttpHost().'/storage/avatars/'.$image_name;
                $user->name = strip_tags($request['username']);
                $user->email = strip_tags($request['email']);
                $user->phone = strip_tags($request['phone']);
                $user->role = 1;
                $user->branch = 0;
                $user->created_by = 0;
                $user->avatar = $url;
                $user->password = Hash::make($request['password']);
                $user->save();
                $setting = new Setting();
                $setting->created_by = $user->id;
                $setting->decimal_points = 3;
                $setting->enable_bookings = 0;
                $setting->enable_home_service = 0;
                $setting->enable_device_linking = 0;
                $setting->save();
                return redirect('/users');
            } catch (\Exception $e) {
                return abort(500);
            }
        }else{
            return abort(403);
        }
    }
}
