<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Rules\CheckSpaces;
use Illuminate\Http\Request;
use App\Models\CommonQuestion;
use App\Models\WebmasterSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CommonQuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Helper::checkPermission(9)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('adminHome');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $questions = CommonQuestion::orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view("dashboard.common-questions.list", compact("questions","GeneralWebmasterSections"));
    }

    public function create()
    {
        if (!Helper::checkPermission(9)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        // dd(app()->getLocale());
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        return view("dashboard.common-questions.create", compact("GeneralWebmasterSections"));
    }

    public function store(Request $request)
    {
        if (!Helper::checkPermission(9)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }

        $this->validate($request, [
            'question_ar' => 'required|max:256',
            'question_en' => 'required|max:256',
            'answer_ar' => ['required','max:1000',new CheckSpaces],
            'answer_en' => ['required','max:1000',new CheckSpaces],
        ]);

        try {
            $question = new CommonQuestion;
            $question->question_ar = $request->question_ar;
            $question->question_en = $request->question_en;
            $question->answer_ar = $request->answer_ar;
            $question->answer_en = $request->answer_en;
            $question->save();
            return redirect()->action('Dashboard\CommonQuestionController@index')->with('doneMessage', __('backend.addDone'));
        } catch (\Exception $e) {

        }
        return redirect()->action('Dashboard\CommonQuestionController@create')->with('errorMessage', __('backend.error'));
    }

    public function edit($id)
    {
        if (!Helper::checkPermission(9)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status && @Auth::user()->id != $id) {
            return redirect()->route('NoPermission');
        }
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $question = CommonQuestion::find($id);

        if (!empty($question)) {
            return view("dashboard.common-questions.edit", compact("question", "GeneralWebmasterSections"));
        } else {
            return redirect()->action('Dashboard\CommonQuestionController@index');
        }
    }

    public function update(Request $request, $id)
    {
        if (!Helper::checkPermission(9)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status && @Auth::user()->id != $id) {
            return redirect()->route('NoPermission');
        }
        $question = CommonQuestion::find($id);
        if (!empty($question)) {

            $this->validate($request, [
                'question_ar' => 'required|max:256',
                'question_en' => 'required|max:256',
                'answer_ar' => ['required','max:1000',new CheckSpaces],
                'answer_en' => ['required','max:1000',new CheckSpaces],
            ]);

            try {
                $question->question_ar = $request->question_ar;
                $question->question_en = $request->question_en;
                $question->answer_ar = $request->answer_ar;
                $question->answer_en = $request->answer_en;
                $question->save();
                return redirect()->action('Dashboard\CommonQuestionController@index')->with('doneMessage', __('backend.saveDone'));
            } catch (\Exception $e) {

            }
        }
        return redirect()->action('Dashboard\CommonQuestionController@edit',$id)->with('errorMessage', __('backend.error'));
    }

    public function destroy($id)
    {
        if (!Helper::checkPermission(9)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }
        $question = CommonQuestion::find($id);
        $question->delete();
        return redirect()->action('Dashboard\CommonQuestionController@index')->with('doneMessage', __('backend.deleteDone'));
    }

    public function updateAll(Request $request)
    {
        if (!Helper::checkPermission(9)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }
        if ($request->ids != "") {
            if ($request->action == "delete") {
                // Delete User photo
                CommonQuestion::wherein('id', $request->ids)
                    ->delete();
            }
        }
        return redirect()->action('Dashboard\CommonQuestionController@index')->with('doneMessage', __('backend.saveDone'));
    }

}
