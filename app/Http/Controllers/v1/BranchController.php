<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Branch;
class BranchController extends Controller
{
    public function create($request){
        try {
            $branch = new Branch();
            $branch->created_by = $request['uid'];
            $branch->branch = $request['branch'];
            $branch->address = $request['address'];
            $branch->phone = $request['phone'];
            $branch->email = $request['email'];
            $branch->instagram = $request['instagram'];
            $image = $request->file('branch_logo');
            $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
            $destination = 'storage/products';
            $image->move($destination, $image_name );
            $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
            $branch->logo = $url;
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
            $branch = Branch::find($id);
            $branch->branch = $request['branch'];
            $branch->address = $request['address'];
            $branch->phone = $request['phone'];
            $branch->email = $request['email'];
            $branch->instagram = $request['instagram'];
            $image = $request->file('branch_logo');
            if(isset($image)){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                $branch->logo = $url;
            }
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



    //for control panel
    public function getMyBranches(){

        try {
            $branches =  Branch::where('created_by',auth()->user()->id)->get();
            return view('branches.index',['branches'=>$branches]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}