<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Setting;
use App\Models\OutSideOrder;
use App\Models\BusinessOrder;
use App\Models\BusinessClient;
use DB;
use PDF;

class OrderController extends Controller
{
    public function orderForPushNotification($id){
        try {
            $order = Order::find($id);
            $setting = Setting::where('created_by',$order->created_for)->select(['decimal_points'])->first();
            return [
                'order'=>$order,
                'settings' => $setting,
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function processOrderFromOutside($request){
        try {
            DB::beginTransaction();
            $order = new OutSideOrder();
            $order->track_id = time();
            $order->created_for = $request['created_for'];
            $order->branch = $request['branch'];
            $order->order_items = $request['cart_items'];
            $order->total = $request['total'];
            $order->cust_name = $request['name'];
            $order->cust_phone = $request['phone'];
            $order->cust_email = $request['email'];
            $order->cust_state = $request['state'];
            $order->cust_city = $request['city'];
            $order->cust_town = $request['town'];
            $order->cust_block_avenue = $request['blockAvenue'];
            $order->cust_street = $request['street'];
            $order->cust_house_apartment = $request['houseApartment'];
            $order->cust_landmark = $request['landmark'];
            $order->save();
            $order_items = json_decode($request['cart_items']);
            foreach ($order_items as $item) {
                if($item->stock_item == 1){
                    DB::table('products')->where('id',$item->id)->update([
                        'stock' => $item->stock - $item->quantity,
                        'sale_count' => $item->sale_count + 1,
                    ]);
                }
            }
            DB::commit();
            return $order->track_id;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getOrderStatus($id){
        try {
            return OutSideOrder::where('track_id',$id)->select('status')->first();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function outsideOrders($id,$date){
        try {
            return OutSideOrder::where('created_for',$id)->whereDate('created_at',$date)->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function destroyOutsideOrder($id){
         try {
            $order = OutSideOrder::find($id);
            $order->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateOusideOrderStatus($request){
        try {
            $order = OutSideOrder::find($request['id']);
            $order->status = $request['status'];
            $order->handler = $request['handler'];
            $order->driver = $request['driver'];
            $order->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function placeBusinessOrder($request){
        try {
            DB::beginTransaction();
            $order = new BusinessOrder();
            $order->created_by = $request['uid'];
            $order->branch = $request['branch'];
            $order->driver = $request['driver'];
            $order->items = $request['items'];
            $order->client = $request['client'];
            $order->payment_status = $request['pay_status'];
            $order->payment_method = $request['pay_method'];
            $order->order_total = $request['order_total'];
            $order->final_total = $request['grand_total'];
            $order->discount = $request['discount'];
            $order->total_paid = $request['amount_paid'];
            $order->save();
            $order_items = json_decode($request['items']);
            foreach ($order_items as $item) {
                if($item->stock_item == 1){
                    DB::table('products')->where('id',$item->id)->update([
                        'stock' => $item->stock - $item->quantity,
                    ]);
                }
            }
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function businessOrdersByDriverId($id,$date){
        try {
            return BusinessOrder::where('driver',$id)
            ->whereDate('business_orders.created_at',$date)
            ->leftJoin('business_clients as bc','bc.id','=','business_orders.client')
            ->select([
                'bc.name',
                'bc.address',
                'bc.phone',
                'business_orders.*'
            ])
            ->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function businessOrdersByUser($id,$date){
        try {
            return BusinessOrder::where('business_orders.created_by',$id)
            ->whereDate('business_orders.created_at',$date)
            ->leftJoin('business_clients as bc','bc.id','=','business_orders.client')
            ->select([
                'bc.name',
                'bc.address',
                'bc.phone',
                'business_orders.*'
            ])
            ->get();
        } catch (\Exception $e) {
            return [];
        }
    }
    
    public function updateBusinessOrderById($request){
        try {
            $order = BusinessOrder::find($request['id']);
            $order->payment_status = $request['payStatus'];
            $order->payment_method = $request['payMethod'];
            $order->total_paid = $order->total_paid + $request['amountPaid'];
            $order->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function destroyBusinessOrderById($id){
        try {
            $order = BusinessOrder::find($id);
            $order->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function businessOrderByMonth($request){
        try {
            return BusinessOrder::where('business_orders.created_by',$request['uid'])
                ->join('business_clients as bc','bc.id','=','business_orders.client')
                ->whereYear('business_orders.created_at',date('Y'))
                ->whereMonth('business_orders.created_at',$request['month'])
                ->select(['business_orders.*','bc.name','bc.address'])
                ->get();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function ordersByMonth($request){
        try {
            return Order::where('created_for',$request['uid'])
                ->whereYear('created_at',date('Y'))
                ->whereMonth('created_at',$request['month'])
                ->get();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function downloadInvoice($id){
        try {
            $order = BusinessOrder::find($id);
            $branch = Branch::find($order->branch);
            $clinent = BusinessClient::find($order->client);
            $settings = Setting::where('created_by',$order->created_by)->first();
            //return view('orders.business.invoice',['order'=>$order,'branch'=>$branch,'client'=>$clinent,'settings'=>$settings]);
             $content = view('orders.business.invoice',['order'=>$order,'branch'=>$branch,'client'=>$clinent,'settings'=>$settings])->render();
                $mpdf = new \Mpdf\Mpdf([
                    'margin_left' => 10,
                    'margin_right' => 10,
                    'margin_top' => 10,
                    'margin_bottom' => 10,
                    'margin_header' => 10,
                    'margin_footer' => 10
                ]);
                $mpdf->SetProtection(array('print'));
                $mpdf->SetTitle("iTenant - Rent Invoice");
                $mpdf->SetWatermarkText("Sale Invoice");
                $mpdf->showWatermarkText = true;
                $mpdf->watermarkTextAlpha = 0.1;
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->WriteHTML($content);
                $mpdf->Output();
        } catch (\Exception $e) {
            return false;
        }
    }
    
}