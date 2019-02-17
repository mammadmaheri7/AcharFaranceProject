<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Jobs\SendCreateOrderEmail;
use App\Mail\OrderShipped;
use App\MotionGraphicOrder;
use App\Order;
use App\OrderStatus;
use App\Photo;
use App\Skill;
use App\WebDesignOrder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    /*
    public function __construct()
    {
        $this->authorizeResource(Order::class,'orders');
    }
    */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('order_index');

        $orders = Order::with('photos')->get();
        return $orders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('order_create');

        $skills = Skill::all();
        return view('orders.create',compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        //request validated in OrderRequest
        $this->authorize('order_create');

        $skill = Skill::where('id',$request->skill)->firstOrFail();
        $user = auth()->user();

        $order = new Order($request->all());
        $skill->orders()->save($order);
        $user->orders()->save($order);

        //create datail for order
        $temp = $this->create_order_detail($request,$skill);
        $temp->orders()->save($order);

        //create order_status
        //handle if registered(status) or undefined(status) does not exist
        try
        {
            $status = OrderStatus::where('name','registered') -> firstOrFail();
        }
        catch (ModelNotFoundException $e)
        {
            try
            {
                $status = OrderStatus::where('name','undefined') -> firstOrFail();
            }
            catch (ModelNotFoundException $er)
            {
                $status = new OrderStatus(['name'=>'undefined']);
                $status->save();
            }
        }

        //save order_status in order
        $order -> order_status() -> associate($status);
        $order -> save();

        SendCreateOrderEmail::dispatch($order,$user)->onConnection('database');

        flash()->success('Create Order', 'creation was successful');

        //return $order;
        //return redirect("orders/".$order->id."/addPhoto")->with('success', 'Order registered Successfully!');
        return redirect("orders/".$order->id."/addPhoto");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('id',$id)->with('photos')->firstOrFail();
        $this->authorize('show',$order);

        return $order;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //TODO authorize and edit and redirect
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //TODO authorize and update and redirect
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO authorize and delete and redirect
    }

    protected function create_order_detail(OrderRequest $request,Skill $skill)
    {
        $name = $skill->name_english;

        switch ($name)
        {
            case "MotionGraphic":
                $str = ($request->time);
                $mg = new MotionGraphicOrder(['time'=>$str]);
                $mg->save();
                return $mg;
                break;

            case "WebDesign":
                $wd = new WebDesignOrder(['url'=>$request->url]);
                $wd->save();
                return $wd;
                break;

            default:
                return null;
        }
    }

    public function addPhoto($id,Request $request)
    {
        $this->validate($request,[
            'file'  =>  'mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        $order = Order::where('id',$id)->firstOrFail();
        $this->authorize('addPhotoPage',$order);

        $photo_path = $request->file('file')->store('photosOforders');
        $photo = new Photo(['photo_path'=>$photo_path]);
        $order->photos()->save($photo);
        $photo->save();

        return $order;
    }

    public function addPhotoPage($id,Request $request)
    {
        //Alert::success('Success Title', 'Success Message');
        $order = Order::where('id',$id)->firstOrFail();
        $this->authorize('addPhotoPage',$order);

        return view('orders.addPhoto',compact('order'));
    }
}
