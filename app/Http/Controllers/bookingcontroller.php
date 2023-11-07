<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class bookingcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $data = booking::all();
        $data = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('hotels', 'hotels.id', '=', 'bookings.hotel_id')
            ->join('hotel_sectors', 'hotel_sectors.id', '=', 'bookings.hotel_sector_id')
            ->select('*', 'bookings.id as bid', 'users.id as userid', 'users.name as username', 'hotels.id as hotelid', 'hotels.name as hotelname', 'hotel_sectors.id as sectorid', 'hotel_sectors.name as sectorname')
            ->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $user_id = $request->get('user_id');
        $hotel_id = $request->get('hotel_id');
        $hotel_sector_id = $request->get('hotel_sector_id');
        $room_id = $request->get('room_id');
        $start_date = $request->get('check_in');
        $end_date = $request->get('check_out');
        $price = $request->get('price');
        $data = new booking([
            'user_id' => $user_id,
            'hotel_id' => $hotel_id,
            'hotel_sector_id' => $hotel_sector_id,
            'room_id' => $room_id,
            'check_in' => $start_date,
            'check_out' => $end_date,
            'price' => $price,
        ]);
        if ($data->save()) {
            return response()->json(['status' => 'success', 'message' => 'Booking Done Successfully']);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Booking Not Done']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = booking::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = booking::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $user_id = $request->get('user_id');
        $hotel_id = $request->get('hotel_id');
        $hotel_sector_id = $request->get('hotel_sector_id');
        $room_id = $request->get('room_id');
        $availability_id = $request->get('availability_id');
        $start_date = $request->get('check_in');
        $end_date = $request->get('check_out');
        $price = $request->get('price');
        $status = $request->get('status');
        $data = booking::find($id);
        $data->user_id = $user_id;
        $data->hotel_id = $hotel_id;
        $data->hotel_sector_id = $hotel_sector_id;
        $data->room_id = $room_id;
        $data->availability_id = $availability_id;
        $data->check_in = $start_date;
        $data->check_out = $end_date;
        $data->price = $price;
        $data->status = $status;
        if ($data->update()) {
            return response()->json(['status' => 'success', 'message' => 'Booking Updated Successfully']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Booking Not Updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data = booking::find($id);
        if ($data->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Booking Deleted Successfully']);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Booking Not Deleted']);
        }
    }
    public function view_booking()
    {
        $book = DB::table('bookings')
            ->join('hotels', 'hotels.id', '=', 'bookings.hotel_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->select('*', 'hotels.id as hotelid', 'hotels.name as hotelname', 'users.id as userid', 'users.name as username', 'bookings.id as bookingsid')
            ->get();
        return $book;
    }
}
