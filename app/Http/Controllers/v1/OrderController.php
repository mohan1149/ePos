<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Setting;
use App\Models\OutSideOrder;
use App\Models\BusinessOrder;
use App\Models\BusinessClient;
use DB;
use PDF;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        try {

            if (auth()->user()->role == 1) {
                $branches = Branch::where('created_by', auth()->user()->id)->get()->pluck('branch', 'id')->prepend(__("t.all"), 0);
                $users = User::where('created_by', auth()->user()->id)->get()->pluck('name', 'id')->prepend(__('t.all'), 0);
                $sales = Order::where('orders.created_for', auth()->user()->id)
                    ->join('branches', 'branches.id', '=', 'orders.branch')
                    ->join('users', 'users.id', '=', 'orders.staff')
                    ->whereMonth('orders.created_at', isset($request['month']) ? $request['month'] : date('m'))
                    ->when(($request['branch'] !== '0' && isset($request['branch'])), function ($query) use ($request) {
                        $query->where('orders.branch', $request['branch']);
                    })
                    ->when(($request['staff'] !== '0' && isset($request['staff'])), function ($query) use ($request) {
                        $query->where('orders.staff', $request['staff']);
                    })
                    ->select(['orders.*', 'branches.branch', 'users.name'])
                    ->get();
                return view('sales.index', ['sales' => $sales, 'branches' => $branches, 'users' => $users]);
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function orderForPushNotification($id)
    {
        try {
            $order = Order::find($id);
            $setting = Setting::where('created_by', $order->created_for)->select(['decimal_points'])->first();
            return [
                'order' => $order,
                'settings' => $setting,
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function processOrderFromOutside($request)
    {
        try {
            DB::beginTransaction();
            $order = new OutSideOrder();
            $order->track_id = time();
            $order->created_for = $request['created_for'];
            $order->branch = $request['branch'];
            $order->order_items = json_encode($request['order_items']);
            $order->total = $request['total'];
            $order->cust_first_name = $request['fName'];
            $order->cust_last_name = $request['lName'];
            $order->cust_phone = $request['phone'];
            $order->cust_email = $request['email'];
            $order->cust_governorate = $request['governorate'];
            $order->cust_area = $request['area'];
            $order->cust_block = $request['block'];
            $order->cust_avenue = $request['avenue'];
            $order->cust_street = $request['street'];
            $order->cust_house_apartment = $request['homeApartment'];
            $order->customer_type = 'guest';
            $order->payment_method = $request['payMethod'];
            $order->grand_total = $request['grand_total'];
            $order->discount = $request['discount'];
            $order->customer_id = $request['user']['token'];
            $order->save();
            $order_items = $request['order_items'];
            foreach ($order_items as $item) {
                if ($item['product']['stock_item'] == 1) {
                    DB::table('products')->where('id', $item['product']['id'])->update([
                        'stock' => $item['product']['stock'] - $item['quantity'],
                        'sale_count' => $item['product']['sale_count'] + 1,
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

    public function getOrderStatus($id)
    {
        try {
            return OutSideOrder::where('track_id', $id)->select('status')->first();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function outsideOrders($id, $date)
    {
        try {
            return OutSideOrder::where('created_for', $id)->whereDate('created_at', $date)->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function destroyOutsideOrder($id)
    {
        try {
            $order = OutSideOrder::find($id);
            $order->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateOusideOrderStatus($request)
    {
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

    public function placeBusinessOrder($request)
    {
        try {
            DB::beginTransaction();
            $prevInv = DB::table('business_orders')->where('created_by', $request['uid'])->max('invoice_id');
            $order = new BusinessOrder();
            $order->created_by = $request['uid'];
            $order->invoice_id =  $prevInv + 1;
            $order->branch = $request['branch'];
            $branch_name = Branch::find($request['branch'])->branch;
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
            $order->branch_name = $branch_name;
            $order_items = json_decode($request['items']);
            foreach ($order_items as $item) {
                if ($item->stock_item == 1) {
                    DB::table('products')->where('id', $item->id)->update([
                        'stock' => $item->stock - $item->quantity,
                    ]);
                }
            }
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage;
        }
    }

    public function businessOrdersByDriverId($id, $date)
    {
        try {
            return BusinessOrder::where('driver', $id)
                ->whereDate('business_orders.created_at', $date)
                ->leftJoin('business_clients as bc', 'bc.id', '=', 'business_orders.client')
                ->leftJoin('branches as branch', 'branch.id', '=', 'business_orders.branch')
                ->select([
                    'branch.branch as branch_name',
                    'bc.name',
                    'bc.address',
                    'bc.phone',
                    'business_orders.*'
                ])
                ->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function businessOrdersByUser($id, $date)
    {
        try {
            return BusinessOrder::where('business_orders.created_by', $id)
                ->whereDate('business_orders.created_at', $date)
                ->leftJoin('business_clients as bc', 'bc.id', '=', 'business_orders.client')
                ->leftJoin('branches as branch', 'branch.id', '=', 'business_orders.branch')
                ->select([
                    'branch.branch as branch_name',
                    'bc.name',
                    'bc.address',
                    'bc.phone',
                    'business_orders.*'
                ])
                ->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateBusinessOrderById($request)
    {
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

    public function destroyBusinessOrderById($id)
    {
        try {
            $order = BusinessOrder::find($id);
            $order->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function businessOrderByMonth($request)
    {
        try {
            return BusinessOrder::where('business_orders.created_by', $request['uid'])
                ->join('business_clients as bc', 'bc.id', '=', 'business_orders.client')
                ->whereYear('business_orders.created_at', date('Y'))
                ->whereMonth('business_orders.created_at', $request['month'])
                ->select(['business_orders.*', 'bc.name', 'bc.address'])
                ->get();
        } catch (\Exception $e) {
            return false;
        }
    }
    public function businessOrderByMonthAndClient($request)
    {
        try {
            DB::statement("SET SQL_MODE=''");
            return DB::table('business_clients')
                ->join('business_orders as bo', 'bo.client', '=', 'business_clients.id')
                ->where('bo.created_by', $request['uid'])
                ->whereYear('bo.created_at', date('Y'))
                ->whereMonth('bo.created_at', $request['month'])
                ->selectRaw("business_clients.*,count(bo.id) as total_sales,sum(final_total) as grand_total, sum(total_paid) total_paid")
                ->groupBy('business_clients.id')
                ->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function ordersByMonth($request)
    {
        try {
            return Order::where('created_for', $request['uid'])
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $request['month'])
                ->get();
        } catch (\Exception $e) {
            return false;
        }
    }
    public function productReportsByMonthAndBranch($request)
    {
        try {
            $uid = $request['uid'];
            $month = $request['month'];
            $products = Product::where('created_by', $uid)->get();
            $orders =  Order::where('created_for', $uid)
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $month)
                ->get('order_items');
            if (isset($products) && isset($orders)) {
                foreach ($products as $product) {
                    $prc = 0;
                    $prq = 0;
                    foreach ($orders as $order) {
                        $order_items = json_decode($order->order_items);
                        if (isset($order_items)) {
                            foreach ($order_items as $order_item) {
                                if ($order_item->id == $product->id) {
                                    $prc += 1;
                                    $prq += $order_item->quantity;
                                    break;
                                }
                            }
                        }
                    }
                    $pr[] = [
                        'id' => $product->id,
                        'count' => $prc,
                        'quantity' => $prq,
                        'name' => $product->name,
                        'avatar' => $product->product_image,
                        'category' => $product->category,
                        'branch' => $product->branch,
                    ];
                }
            }

            return $pr;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function downloadInvoice($id)
    {
        try {
            $order = BusinessOrder::find($id);
            $branch = Branch::find($order->branch);
            $clinent = BusinessClient::find($order->client);
            $settings = Setting::where('created_by', $order->created_by)->first();
            $content = view('orders.business.invoice', ['order' => $order, 'branch' => $branch, 'client' => $clinent, 'settings' => $settings])->render();
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

    public function terminal(Request $request)
    {
        try {
            $branch = auth()->user()->branch;
            $categories = Category::where('branch', $branch)->where('type', 0)->get();
            $products = Product::where('branch', $branch)->get();
            $settings = Setting::where('created_by', auth()->user()->created_by)->first();
            return view('sales.create', ['categories' => $categories, 'products' => $products, 'settings' => $settings]);
        } catch (\Exception $e) {
            return abort(500, 'ISE');
        }
    }

    public function placeOrderFromPOS(Request $request)
    {
        try {
            return response()->json("fef", 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => false,
                'msg' => $e->getMessage()
            ], 200);
        }
    }

    //FOR Control Panel
    public function getOrders(Request $request)
    {
        try {
            if (auth()->user()->role == 1) {
                $branches = Branch::where('created_by', auth()->user()->id)->get()->pluck('branch', 'id')->prepend(__("t.all"), 0);
                $users = User::where('created_by', auth()->user()->id)->get()->pluck('name', 'id')->prepend(__('t.all'), 0);
                $orders = OutSideOrder::where('out_side_orders.created_for', auth()->user()->id)
                    ->join('branches', 'branches.id', '=', 'out_side_orders.branch')
                    ->leftJoin('users', 'users.id', '=', 'out_side_orders.handler')
                    ->whereMonth('out_side_orders.created_at', isset($request['month']) ? $request['month'] : date('m'))
                    ->when(($request['branch'] !== '0' && isset($request['branch'])), function ($query) use ($request) {
                        $query->where('out_side_orders.branch', $request['branch']);
                    })
                    ->when(($request['staff'] !== '0' && isset($request['staff'])), function ($query) use ($request) {
                        $query->where('out_side_orders.handler', $request['staff']);
                    })
                    ->select(['out_side_orders.*', 'branches.branch', 'users.name'])
                    ->get();
                return view('orders.outside.index', ['sales' => $orders, 'branches' => $branches, 'users' => $users]);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function viewOrder(Request $request){
        try {
            if (auth()->user()->role == 1) {
                $order = OutSideOrder::where('out_side_orders.created_for', auth()->user()->id)
                ->where('id',$request['id'])
                ->first();
                return view('orders.outside.view',['order'=>$order]);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    //end

}
