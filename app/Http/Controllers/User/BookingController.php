<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rides = Ride::with('driver')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        return view('users.pages.rides.index',compact('rides'));
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
        $request->validate([
            'driver_id' => 'required|exists:users,id',
            'from_latitude' => 'required|numeric|min:-90|max:90',
            'from_longitude' => 'required|numeric|min:-180|max:180',
            'to_latitude' => 'required|numeric|min:-90|max:90',
            'to_longitude' => 'required|numeric|min:-180|max:180',
        ]);
        $ride = new Ride();
        $ride->driver_id = $request->driver_id;
        $ride->from_latitude = $request->from_latitude;
        $ride->from_longitude = $request->from_longitude;
        $ride->to_latitude = $request->to_latitude;
        $ride->to_longitude = $request->to_longitude;
        $ride->user_id = Auth::user()->id;
        $ride->message = $request->message;
        $ride->save();
        return redirect(route('user.bookings.show',$ride->id))->with('success','Ride Was Booked');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ride = Ride::with('driver')->findOrFail($id);
        abort_unless($ride->user_id == Auth::user()->id,404);
        return view('users.pages.rides.show',compact('ride'));
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

    public function cancelRide(Request $request, $id){
        $ride = Ride::findOrFail($id);
        abort_unless($ride->user_id == Auth::user()->id,403);
        if($ride->status != Ride::STATUS_PENDING){
            return redirect()->back()->with('message', 'Cannot Cancel Ride');
        }
        $ride->status = Ride::STATUS_CANCELLED;
        $ride->update();
        return redirect()->back()->with('message', 'Ride Cancelled');
    }
}
