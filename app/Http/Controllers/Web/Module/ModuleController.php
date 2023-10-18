<?php

namespace Vanguard\Http\Controllers\Web\Module;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\Module;
use Vanguard\Http\Requests\Module\CreateModuleRequest;
use Vanguard\Http\Requests\Module\UpdateModuleRequest;
use Vanguard\Events\ActivityLogEvents\Created;
use Illuminate\Support\Facades\Crypt;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modules = Module::where('name', 'LIKE', '%' . $request->search . '%')
        ->orWhere('description', 'LIKE', '%' . $request->search . '%')
        ->orWhere('duration', 'LIKE', '%' . $request->search . '%')
        ->orderBy($request->column ? Crypt::decrypt($request->column) : 'name' , $request->order ? $request->order : 'asc')
        ->paginate(5);
        $edit = false;
        if ($request->order && $request->column) {
            return view('module.partials.table' , compact('modules' , 'edit'));
        }
        return view('module.moduleList' , compact('modules' , 'edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateModuleRequest $request)
    {
        $data = $request->all() + [
            'created_by' => auth()->user()->id,
            'status' => '0'
        ];
        $last_inserted = Module::create($data);
        event(new Created("Created Course ".$request->course_name));

        $total_record = Module::count();
        $rendered_row = view('module.partials.row' , ['module' => $last_inserted , 'edit' => false , 'row_count' => 1])->render();
        return json_encode(['success' => true , 'total_record' => $total_record , 'template' => $rendered_row , "message" => 'Module Created Successfully']);
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
    public function edit(Module $module)
    {
        return view('module.partials.details', [
            'edit' => true,
            'module' => $module
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModuleRequest $request, Module $module)
    {
        $data = $request->all() + [
            'updated_by' => auth()->user()->id
        ];
        unset($data['_method']);
        unset($data['row_count']);


        $moduleToUpdate = Module::findOrFail($module->id);
        $moduleToUpdate->update($data);

        event(new Created("Updated Module ".$request->name));

        $renderedRow = view('module.partials.row' , ['module' => $moduleToUpdate , "edit" => false , 'row_count' => $request->row_count])->render();
        return json_encode(['success' => true , 'template' => $renderedRow , "message" => 'Mdoule Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        Module::whereId($module->id)->delete();
        event(new Created("Deleted Course ".$module->name));
        return redirect()->route('module.index')
            ->withSuccess(__('Module deleted successfully.'));
    }
}
