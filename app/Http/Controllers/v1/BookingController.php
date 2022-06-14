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
            $booking->booking_datetime = date('Y-m-d H:i:s',strtotime($request['selected_dateTime']));
            $booking->staff = $request['selected_staff'];
            $booking->category = $request['selected_category'];
            $booking->services = $request['selected_types'];
            $booking->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function bookingsByStaffId($id,$date){
        try {
            return Booking::where('booked_by',$id)->whereDate('booking_datetime',$date)->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function allBookings($id,$date){
        try {
            return Booking::where('created_by',$id)->whereDate('booking_datetime',$date)->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function editBooking($request){
        try {
            $booking = new Booking();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($request){
        try {
            $booking = new Booking();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateStatus($request){
        try {
            $booking = new Booking();
            return true;
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

}