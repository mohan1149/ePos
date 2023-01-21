<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Branch;
use App\Models\Category;



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


    public function listServices(){
        try {
            $services =  Service::where('services.created_by',auth()->user()->id)
            ->join('branches','branches.id','=','services.branch')
            ->join('categories','categories.id','=','services.category')
            ->select(['services.*','branches.branch','categories.category'])
            ->get();
            return view('services.index',['services'=>$services]);
        } catch (\Exception $e) {
           return $e->getMessage();
        }
    }

    public function create(){
        try {
            $branches =  Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id')->prepend(__("t.choose"),0);
            return view('services.create',['branches'=>$branches]);
        } catch (\Exception $e) {
           return $e->getMessage();
        }
    }

    public function store(Request $request){
        try{
            $service = new Service();
            $image = $request->file('service_image');
            $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
            $destination = 'storage/products';
            $image->move($destination, $image_name );
            $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
            $service->created_by = auth()->user()->id;
            $service->service_image = $url;
            $service->name = $request['name'];
            $service->price = $request['price'];
            $service->branch = $request['branch'];
            $service->category = $request['category'];
            $service->save();
            return redirect('/services');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function edit($id){
        try {
            $service = Service::find($id);
            $branches =  Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id')->prepend(__("t.choose"),0);
            $categories = Category::where('branch',$service->branch)->where('type',1)->get()->pluck('category','id');
            return view('services.edit',['service'=>$service,'branches'=>$branches,'categories'=>$categories]);
        } catch (\Exception $e) {
           return $e->getMessage();
        }
    }

    public function updateService(Request $request){

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
            return redirect('/services');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
}