<?php

namespace App\Http\Controllers;

use App\Models\vendor;
use Illuminate\Http\Request;

class vendorcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data=vendor::all();
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
        $file = $request->file('profile');
        $filename = $file->getClientOriginalName();
        $destinationpath = './bookingagencies';

        $name=$request->get('name');
        $email=$request->get('email');
        $contact=$request->get('contact');
        $location=$request->get('location');
        $city=$request->get('city');
        $password=$request->get('password');
        $status=$request->get('status');
        $data=new vendor([
            'name'=>$name,
            'email'=>$email,
            'contact'=>$contact,
            'profile'=>$filename,
            'location'=>$location,
            'city'=>$city,
            'password'=>$password,
            'status'=>$status
        ]);
        if($data->save()){
            $file->move($destinationpath, $filename);
            return response()->json(['status'=>'success','message'=>'Vendor Add Successfully']);
        }
        else{
            return response()->json(['status'=>'failed','message'=>'Vendor Not Added']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data=vendor::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data=vendor::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $file = $request->file('profile');
        $destinationpath = './bookingagencies';
        $name=$request->get('name');
        $email=$request->get('email');
        $contact=$request->get('contact');
        $location=$request->get('location');
        $city=$request->get('city');
        $password=$request->get('password');
        $status=$request->get('status');
        $data=vendor::find($id);
        // return response()->json($data);
        $data->name=$name;
        $data->email=$email;
        $data->contact=$contact;
        $data->location=$location;
        $data->city=$city;
        $data->password=$password;
        $data->status=$status;
        if ($file) {
            $filename = $file->getClientOriginalName();
            $file->move($destinationpath, $filename);
            $data->profile = $filename;
        }
        if($data->update()){
            return response()->json(['status'=>'success','message'=>'Vendor Updated Successfully']);
        }
        else{
            return response()->json(['status'=>'failed','message'=>'Vendor Not Updated']);
        }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data=vendor::find($id);
        if($data->delete()){
            return response()->json(['status'=>'success','message'=>'Vendor Deleted']);
        }
        else{
            return response()->json(['status'=>'success','message'=>'Vendor Not Deleted']);
        }
    }
}
