<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;


class ServiceController extends Controller
{
    public function createService($request){
        try {
            $uid = $request['uid'];
            $service = new Service();
            $image = $request->file('service_image');
            $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
            $destination = 'storage/products';
            $image->move($destination, $image_name );
            $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
            $service->created_by = $uid;
            $service->service_image = $url;
            $service->name = $request['name'];
            $service->price = $request['price'];
            $service->branch = $request['branch'];
            $service->category = $request['category'];
            $service->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function getServicesByCategoryId($id){
        try {
            return Service::where('category',$id)->select(['id','name','service_image','price'])->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function index($id){
        try {
            return Service::where('created_by',$id)->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function update($request){
        try {
            $id = $request['id'];
            $service = Service::find($id);
            $image = $request->file('service_image');
            if($image != "" && isset($image)){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                $service->service_image = $url;
            }
            $service->name = $request['name'];
            $service->price = $request['price'];
            $service->branch = $request['branch'];
            $service->category = $request['category'];
            $service->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function destroy($id){
        try {
            $service = Service::find($id);
            $service->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}