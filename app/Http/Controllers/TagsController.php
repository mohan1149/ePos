<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\Branch;

use Illuminate\Http\Request;

class TagsController extends Controller
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
            $tags = Tags::where('branches.created_by',auth()->user()->id)
            ->join('branches','branches.id','=','tags.branch')
            ->get();
            return view('tags.index',['tags'=>$tags]);
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
            $branches = Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id');
            return view('tags.create',['branches'=>$branches]);
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
        try {
            $branch = new Tags();
            $branch->tag_name = $request['tag_name'];
            $branch->branch = $request['branch'];
            $branch->created_by = auth()->user()->id;
            $branch->save();
            return redirect('/tags');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function show(Tags $tags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {
            $tag = Tags::find($request['id']);
            $branches = Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id');
            return view('tags.edit',['branches'=>$branches,'tag'=>$tag]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $branch = Tags::find($request['id']);
            $branch->tag_name = $request['tag_name'];
            $branch->branch = $request['branch'];
            $branch->save();
            return redirect('/tags');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tags $tags)
    {
        //
    }
}
