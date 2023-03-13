<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Branch;
use App\Models\Category;
use App\Models\ServiceOrder;



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
    
    public function addServiceOrder(Request $request){
        try {
            $prevInv = ServiceOrder::where('oid', $request['oid'])->max('invoice_id');
            $serviceOrder = new ServiceOrder();
            $serviceOrder->oid = $request['oid'];
            $serviceOrder->invoice_id =  $prevInv + 1;
            $serviceOrder->created_by = $request['created_by'];
            $serviceOrder->service_staff = $request['selected_staff'];
            $serviceOrder->customer_name = $request['name'];
            $serviceOrder->service_category = $request['selected_category'];
            $serviceOrder->services = json_encode($request['selected_types']);
            $serviceOrder->payment_type = $request['payType'];
            $serviceOrder->notes = $request['notes'];
            $serviceOrder->total_amount = $request['total_amount'];
            $serviceOrder->save();
            return response()->json([
                'status'=>true,
                'data'=>$serviceOrder,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
            ], 200);
        }
    }
}