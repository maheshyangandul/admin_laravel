<?php

namespace App\Http\Controllers;

use App\Models\bill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class billingcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data=bill::all();
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
        // $bill_id = Str::random(6); // Generate a random string of length 6
        $user_id = $request->get('user_id');
        $total_price = $request->get('total_price');
        $bill_date = $request->get('bill_date');
        $bill_status = $request->get('bill_status');
        $pay_mode = $request->get('pay_mode');
        
        $data = new bill([
            'bill_id' => rand(100000, 999999),
            'user_id' => $user_id,
            'total_price' => $total_price,
            'bill_date' => $bill_date,
            'bill_status' => $bill_status,
            'pay_mode' => $pay_mode,
        ]);
        
        if ($data->save()) {
            return response()->json(['status' => 'success', 'message' => 'Bill Paid Successfully']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Bill Not Paid']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data=bill::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data=bill::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user_id = $request->get('user_id');
        $total_price = $request->get('total_price');
        $bill_date = $request->get('bill_date');
        $bill_status = $request->get('bill_status');
        $pay_mode = $request->get('pay_mode');
        $data=bill::find($id);
        // echo $data->bill_id;
        // exit();
        $data->bill_id=$data->bill_id;
        $data->user_id=$user_id;
        $data->total_price=$total_price;
        $data->bill_date=$bill_date;
        $data->bill_status=$bill_status;
        $data->pay_mode=$pay_mode;
        if ($data->update()) {
            return response()->json(['status' => 'success', 'message' => 'Bill Update Successfully']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Bill Not Update']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data=bill::find($id);
        if ($data->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Bill Deleted Successfully']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Bill Not Deleted']);
        }
    }
}
