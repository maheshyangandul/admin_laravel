<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hotel_sector;
class HoteSectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotel=hotel_sector::get();
        return response()->json($hotel);
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
        $name=$request->get('name');
        $status=$request->get('status');
        $hotel=new hotel_sector([
            'name'=>$name,
            'status'=>$status
        ]);
        //$hotel->save();
        if($hotel->save()){
           
            return response()->json(['status'=>'success','message'=>'Hotel Sector Add Successfully']);
        }
        else{
            return response()->json(['status'=>'failed','message'=>'Hotel Sector Not Added']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hotel=hotel_sector::find($id);
        return response()->json($hotel);
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
        $name=$request->get('name');
        $status=$request->get('status');
        $hotel=hotel_sector::find($id);
        $hotel->name=$name;
        $hotel->status=$status;
        if($hotel->update()){
           
            return response()->json(['status'=>'success','message'=>'Hotel Sector Update Successfully']);
        }
        else{
            return response()->json(['status'=>'failed','message'=>'Hotel Sector Not Updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hotel=hotel_sector::find($id);
        if($hotel->delete()){
            return response()->json(['status'=>'success','message'=>'Hotel Sector Deleted']);
        }
        else{
            return response()->json(['status'=>'success','message'=>'Hotel Sector Not Deleted']);
        }
    }
}
