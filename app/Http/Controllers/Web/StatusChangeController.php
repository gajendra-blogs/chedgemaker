<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Crypt;


class StatusChangeController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
       $id= Crypt::decrypt($request->id_var);
       $status=$request->status_var;
       $table= Crypt::decrypt($request->table_var);
     
       if ($status==0) {
           $status='1';
       }else{
        $status='0';
       }
       $result= DB::table($table)
       ->where('id', $id)
       ->update(['status' => $status]);
       return response()->json(['id'=>Crypt::encrypt($id),'status'=>$status , 'response'=>$result , 'table'=>Crypt::encrypt($table)]);

    }
    
}
