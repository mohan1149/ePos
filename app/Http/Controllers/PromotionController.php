<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Branch;
use Illuminate\Http\Request;

class PromotionController extends Controller
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
            $promotions = Promotion::where('promotions.created_by',auth()->user()->id)
            ->join('branches','branches.id','=','promotions.branch')
            ->select(['promotions.*','branches.branch'])
            ->get();

            return view('promotions.index',['promotions'=>$promotions]);
        } catch (\Exception $e) {
            return $e->getMessage();
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
            $branches =  Branch::where('created_by',auth()->user()->id)->pluck('branch','id');
            return view('promotions.create',['branches'=>$branches]);
        } catch (\Exception $e) {
            return $e->getMessage();
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
        //
        try {
            $promotion = new Promotion();
            $promotion->promotion_code = $request['promotion_code'];
            $image = $request->file('promo_image');
            if($image !=""){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                $promotion->promotion_banner = $url;
            }
            $promotion->branch = $request['branch'];
            $promotion->promotion_expiry = $request['promotion_expiry'];
            $promotion->promotion_discount = $request['promotion_discount'];
            $promotion->created_by = auth()->user()->id;
            $promotion->save();
            return redirect('/promotions');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
        try {
            $branches = Branch::where('created_by',auth()->user()->id)->pluck('branch','id');
            return view('promotions.edit',['branches'=>$branches,'promotion'=>$promotion]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        //
        try {
            $promotion->promotion_code = $request['promotion_code'];
            $image = $request->file('promo_image');
            if($image !=""){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                $promotion->promotion_banner = $url;
            }
            $promotion->branch = $request['branch'];
            $promotion->promotion_expiry = $request['promotion_expiry'];
            $promotion->promotion_discount = $request['promotion_discount'];
            $promotion->save();
            return redirect('/promotions');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        //
    }
}
