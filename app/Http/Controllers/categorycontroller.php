<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class categorycontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data=category::all();
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
        $name=$request->get('name');
        $status= $request->get('status');
        $data=new category([
            'name'=>$name,
            'status'=>$status,
        ]);
        if($data->save()){
            return response()->json(['status'=>'success','message'=>'Category Added Successfully']);
        }
        else{
            return response()->json(['status'=>'success','message'=>'Category Not Added']);
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
        $data=category::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $name=$request->get('name');
        $status=$request->get('status');
        $data=category::find($id);
        $data->name=$name;
        $data->status=$status;
        if($data->update()){
            return response()->json(['status'=>'success','message'=>'Category Updated Successfully']);
        }
        else{
            return response()->json(['status'=>'failed','message'=>'Category Not Updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data=category::find($id);
        if($data->delete()){
            return response()->json(['status'=>'success','message'=>'Category Deleted']);
        }
        else{
            return response()->json(['status'=>'success','message'=>'Category Not Deleted']);
        }
    }
}
