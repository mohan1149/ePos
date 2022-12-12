<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        if (!$request->session()->has('settings')) {
            $settings = Setting::where('created_by',auth()->user()->id)->first();
            $request->session()->put('settings', $settings);
            return $settings;
        }
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
