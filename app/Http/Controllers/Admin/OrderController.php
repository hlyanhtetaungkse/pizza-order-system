<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function orderList(){
        if(Session::has('ORDER_SEARCH')){
            Session::forget('ORDER_SEARCH');
        }
        $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name as pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
                    ->join('users','users.id','orders.customer_id')
                    ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
                    ->groupBy('orders.customer_id','orders.pizza_id')
                    ->orderBy('orders.order_id','desc')
                    ->paginate(7);
        return view('admin.order.list')->with(['order'=>$data]);

    }

    public function orderSearch(Request $request){
        $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name as pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
                    ->join('users','users.id','orders.customer_id')
                    ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
                    ->orWhere('users.name','like','%'.$request->searchData.'%')
                    ->orWhere('pizzas.pizza_name','like','%'.$request->searchData.'%')
                    ->groupBy('orders.customer_id','orders.pizza_id')
                    ->orderBy('orders.order_id','desc')
                    ->paginate(7);

        Session::put('ORDER_SEARCH',$request->searchData);
        $data->appends($request->all());
        return view('admin.order.list')->with(['order'=>$data]);
    }

    public function downloadOrder(){
        if(Session::has('ORDER_SEARCH')){
            $order = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name as pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
            ->join('users','users.id','orders.customer_id')
            ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
            ->orWhere('users.name','like','%'.Session::get('ORDER_SEARCH').'%')
            ->orWhere('pizzas.pizza_name','like','%'.Session::get('ORDER_SEARCH').'%')
            ->groupBy('orders.customer_id','orders.pizza_id')
            ->orderBy('orders.order_id','desc')
            ->get();
        }else{
            $order = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name as pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
            ->join('users','users.id','orders.customer_id')
            ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
            ->groupBy('orders.customer_id','orders.pizza_id')
            ->orderBy('orders.order_id','desc')
            ->get();

            // dd($order->toArray());
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build($order, [
            'customer_name' => 'Customer Name',
            'pizza_name' => 'Pizza Name',
            'count' => 'Count',
            'order_time' => 'Order Date',
            'created_at'  => 'Created Date',
            'updated_at'  => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'OrderList.csv';

        return response((string) $csvReader)
            ->header('Content-Type','text/csv; charset-UTF-8')
            ->header('Content-Disposition','attachment; filename="'.$filename.'"');

    }
}
