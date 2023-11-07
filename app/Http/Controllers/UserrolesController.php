<?php

namespace App\Http\Controllers;

use App\Models\User_role;
use Illuminate\Http\Request;

class UserrolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=User_role::all();
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
        $role=$request->get('role');
        $status=$request->get('status');
        $data=new User_role([
            'role'=>$role,
            'status'=>$status,
        ]);
        
        if($data->save()){
            return response()->json(['status'=>'success','message'=>'User Role Add Successfully']);
        }
        else{
            return response()->json(['status'=>'failed','message'=>'User Role Not Add']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data=User_role::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data=User_role::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $role=$request->get('role');
        $status=$request->get('status');
        $data=User_role::find($id);
        $data->role=$role;
        $data->status=$status;
        if($data->update()){
            return response()->json(['status'=>'success','message'=>'User Role Updated Successfully']);
        }
        else{
            return response()->json(['status'=>'failed','message'=>'User Role Not Updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data=User_role::find($id);
       if($data->delete()){
        return response()->json(['status'=>'success','message'=>'User Role Deleted Successfully']);
       }
       else{
        return response()->json(['status'=>'failed','message'=>'User Not Deleted']);
       }
    }
}
