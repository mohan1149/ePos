<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\BusinessClient;
class BusinessClientController extends Controller
{
    public function store($requst){
        try {
            $businessClient = new BusinessClient();
            $businessClient->created_by = $requst['uid'];
            $businessClient->name = $requst['name'];
            $businessClient->phone = $requst['phone'];
            $businessClient->email = $requst['email'];
            $businessClient->address = $requst['address'];
            $businessClient->save();
            return true;
        } catch (\Exception $e) {
            return false;
        } 
    }
    public function index($id){
        try {
            return BusinessClient::where('created_by',$id)->get();
        } catch (\Exception $e) {
            return [];
        } 
    }

    public function update($requst){
        try {
            $businessClient = BusinessClient::find($requst['id']);
            $businessClient->name = $requst['name'];
            $businessClient->phone = $requst['phone'];
            $businessClient->email = $requst['email'];
            $businessClient->address = $requst['address'];
            $businessClient->save();
            return true;
        } catch (\Exception $e) {
            return false;
        } 
    }

    public function destroy($id){
        try {
            $businessClient = BusinessClient::find($id);
            $businessClient->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        } 
    }
}
