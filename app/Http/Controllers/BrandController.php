<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Branch;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            $brands = Brand::where('brands.created_by',auth()->user()->id)
            ->join('branches as branch','branch.id','=','brands.branch')
            ->select(['brands.*','branch.branch'])
            ->get();
            return view('brands.index',['brands'=>$brands]);
        } catch (\Exception $e) {
            return $e->getMessage();
            return abort(500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        try {
            $branches = Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id');
            return view('brands.create',['branches'=>$branches]);
        } catch (\Exception $e) {
            return abort(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $brand = new Brand();
            $brand->name = $request['brand_name'];
            $image = $request->file('avatar');
            if($image !=""){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                $brand->brand_avatar = $url;
            }
            $brand->branch = $request['branch'];
            $brand->created_by = auth()->user()->id;
            $brand->save();
            return redirect('/brands');
        } catch (\Exception $e) {

            return abort(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        try {
            $branches = Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id');
            return view('brands.edit',['branches'=>$branches,'brand'=>$brand]);
        } catch (\Exception $e) {
            return abort(500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
        try {
            $brand->name = $request['brand_name'];
            $image = $request->file('avatar');
            if($image !=""){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                $brand->brand_avatar = $url;
            }
            $brand->branch = $request['brand_branch'];
            $brand->created_by = auth()->user()->id;
            $brand->save();
            return redirect('/brands');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }


    public function getBrandsBranchId($id){
        try {
            $brands = Brand::where('branch',$id)->get();
            return $brands;
        } catch (\Throwable $th) {
            return [];
        }
    }
}
