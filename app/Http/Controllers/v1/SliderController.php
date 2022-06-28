<?php

namespace App\Http\Controllers\v1;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        try {
            return Slider::where('created_by',$id)->get();
        } catch (\Exception $e) {
           return $e->getMessage();
        }
    }


    public function branchSliders($id){
        try {
            return Slider::where('branch',$id)->where('published',1)->get();
        } catch (\Exception $e) {
           return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($request)
    {
        //
        try {
            $slider = new Slider();
            $image = $request->file('slider_image');
            $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
            $destination = 'storage/products';
            $image->move($destination, $image_name );
            $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
            $slider->created_by = $request['uid'];
            $slider->slider_image = $url;
            $slider->slider_caption = $request['caption'];
            $slider->slider_text = $request['text'];
            $slider->published = $request['published'];
            $slider->branch = $request['branch'];
            $slider->category_id = $request['category'];
            $slider->save();
            return true;
        } catch (\Exception $e) {
           return false;
        }
    }

    public function edit($request)
    {
        try {
            $slider = Slider::find($request['id']);
            $image = $request->file('slider_image');
            if($image !=""){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $slider->slider_image = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
            }
            $slider->slider_caption = $request['caption'];
            $slider->slider_text = $request['text'];
            $slider->published = $request['published'];
            $slider->branch = $request['branch'];
            $slider->category_id = $request['category'];
            $slider->save();
            return true;
        } catch (\Exception $e) {
           return false;
        }
    }

   
    public function destroy($id)
    {
        try {
            $slider = Slider::find($id);
            $slider->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
