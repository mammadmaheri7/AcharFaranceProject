<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getWorks()
    {
        $user = auth()->user();
        $skills = $user->skills;

        $orders = array();
        foreach ($skills as $skill)
        {
            $orders = array_merge($orders, $skill->orders()->get()->toArray());
        }
        return $orders;
    }

    public function getMyOrders()
    {
        $orders = Auth::user() -> orders() -> get();

        $undefined_orders = $this->filterOrderByStatus('undefined',$orders);
        $registered_orders = $this->filterOrderByStatus('registered',$orders);
        $accepted_orders = $this->filterOrderByStatus('accepted',$orders);
        $working_orders = $this->filterOrderByStatus('working',$orders);
        $finished_orders = $this->filterOrderByStatus('finished',$orders);
        $archived_orders = $this->filterOrderByStatus('archived',$orders);

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
