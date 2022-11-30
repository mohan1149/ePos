<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Branch;



class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */


    public function create(){
        try {
            $branches = Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id');
            return view('users.employee.create',['branches'=>$branches]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function store(Request $request){
        try {
            $user = new User();
            $avatar = $request->file('avatar');
            $image_name  = uniqid().'.'.$avatar->getClientOriginalExtension();
            $destination = 'storage/avatars';
            $avatar->move($destination, $image_name);
            $url = $request->getSchemeAndHttpHost().'/storage/avatars/'.$image_name;
            $user->name = strip_tags($request['name']);
            $user->email = strip_tags($request['email']);
            $user->phone = strip_tags($request['phone']);
            $user->role = $request['driver'] == 'on' ? 2 : 0; 
            $user->branch = $request['branch'];
            $user->created_by = auth()->user()->id;
            $user->avatar = $url;
            $user->password = Hash::make($request['password']);
            $user->save();
            return redirect('/users');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function index(){
        try {
            $users = User::whereIn('role',[0,2])
            ->where('created_by',auth()->user()->id)
            ->get();
            return view('users.employee.index',['users'=>$users]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function edit(User $user){
        try {
            $branches = Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id');
            return view('users.employee.edit',['branches'=>$branches,'user'=>$user]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function update(User $user,Request $request){
        try {
            $avatar = $request->file('avatar');
            if($avatar !== ""&& isset($avatar)){
                $image_name  = uniqid().'.'.$avatar->getClientOriginalExtension();
                $destination = 'storage/avatars';
                $avatar->move($destination, $image_name);
                $url = $request->getSchemeAndHttpHost().'/storage/avatars/'.$image_name;
                $user->avatar = $url;
            }
            $user->name = strip_tags($request['name']);
            $user->phone = strip_tags($request['phone']);
            $user->role = $request['driver'] == 'on' ? 2 : 0; 
            $user->branch = $request['branch'];
            $user->save();
            return redirect('/users');
        } catch (\Exception $e) {
            return $e->getMessage();

        }
    }

    public function getAdmins()
    {
        if(auth()->user()->role === 3){
            try {
                $users = User::where('role',1)->get();
                return view('users.admin.index',['users'=>$users]);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            return abort(403);
        }
    }
    
    public function addAdmin(){
        if(auth()->user()->role === 3){
            try {
                return view('users.admin.create');
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            return abort(403);
        }
        
    }

    public  function storeAdmin(Request $request)
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
                $user->multi_branch = $request['multi_branch'] == "on" ? 1 : 0 ;
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
                return $e->getMessage();
            }
        }else{
            return abort(403);
        }
    }
}
