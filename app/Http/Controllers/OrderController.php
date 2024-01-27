<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        //dd($request);

        if ($request->input('date_from_orders'))
            $date_from = date("Y-m-d", strtotime($request->input('date_from_orders')));
        else
            // $date_from = date('Y-m-d');
            $date_from = '2023-09-01';

        if ($request->input('date_to_orders'))
            $date_to = date("Y-m-d", strtotime($request->input('date_to_orders')));
        else
            // $date_to = date('Y-m-d');
            $date_to = '2023-09-02';

        if ($request->input('order_id'))
            $order_id = $request->input('order_id');
        else
            $order_id = "";

        if ($request->input('order_status'))
            $order_status = $request->input('order_status');
        else
            $order_status = "wc-pending";

        $orders = DB::table('wp_posts')->select('ID', 'post_date', 'post_status')
            ->where([
                ['post_status', $order_status],
                ['post_type', 'shop_order'],
            ])
            ->whereDate('post_date', '>=', $date_from)
            ->whereDate('post_date', '<=', $date_to)
            ->get();

            // SELECT id, post_date, post_status FROM wp_posts WHERE post_type="shop_order" AND post_status="wc-was-shipped" AND post_date>="2023-09-01" AND post_date<="2023-10-01" ORDER BY post_date desc

        return view('orders.index', compact('orders', 'date_from', 'date_to', 'order_id', 'order_status'));
    }
}
