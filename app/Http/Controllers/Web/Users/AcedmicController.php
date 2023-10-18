<?php

namespace Vanguard\Http\Controllers\Web\Users;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\User;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Models\UserAcedmic;
use Vanguard\Models\UploadedDocuments;

class AcedmicController extends Controller
{

    public function __construct(private UserRepository $users)
    {
    }

    public function edit(User $user, Request $request)
    {
        $acedmic = UserAcedmic::findOrFail($request->acedmic);
        // dd($acedmic);
        return view('frontend/register.partials.academic10' , ["academic10" => $acedmic , 'edit' => true]);

    }

    public function update(User $user , UserAcedmic $acedmic , Request $request)
    {
        if ($request->file('10_th_marksheet_file')) {
            $UploadedDocuments = new UploadedDocuments();
            $fileName = time() . '_' . $request['10_th_marksheet_file']->getClientOriginalName();
            $filePath = $request->file('10_th_marksheet_file')->storeAs('uploads', $fileName, 'public');
            $UploadedDocuments->document = time() . '_' . $request['10_th_marksheet_file']->getClientOriginalName();
            $UploadedDocuments->user_id = $user->id;
            $UploadedDocuments->created_by = auth()->user()->id;
        }
        $userAcademics = UserAcedmic::find($request->academic_id);
        $userAcademics->user_id = $user->id;
        $userAcademics->qualification = "10";
        $userAcademics->institute = $request['10_th_marksheet'][0];
        $userAcademics->university = $request['10_th_marksheet'][1];
        $userAcademics->passout_year = $request['10_th_marksheet'][2];
        $userAcademics->marks = $request['10_th_marksheet'][3];
        $userAcademics->place = $request['10_th_marksheet'][4];
        $userAcademics->updated_by = auth()->user()->id;
        $userAcademics->save();

        $renderedRow = view('user.student.acedmics.row' , ['acedmic' => $userAcademics , "edit" => true , 'row_count' => $request->row_count , 'user' => $user])->render();
        return json_encode(['success' => true , 'template' => $renderedRow , 'message' => 'Academics details Updated Successfully' , 'row_count' => 1]);
    }
}
