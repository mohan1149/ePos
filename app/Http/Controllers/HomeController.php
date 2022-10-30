<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        switch(auth()->user()->role){
            case 0: return view('staff.dashboard');
            break;
            case 1:return view('admin.dashboard');
                break;
            case 2:return view('driver.dashboard');
                break;
            case 3:return view('su.dashboard');
                break;
            default:return view('dashboard');
        }
        
    }
}
