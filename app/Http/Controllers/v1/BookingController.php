<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Category;

class BookingController extends Controller
{
    public function create($bid){
        try {
            $staff = User::where('branch',$bid)->where('role',0)->select(['id','name','avatar'])->get();
            $categories = Category::where('branch',$bid)->where('type',1)->get();
            return [
                'staff'=>$staff,
                'categories'=>$categories,
            ];
        } catch (\Exception $e) {
            return false;
        }
    }

    public function store($request){
        try {
            $booking = new Booking();
            $booking->created_by = $request['created_by'];
            $booking->booked_by = $request['booked_by'];
            $booking->branch = $request['branch'];
            $booking->name = $request['name'];
            $booking->phone = $request['phone'];
            $booking->number_of_people = $request['noOfPeople'];
            $booking->booking_date = date('Y-m-d',strtotime($request['selected_dateTime']));
            $booking->staff = $request['selected_staff'];
            $booking->category = $request['selected_category'];
            $booking->services = json_encode($request['selected_types']);
            $booking->notes = $request['notes'];
            $booking->booking_time = $request['selectedTime'];
            $booking->save();
            return true;
        } catch (\Exception $e) {
            return $e->message();
        }
    }

    public function bookingsByStaff($id,$date){
        try {
            return Booking::whereDate('created_at',$date)
            ->where(function($q) use ($id){
                $q->where('staff', $id)
                ->orWhere('booked_by', $id);
            })
            ->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function allBookings($id,$date){
        try {
            return Booking::where('created_by',$id)->whereDate('created_at',$date)->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    

    public function destroy($id){
        try {
            $booking = Booking::find($id);
            $booking->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateStatus($id,$status){
        try {
            $booking = Booking::find($id);
            $booking->status = $status;
            $booking->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}