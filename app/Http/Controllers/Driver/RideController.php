<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;

class RideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accepted_rides = Ride::where('driver_id', $request->user()->id)->where('status', Ride::STATUS_ACCEPTED)->orderBy('created_at','DESC')->get();
        $pending_rides = Ride::where('driver_id', $request->user()->id)->where('status', Ride::STATUS_PENDING)->orderBy('created_at','DESC')->get();
        $cancelled_rides = Ride::where('driver_id', $request->user()->id)->where('status', Ride::STATUS_CANCELLED)->orderBy('created_at','DESC')->get();
        return view('driver.pages.rides.index', compact('accepted_rides','pending_rides','cancelled_rides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $ride = Ride::where('id', $id)->where('driver_id',$request->user()->id)->firstOrFail();
        return view('driver.pages.rides.show', compact('ride'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cancel(Request $request, $id){
        $ride = Ride::where('id', $id)
        ->where('status', Ride::STATUS_PENDING)
        ->where('driver_id',$request->user()->id)->firstOrFail();
        $ride->status = Ride::STATUS_CANCELLED;
        $ride->update();
        return redirect()->back()->with('message', 'Ride Was Cancelled');
    }

    public function accept(Request $request, $id){
        $ride = Ride::where('id', $id)
        ->where('status', Ride::STATUS_PENDING)
        ->where('driver_id',$request->user()->id)->firstOrFail();
        $ride->status = Ride::STATUS_ACCEPTED;
        $ride->update();
        return redirect()->back()->with('message', 'Ride Accepted');
    }
}
