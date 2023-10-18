<?php

namespace Vanguard\Http\Controllers\web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\Center;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Vanguard\Http\Requests\Center\CreateCenterRequest;
use Vanguard\Http\Requests\Center\UpdateCenterRequest;
use Vanguard\Events\ActivityLogEvents\Created;
use DB;

class CenterController extends Controller
{
    public function index(Request $request)
    {
        $centers = Center::where('center_name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('center_location', 'LIKE', '%' . $request->search . '%')
            ->orWhere('center_email', 'LIKE', '%' . $request->search . '%')
            ->orWhere('contact_person', 'LIKE', '%' . $request->search . '%')
            ->orderBy($request->column ? Crypt::decrypt($request->column) : 'center_name', $request->order ? $request->order : 'asc')
            ->paginate(10);
        $edit = false;
        if ($request->order && $request->column) {
            return view('center.table', compact('centers', 'edit'));
        }
        $data['centers'] = $centers;
        $data['edit'] = false;
        return view('center.index', $data);
    }
    public function create()
    {
        return view('center.create');
    }

    public function store(CreateCenterRequest $request)
    {
        $center = new Center();
        $center->center_name = $request->center_name;
        $center->center_location = $request->center_location;
        $center->center_email = $request->center_email;
        $center->contact_person = $request->contact_person;
        $center->contact_number = $request->contact_number;
        $center->center_code = $request->center_code;
        $center->created_by = Auth::user()->id;
        $center->save();
        event(new Created("Created Center " . $request->center_name));
        $last_inserted = $center;
        $total_record = Center::count();
        $rendered_row = view('center.row', ['center' => $last_inserted, 'edit' => false, 'row_count' => 1])->render();
        return json_encode(['success' => true, 'total_record' => $total_record, 'template' => $rendered_row, "message" => 'Center Created Successfully']);
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $center = Center::where('id', $id)->first();
        return view('center.create', ['center' => $center, 'edit' => true]);
    }

    public function update(UpdateCenterRequest $request, $id)
    {
        $center = Center::find($id);
        $center->center_name = $request->center_name;
        $center->center_location = $request->center_location;
        $center->center_email = $request->center_email;
        $center->contact_person = $request->contact_person;
        $center->contact_number = $request->contact_number;
        $center->center_code = $request->center_code;
        $center->updated_by = Auth::user()->id;

        $center->save();
        event(new Created("Center Updated " . $request->center_name));
        $updatedData = $center;
        $renderedRow = view('center.row', ['center' => $updatedData, "edit" => false, 'row_count' => $request->row_count])->render();
        return json_encode(['success' => true, 'template' => $renderedRow, 'message' => 'Center Updated Successfully']);
    }
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $center = Center::find($id);
        $centerDeleted = $center->delete(); //returns true/false
        if ($centerDeleted) {
            event(new Created("Deleted Center " . $center->center_name));
            return redirect()->back()->with('success', 'Center Deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Center Not Deleted');
        }
    }

}