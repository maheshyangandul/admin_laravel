<?php

namespace App\Http\Controllers;

use App\Models\hotel_admin;
use App\Models\User;
use App\Models\hotel;
use App\Models\vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class hotel_admincontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = DB::table('hotel_admins')
            ->join('hotels', 'hotels.id','=','hotel_admins.hotel_id')
            ->join('vendors', 'vendors.id','=','hotel_admins.vendor_id')
            ->select('*', 'hotel_admins.id as hoteladminid', 'hotel_admins.name as hoteladminname', 'hotels.id as hotelid', 'hotels.name as hotelname', 'vendors.id as vendorid', 'vendors.name as vendorname')
            ->get();
        // $data  = hotel_admin::all();
        return response()->json($data);
    }


    public function hotelid()
    {
      $hotel=hotel::get();
      return response()->json($hotel);
    }   

    public function vendorid()
    {
      $vendor=vendor::get();
      return response()->json($vendor);
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
        $name=$request->get('name');
        $hotel_id=$request->get('hotel_id');
        $vendor_id=$request->get('vendor_id');
        $contact=$request->get('contact');
        $email=$request->get('email');
        $password=$request->get('password');

        $data= new hotel_admin([
            'name'=>$name,
            'hotel_id'=>$hotel_id,
            'vendor_id'=>$vendor_id,
            'contact'=>$contact,
            'email'=>$email,
            'password'=>Hash::make($password),
        ]);

        $user=new User([
            'name'=>$name,
            'email'=>$email,
            'user_role'=>'hotel_admin',
            'password'=>bcrypt($password),
            'status'=>'active'
        ]);
        $user->save();
        if($data->save()){
            return response()->json(['status'=>'success','message'=>'hotel_admin Add Successfully']);
        }
        else{
            return response()->json(['status'=>'success','message'=>'hotel_admin Not Add']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data=hotel_admin::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $name=$request->get('name');
        $hotel_id=$request->get('hotel_id');
        $vendor_id=$request->get('vendor_id');
        $contact=$request->get('contact');
        $email=$request->get('email');
        $password=$request->get('password');
        $data=hotel_admin::find($id);
        $data->name=$name;
        $data->hotel_id=$hotel_id;
        $data->vendor_id=$vendor_id;
        $data->contact=$contact;
        $data->email=$email;
        $data->password=$password;
        if($data->update()){
            return response()->json(['status'=>'success','message'=>'Hotel Admin Updated Successfully']);
           }
           else{
            return response()->json(['status'=>'failed','message'=>'Hotel Admin Not Updated']);
           }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data=hotel_admin::find($id);
        if($data->delete()){
         return response()->json(['status'=>'success','message'=>'Hotel Admin Deleted Successfully']);
        }
        else{
         return response()->json(['status'=>'failed','message'=>'Hotel Admin Not Deleted']);
        }
    }
}
