<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\FeeHead\CreateFeeHeadRequest;
use Vanguard\Http\Requests\feeplan\CreateFeePlanRequest;
use Vanguard\Http\Requests\FeeHead\UpdateFeeHeadRequest;
use Vanguard\Models\feeHead;
use Vanguard\Models\FeePlan;
use Vanguard\Models\Installments;
use Vanguard\Models\FeePlanDetail;
use Vanguard\Models\Center;
use Vanguard\Events\ActivityLogEvents\Created;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;
use DB;
use Auth;
use Validator;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feehead = feeHead::where('fee_heads_title', 'LIKE', '%' . $request->search . '%')
            ->orderBy($request->column ? Crypt::decrypt($request->column) : 'fee_heads_title', $request->order ? $request->order : 'asc')
            ->paginate(6);
        if ($request->order && $request->column) {
            $edit = false;
            return view('FeeHead.table', compact('feehead', 'edit'));
        }
        $data['feehead'] = $feehead;
        $data['edit'] = false;
        return view('feeHead.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feeHead.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFeeHeadRequest $request)
    {
        $feehead = new feeHead();
        $feehead->fee_heads_title = $request->fee_heads_title;
        $feehead->fee_heads_sequence = $request->fee_heads_sequence;
        $feehead->created_by = auth()->user()->id;
        $feehead->save();
        event(new Created("Created Fee Head " . $request->fee_heads_title));
        $lastInsertedId = $feehead->id;
        $lastInsertedData = feeHead::find($lastInsertedId);
        $total_record = feeHead::count();
        $data = $lastInsertedData;
        $renderedRow = View::make('FeeHead.row', ['oneFeeHead' => $lastInsertedData, "edit" => false, 'row_count' => 1])->render();
        return json_encode(['success' => true, 'template' => $renderedRow, "total_record" => $total_record, "message" => 'Fee Head Created Successfully']);
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
        $id = Crypt::decrypt($id);
        $feeHead = feeHead::where('id', $id)->first();

        return view('FeeHead.create', ['feehead_in_update' => $feeHead]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeeHeadRequest $request, $id)
    {
        $feehead = feeHead::find($id);
        $feehead->fee_heads_title = $request->fee_heads_title;
        $feehead->fee_heads_sequence = $request->fee_heads_sequence;
        $feehead->updated_by = auth()->user()->id;
        $feehead->save();
        event(new Created("Updated Fee Head " . $request->fee_heads_title));

        $renderedRow = View::make('FeeHead.row', ['oneFeeHead' => $feehead, "edit" => false, 'row_count' => $request->row_count])->render();
        return json_encode(['success' => true, 'template' => $renderedRow, "message" => 'Fee Head Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $FeeHead = feeHead::find($id);
        $FeeHeadDeleted = $FeeHead->delete(); //returns true/false
        if ($FeeHeadDeleted) {
            event(new Created("Deleted Fee Head " . $FeeHead->fee_heads_title));

            return redirect()->back()->with('success', 'Fee Head Deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Fee Head Not Deleted');
        }
    }

    /**
     * Display a listing of the Payment plan deatils.
     *
     * @return \Illuminate\Http\Response
     */


    public function getFeePlan(Request $request)
    {

        try {
            // $batches =  Batch::all() ;
            $fee = DB::table('fee_plans')
                // ->leftJoin('batches', 'fee_plans.batch_id', '=', 'batches.id')
                ->leftJoin('courses', 'courses.id', '=', 'fee_plans.course_id')
                ->leftJoin('centers', 'centers.id', '=', 'fee_plans.center_id')
                ->select('fee_plans.*', 'centers.center_name', 'courses.course_name')
                ->where('fee_plans.name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('fee_plans.fee_type', 'LIKE', '%' . $request->search . '%')
                ->orWhere('fee_plans.total_fee', 'LIKE', '%' . $request->search . '%')
                ->orderBy($request->column ? Crypt::decrypt($request->column) : 'name', $request->order ? $request->order : 'asc')
                ->paginate(10);

            $centers = DB::table('centers')
                ->where('status', '=', 1)
                ->get();

            $courses = DB::table('courses')
                ->where('status', "1")
                ->get();

            $feeheads = DB::table('fee_heads')
                ->where('status', '=', 1)
                ->orderBy('fee_heads_sequence', 'asc')
                ->get();
            if ($request->order && $request->column) {
                return view('feePlan.partials.table', compact('fee', 'centers', 'courses', 'feeheads'));
            }

            return view('feePlan/index', [
                // 'batches' => $batches,
                'fee' => $fee,
                'centers' => $centers,
                'courses' => $courses,
                'feeheads' => $feeheads
            ]);
        } catch (\Exception $error) {
            return $error->getMessage();
        }
    }

    public function getCourseAndCenterName(Request $request)
    {
        $batches = DB::table('batches')
            ->leftJoin('centers', 'centers.id', '=', 'batches.center_id')
            ->leftJoin('courses', 'courses.id', '=', 'batches.course_id')
            ->select('batches.*', 'centers.center_name', 'courses.course_name')
            ->where('batches.id', $_POST['batch_id'])
            ->get();
        return $batches[0];
    }

    public function getFeeHeads(Request $request)
    {
        $feeHeads = DB::table('fee_heads')
            ->where('status', 1)
            ->get();
        $totalFee = $_POST['totalFee'];
        // echo $totalFee ; 
        // die;
        $data = [
            'totalFee' => $totalFee,
            'feeheads' => $feeHeads
        ];

        $template = View::make('feePlan.feecomponents.feehead', $data)->render();
        return json_encode(['success' => true, 'template' => $template]);


    }

    public function viewFeePlan(Request $request)
    {
        $id = Crypt::decrypt($_POST['feePlanId']);
        $feeData = DB::table('fee_plans')
            ->leftJoin('courses', 'courses.id', '=', 'fee_plans.course_id')
            ->leftJoin('centers', 'centers.id', '=', 'fee_plans.center_id')
            ->select('fee_plans.*', 'centers.center_name', 'courses.course_name')
            ->where('fee_plans.id', $id)
            ->get();

        $installments = DB::table('installments')
            ->where('fee_plan_id', $id)
            ->get();

        $feedetails = DB::table('fee_plan_details')
            ->leftJoin('fee_heads', 'fee_heads.id', '=', 'fee_plan_details.fee_head_id')
            ->select('fee_plan_details.*', 'fee_heads.fee_heads_title')
            ->where('fee_plan_id', $id)
            ->get();

        $data = [
            'feeData' => $feeData,
            'installments' => $installments,
            'feedetails' => $feedetails
        ];

        // echo "<pre>";
        // print_r($feedetails);
        // die();
        $template = View::make('feePlan.feecomponents.feeplanview', $data)->render();
        return json_encode(['success' => true, 'template' => $template]);


    }

    public function storeFeePlan(CreateFeePlanRequest $request)
    {

        $checkWhere = [
            'course_id' => $request->course_id,
            'fee_type' => $request->fee_type
        ];
        $count = FeePlan::where($checkWhere)->count();
        if ($count == 0) {
            $total = 0;
            $data = $request->all();

            foreach ($data['feeHeadId'] as $feeHead) {
                $total += $feeHead['amount'];
            }
            if ($total == $data['total_fee']) {
                if ($request->fee_type == 'installment') {
                    $totalInstallment = 0;
                    $dueTimeError = false;
                    foreach ($data['installments'] as $installment) {
                        $totalInstallment += $installment['amount'];
                        if ($installment['time'] == '') {
                            return json_encode(['success' => false, 'message' => 'Due Time is Required for Each Installment']);

                        }

                    }
                    if ($totalInstallment != $data['total_fee']) {
                        return json_encode(['success' => false, 'message' => 'Total fee and Total Of Installments is not equal']);

                    }
                }

                $feePlan = new FeePlan([
                    'center_id' => 1,
                    'course_id' => $request->course_id,
                    'name' => $request->fee_plan_name,
                    'fee_type' => $request->fee_type,
                    'created_by' => Auth::user()->id,
                    'total_fee' => $request->total_fee,
                    'module_id' => $request->module_id
                ]);

                $result = $feePlan->save();
                if ($result) {

                    foreach ($data['feeHeadId'] as $feeHead) {
                        $feeHead = new FeePlanDetail([
                            'fee_head_id' => $feeHead['id'],
                            'fee_plan_id' => $feePlan->id,
                            'amount' => $feeHead['amount'],
                            'created_by' => Auth::user()->id
                        ]);
                        $feeHead->save();
                    }

                    if ($request->fee_type == 'installment') {
                        foreach ($data['installments'] as $installment) {
                            $installments = new Installments([
                                'fee_plan_id' => $feePlan->id,
                                'installment_amount' => $installment['amount'],
                                'due_time' => $installment['time'],
                                'created_by' => Auth::user()->id
                            ]);
                            $installments->save();
                        }
                    }
                    return json_encode(['success' => true, 'message' => 'Fee Plan Is Added Successfully']);

                } else {
                    return json_encode(['success' => false, 'message' => 'Total fee and Total distribution of Fee is not equal']);

                }
            } else {
                return json_encode(['success' => false, 'message' => 'form is no valid']);

            }
        } else {
            return json_encode(['success' => false, 'message' => 'Fee Plan already exists']);

        }


    }

    public function edit_feePlan()
    {
        $id = $_GET['feePlanId'];
        $id = Crypt::decrypt($id);


        $feeData = DB::table('fee_plans')
            ->leftJoin('courses', 'courses.id', '=', 'fee_plans.course_id')
            //->leftJoin('centers', 'centers.id', '=', 'fee_plans.center_id')
            ->select('fee_plans.*', 'courses.course_name')
            ->where('fee_plans.id', $id)
            ->get();




        $installments = DB::table('installments')
            ->where('fee_plan_id', $id)
            ->get();



        // $centers = DB::table('centers')
        //     ->where('status', '=', 1)
        //     ->get();

        $courses = DB::table('courses')
            ->where('status', '=', 1)
            ->get();


        $feeHeads = DB::table('fee_heads')
            ->where('status', 1)
            ->get();

        $feedetails = DB::table('fee_plan_details')
            ->leftJoin('fee_heads', 'fee_heads.id', '=', 'fee_plan_details.fee_head_id')
            ->select('fee_plan_details.*', 'fee_heads.fee_heads_title')
            ->where('fee_plan_id', $id)
            ->get();

        $data = [
            'feeData' => $feeData[0],
            'installments' => $installments,
            //'centers' => $centers,
            'courses' => $courses,
            'feedetails' => $feedetails,
            'feeHeads' => $feeHeads
        ];



        $template = View::make('feePlan.feecomponents.edit', $data)->render();

        return json_encode(['success' => true, 'template' => $template]);
        // return view('feeplan.edit',[
        //     'feeData'=>$feeData,
        //     'installments'=>$installments,
        //     'feedetails'=>$feedetails
        // ]);
    }


    public function update_feePlan(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'name' => 'required',
            'fee_type' => 'required',
            'total_fee' => 'required',
            'fee_head_id' => 'required',
            'fee_plan_id' => 'required',
            'amount' => 'required'
        ]);
        // if ($validator->fails()) {
        //     return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        // }
        $data = $request->all();
        $total = 0;
        foreach ($data['feeHeadId'] as $feeHead) {
            $total += $feeHead['amount'];
        }
        if ($total != $data['total_fee']) {
            return json_encode(['success' => false, 'message' => 'Fee Plan already exists']);

        }
        $feePlan = FeePlan::find($request->feePlanId);
        //$feePlan->center_id = $request->center_id;
        $feePlan->course_id = $request->course_id;
        $feePlan->name = $request->fee_plan_name_edit;
        $feePlan->fee_type = $request->fee_type;
        $feePlan->total_fee = $request->total_fee;
        $feePlan->save();

        $res = FeePlanDetail::where('fee_plan_id', $request->feePlanId)->delete();

        foreach ($request['feeHeadId'] as $feeHead) {
            $feeHead = new FeePlanDetail([
                'fee_head_id' => $feeHead['id'],
                'fee_plan_id' => $request->feePlanId,
                'amount' => $feeHead['amount'],
                'created_by' => Auth::user()->id
            ]);
            if ($feeHead['amount'] != 0) {
                $feeHead->save();
            }
        }
        if ($request->fee_type == 'installment') {
            $res = Installments::where('fee_plan_id', $request->feePlanId)->delete();

            foreach ($request['installments'] as $installment) {
                $installments = new Installments([
                    'fee_plan_id' => $request->feePlanId,
                    'installment_amount' => $installment['amount'],
                    'due_time' => $installment['time'],
                    'created_by' => Auth::user()->id
                ]);
                $installments->save();
            }
        }
        return json_encode(['success' => true, 'message' => 'Data Updated Successfully']);

    }


    public function feePlanDestroy($id)
    {
        $id = Crypt::decrypt($id);

        $res = FeePlanDetail::where('fee_plan_id', $id)->delete();

        $count = Installments::where(['fee_plan_id' => $id])->count();
        if ($count >= 1) {
            Installments::where('fee_plan_id', $id)->delete();
        }

        $res = FeePlan::where('id', $id)->delete();





        if ($res) {
            event(new Created("Deleted Fee Plan"));
            return redirect()->back()->with('success', 'Fee Plan Deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Fee Plan Not Deleted');
        }
    }

    public function getCoursesByCenter(Request $request, $center_id)
    {
        $assigned_courses = DB::table('assign_course_centers')
            ->leftJoin('courses', 'courses.id', '=', 'assign_course_centers.course_id')
            ->select('assign_course_centers.*', 'courses.course_name')
            ->where('center_id', $center_id)
            ->get()->toArray();
        return json_encode(['success' => true, "courses" => $assigned_courses]);
    }


}