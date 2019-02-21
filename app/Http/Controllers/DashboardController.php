<?php

namespace App\Http\Controllers;

use App\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getWorks()
    {
        $user = auth()->user();
        $skills = $user->skills()->get();

        $orders = collect();
        foreach ($skills as $skill)
        {
            foreach ($skill->orders as $o)
            {
                $orders -> push($o);
            }
        }

        $undefined_orders = $this -> filterOrderByStatus('undefined',$orders);
        $registered_orders = $this -> filterOrderByStatus('registered',$orders);
        $accepted_orders = $this -> filterOrderByStatus('accepted',$orders);
        $working_orders = $this -> filterOrderByStatus('working',$orders);
        $finished_orders = $this -> filterOrderByStatus('finished',$orders);
        $archived_orders = $this -> filterOrderByStatus('archived',$orders);

        /*
        return [
            'undefined_orders'  =>  $undefined_orders,
            'registered_orders' =>  $registered_orders,
            'accepted_orders'   =>  $accepted_orders,
            'working_orders'    =>  $working_orders,
            'finished_orders'   =>  $finished_orders,
            'archived_orders'   =>  $archived_orders
        ];
        */
        $statuses = OrderStatus::all();
        return view('orders.works',compact(['orders','statuses']));
    }

    public function getMyOrders()
    {
        $orders = Auth::user() -> orders() -> get();

        $undefined_orders = $this -> filterOrderByStatus('undefined',$orders);
        $registered_orders = $this -> filterOrderByStatus('registered',$orders);
        $accepted_orders = $this -> filterOrderByStatus('accepted',$orders);
        $working_orders = $this -> filterOrderByStatus('working',$orders);
        $finished_orders = $this -> filterOrderByStatus('finished',$orders);
        $archived_orders = $this -> filterOrderByStatus('archived',$orders);

        return [
            'undefined_orders'  =>  $undefined_orders,
            'registered_orders' =>  $registered_orders,
            'accepted_orders'   =>  $accepted_orders,
            'working_orders'    =>  $working_orders,
            'finished_orders'   =>  $finished_orders,
            'archived_orders'   =>  $archived_orders
        ];
    }

    public function filterOrderByStatus($status_name,$orders)
    {
        $filtered_orders = $orders -> filter(function($item) use ($status_name) {
            return $item->order_status->name == $status_name;
        });
        return $filtered_orders;
    }
}
