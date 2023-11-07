<?php

namespace App\Http\Controllers;

use App\Models\availability;
use Illuminate\Http\Request;

class availabilitycontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = availability::all();
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
        // echo "hi";
        // $request->validate([]);
        $hotel_id = $request->get('hotel_id');
        $hotel_sector_id = $request->get('hotel_sector_id');
        $room_id = $request->get('room_id');
        $title = $request->get('title');
        $desc = $request->get('desc');
        $price = $request->get('price');
        $imageFileNames = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imageFileName = date('His') . '_' . $imageFile->getClientOriginalName(); // Adding a timestamp to avoid overwriting files with the same name
                $imageFile->move(public_path('bookingagencies'), $imageFileName);
                $imageFileNames[] = $imageFileName;
            }
        }

        $data = new Availability([
            'hotel_id' => $hotel_id,
            'title' => $title,
            'desc' => $desc,
            'price' => $price,
            'hotel_sector_id' => $hotel_sector_id,
            'room_id' => $room_id,
            'images' => json_encode($imageFileNames),
        ]);

        if ($data->save()) {
            return response()->json(['status' => 'success', 'message' => 'Availability Added Successfully']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Availability Not Added']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data = availability::find($id);
        if ($data->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Deleted']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Not Deleted']);
        }
    }
}
