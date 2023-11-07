<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\hotel;
use App\Models\hotel_sector;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $room = Room::get();
        return response()->json($room);
    }

    public function hotelsectorgetid()
    {
        // $hotelsector=hotel_sector::get();
        $hotelsector = DB::table('hotel_sectors')
            ->join('rooms', 'rooms.hotel_sector_id', '=', 'hotel_sectors.id')
            ->select('*', 'hotel_sectors.name as hotelsectorname', 'hotel_sectors.id as hotelsectorid')
            ->get();
        return response()->json($hotelsector);
    }

    public function hotelgetid()
    {
        $hotel = hotel::get();
        return response()->json($hotel);
    }

    public function roomtypegetid($id)
    {
        $data = DB::table('rooms')->join('hotels', 'hotels.id', '=', 'rooms.hotel_id')->select('*')
            ->where('hotels.id', '=', $id)

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

        $name = $request->get('name');
        $description = $request->get('description');
        $status = $request->get('status');
        $price = $request->get('price');
        $hotel_id = $request->get('hotel_id');
        // $hotel_sector_id = $request->get('hotel_sector_id');
        $total_rooms = $request->get('total_rooms');

        $imageFileNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imageFileName = date('His') . $imageFile->getClientOriginalName();
                $imageFile->move(public_path('bookingagencies'), $imageFileName);
                $imageFileNames[] = $imageFileName;
            }
        }
        $data = new Room([
            'name' => $name,
            'images' => json_encode($imageFileNames),
            'description' => $description,
            'status' => $status,
            'price' => $price,
            'hotel_id' => $hotel_id,
            // 'hotel_sector_id' => $hotel_sector_id,
            'total_rooms' => $total_rooms,

        ]);
        if ($data->save()) {
            return response()->json(['status' => 'success', 'message' => 'Hotel added successfully']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Hotel not added']);
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
        $name = $request->get('name');
        $description = $request->get('description');
        $status = $request->get('status');
        $price = $request->get('price');
        $hotel_id = $request->get('hotel_id');
        $total_rooms = $request->get('total_rooms');
        // $hotel_sector_id = $request->get('hotel_sector_id');
        $img = $request->file('images');

        if ($img != "") {
            $path = 'file/';
            $filename = time() . '_' . $img->getClientOriginalName();
            $upload = $img->move($path, $filename);
            $room = Room::find($id);
            $room->name = $name;
            $room->images = $filename;
            $room->description = $description;
            $room->status = $status;
            $room->price = $price;
            $room->hotel_id = $hotel_id;
            $room->total_rooms = $total_rooms;
            // $room->hotel_sector_id = $hotel_sector_id;
            if ($room->update()) {
                return response()->json(['status' => 'success', 'message' => 'Room Update Successfully']);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Room Not Update']);
            }
        } else {
            $room = Room::find($id);
            $room->name = $name;

            $room->description = $description;
            $room->status = $status;
            if ($room->update()) {
                return response()->json(['status' => 'success', 'message' => 'Room Update Successfully']);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Room Not Update']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::find($id);
        if ($room->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Room Delete Successfully']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Room Not Delete']);
        }
    }
}
