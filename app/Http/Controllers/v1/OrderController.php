<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Setting;

class OrderController extends Controller
{
    public function orderForPushNotification($id){
        try {
            $order = Order::find($id);
            $setting = Setting::where('created_by',$order->created_for)->select(['decimal_points'])->first();
            return [
                'order'=>$order,
                'settings' => $setting,
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create($request){
        try {
            $uid = $request['uid'];
            $name = $request['branch'];
            $address = $request['address'];
            $branch = new Branch();
            $branch->created_by = $uid;
            $branch->branch = $name;
            $branch->address = $address;
            $branch->save();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function index($id){
        try {
            return Branch::where('created_by',$id)->get();
        } catch (\Exception $e) {
            return [];
        }
    }
    public function update($request){
        try {
            $id = $request['id'];
            $name = $request['branch'];
            $address = $request['address'];
            $branch = Branch::find($id);
            $branch->branch = $name;
            $branch->address = $address;
            $branch->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function destroy($id){
        try {
            $branch = Branch::find($id);
            $branch->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function show($id){
        try {
            return Branch::find($id);
        } catch (\Exception $e) {
            return "";
        }
    }
}