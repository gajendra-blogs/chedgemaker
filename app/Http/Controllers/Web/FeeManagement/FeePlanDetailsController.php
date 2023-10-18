<?php

namespace Vanguard\Http\Controllers\Web\FeeManagement;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\FeePlanDetail;
use Vanguard\Models\feeHead;
use Vanguard\Models\FeePlan;
use Vanguard\Http\Requests\FeePlanDetails\CreateFeePlanDetails;

class FeePlanDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $batches = ['' => __('Select a Fee Plan')] + FeePlan::orderBy('id' , 'DESC')->pluck('fee_detail', 'id')->toArray();
        return view('feePlanDetails.add' , ["fee_head" => ['' => __('Select a Fee Head')] + feeHead::orderBy('fee_heads_sequence')->pluck('fee_heads_title', 'id')->toArray() , "batches" => $batches]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFeePlanDetails $request)
    {
        $data = $request->all() + [
            'created_by' => auth()->user()->id,
            'status' => '0'
        ];
        // print_r($data);exit;
        FeePlanDetail::create($data);
        return redirect()->route('feePlanDetails.index')
            ->withSuccess(__('Fee Plan Added successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
