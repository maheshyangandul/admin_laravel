<?php

namespace App\Http\Controllers;

use App\Models\hotel;
use App\Models\hotel_sector;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class hotelcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('hotels')
            ->join('hotel_sectors', 'hotel_sectors.id', '=', 'hotels.hotel_sector_id')
            ->join('vendors', 'vendors.id', '=', 'hotels.vendor_id')
            ->select('*', 'hotel_sectors.name as sectorname', 'hotel_sectors.id as sectorid', 'hotels.id as hotelid', 'hotels.name as hotelname', 'vendors.id as vendorid', 'vendors.name as vendorname')
            ->get();
        return response()->json($data);
    }

    public function hotelsectorget()
    {
        $hotelsector = hotel_sector::get();
        return response()->json($hotelsector);
    }

    public function hotelget()
    {
        $hotelget = hotel::get();
        return response()->json($hotelget);
    }

    public function hotelrooms($id)
    {
        $data = DB::table('hotels')
            ->join('hotel_sectors', 'hotel_sectors.id', '=', 'hotels.hotel_sector_id')
            ->join('rooms', 'rooms.hotel_id', '=', 'hotels.id')
            ->select('*', 'hotel_sectors.name as sectorname', 'hotel_sectors.id as sectorid', 'hotels.id as hotelid', 'hotels.name as hotelname', 'hotels.description as hoteldescription', 'hotels.images as hotelimages', 'rooms.id as roomid', 'rooms.name as roomname', 'rooms.description as roomdescription', 'rooms.images as roomimages')
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


    // public function searchHotels(Request $request)
    // {
    //     $city = $request->query('city');

    //     $data = DB::table('hotels')
    //         ->join('hotel_sectors', 'hotel_sectors.id', '=', 'hotels.hotel_sector_id')
    //         ->select(
    //             'hotels.id as hotelid',
    //             'hotels.name as hotelname',
    //             'hotel_sectors.name as sectorname',
    //             'hotels.city as city',
    //             'hotels.location as location',
    //             'hotels.images as images',
    //         )
    //         ->where('hotels.city', 'LIKE', '%' . $city . '%')
    //         ->get();

    //     return response()->json($data);
    // }

    public function searchHotels(Request $request)
    {
        $query = DB::table('hotels')
            ->join('hotel_sectors', 'hotel_sectors.id', '=', 'hotels.hotel_sector_id')
            ->select(
                'hotels.id as hotelid',
                'hotels.name as hotelname',
                'hotel_sectors.name as sectorname',
                'hotels.city as city',
                'hotels.location as location',
                'hotels.images as images',
            );

        $searchTerm = $request->query('searchTerm');
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('hotels.city', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('hotels.country', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('hotels.state', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('hotels.name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('hotels.location', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $data = $query->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $name = $request->get('name');

        $description = $request->get('description');
        $location = $request->get('location');
        // $rooms = $request->get('room_id');
        $country = $request->get('country');
        $state = $request->get('state');
        $city = $request->get('city');
        $pincode = $request->get('pincode');
        $hotel_sector_id = $request->get('hotel_sector_id');
        $hotel_vendor_id = $request->get('hotel_vendor_id');
        // $room_type = $request->get('room_type', []);

        // $room_type_json = $request->get('room_type'); // JSON-encoded room_type data
        // $room_type = json_decode($room_type_json); // Decoding JSON to an array

        $imageFileNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imageFileName = date('His') . $imageFile->getClientOriginalName();
                $imageFile->move(public_path('bookingagencies'), $imageFileName);
                $imageFileNames[] = $imageFileName;
            }
        }
        $data = new hotel([
            'name' => $name,
            'description' => $description,
            'images' => json_encode($imageFileNames),
            'location' => $location,
            // 'room_id' => $rooms,
            'country' => $country,
            'state' => $state,
            'city' => $city,
            'pincode' => $pincode,
            'hotel_sector_id' => $hotel_sector_id,
            'vendor_id' => $hotel_vendor_id,
            // 'room_type' => json_encode($room_type),

        ]);
        //return $data;
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
        $data = DB::table('hotels')->join('hotel_sectors', 'hotel_sectors.id', '=', 'hotels.hotel_sector_id')->select('*', 'hotel_sectors.name as sectorname', 'hotel_sectors.id as sectorid', 'hotels.id as hotelid', 'hotels.name as hotelname')
            ->where('hotels.id', '=', $id)

            ->get();
        return response()->json($data);
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
        $data = hotel::find($id);
        if ($data->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Hotel Deleted Successfully']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Hotel Deleted Successfully']);
        }
    }

    public function searchdata(Request $request)
    {
        $location = $request->get('slocation');
        $sdate = $request->get('sdate');
        $edate = $request->get('edate');

        $data = DB::table('hotels')
            ->join('availabilities', 'availabilities.hotel_id', '=', 'hotels.id')
            ->join('rooms', 'rooms.id', '=', 'availabilities.room_id')
            ->join('hotel_sectors', 'hotel_sectors.id', '=', 'hotels.hotel_sector_id')
            ->where('hotels.city', 'LIKE', '%' . $location . '%')
            // ->orWhere('hotels.country', 'LIKE', '%' . $location . '%')
            // ->orWhere('hotels.state', 'LIKE', '%' . $location . '%')
            // ->orWhere('hotels.name', 'LIKE', '%' . $location . '%')
            // ->orWhere('hotels.location', 'LIKE', '%' . $location . '%')
            ->whereDate('availabilities.start_date', '<=', $sdate)
            ->whereDate('availabilities.end_date', '>=', $edate)
            ->select('*', 'hotels.id as hotelid', 'availabilities.id as aid', 'rooms.id as roomid', 'rooms.name as roomname', 'hotels.name as hotelname', 'hotels.images as hotelimages', 'hotel_sectors.name as hotelsectorname')
            ->get();

        return $data;
    }
}
