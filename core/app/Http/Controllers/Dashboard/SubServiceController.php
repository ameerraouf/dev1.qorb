<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Models\SubService;
use App\Rules\CheckSpaces;
use App\Models\MainService;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Helper::checkPermission(11)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('adminHome');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $sub_services = SubService::orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view("dashboard.sub-services.list", compact("sub_services","GeneralWebmasterSections"));
    }

    public function create()
    {
        if (!Helper::checkPermission(11)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $main_services = MainService::all();

        return view("dashboard.sub-services.create", compact("GeneralWebmasterSections", "main_services"));
    }

    public function store(Request $request)
    {
        if (!Helper::checkPermission(11)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }

        $this->validate($request, [
            'title_ar' => 'required|max:256',
            'title_en' => 'required|max:256',
            'description_en' => ['required','max:1000',new CheckSpaces],
            'description_ar' => ['required','max:1000',new CheckSpaces],
            'main_service_id' => 'required',
        ]);

        try {
            $sub_service = new SubService;
            $sub_service->title_ar = $request->title_ar;
            $sub_service->title_en = $request->title_en;
            $sub_service->description_en = $request->description_en;
            $sub_service->description_ar = $request->description_ar;
            $sub_service->main_service_id = $request->main_service_id;
            $sub_service->save();
            return redirect()->action('Dashboard\SubServiceController@index')->with('doneMessage', __('backend.addDone'));
        } catch (\Exception $e) {

        }
        return redirect()->action('Dashboard\SubServiceController@create')->with('errorMessage', __('backend.error'));
    }

    public function edit($id)
    {
        if (!Helper::checkPermission(11)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status && @Auth::user()->id != $id) {
            return redirect()->route('NoPermission');
        }
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $sub_service = SubService::find($id);
        $main_services = MainService::all();
        if (!empty($sub_service)) {
            return view("dashboard.sub-services.edit", compact("sub_service", "GeneralWebmasterSections", "main_services"));
        } else {
            return redirect()->action('Dashboard\SubServiceController@index');
        }
    }

    public function update(Request $request, $id)
    {
        if (!Helper::checkPermission(11)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status && @Auth::user()->id != $id) {
            return redirect()->route('NoPermission');
        }
        $sub_service = SubService::find($id);
        if (!empty($sub_service)) {
            try {

                $this->validate($request, [
                    'title_ar' => 'required|max:256',
                    'title_en' => 'required|max:256',
                    'description_en' => ['required','max:1000',new CheckSpaces],
                    'description_ar' => ['required','max:1000',new CheckSpaces],
                    'main_service_id' => 'required',
                ]);

                $sub_service->title_ar = $request->title_ar;
                $sub_service->title_en = $request->title_en;
                $sub_service->description_en = $request->description_en;
                $sub_service->description_ar = $request->description_ar;
                $sub_service->main_service_id = $request->main_service_id;
                $sub_service->save();

                return redirect()->action('Dashboard\SubServiceController@index')->with('doneMessage', __('backend.saveDone'));;
            } catch (\Exception $e) {
                return redirect()->action('Dashboard\SubServiceController@index', $id)->with('doneMessage',  __('backend.error'));
            }
        }
        return redirect()->action('Dashboard\SubServiceController@index', $id)->with('doneMessage',  __('backend.error'));
    }

    public function destroy($id)
    {
        if (!Helper::checkPermission(11)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }
        $sub_service = SubService::find($id);
        $sub_service->delete();
        return redirect()->action('Dashboard\SubServiceController@index')->with('doneMessage', __('backend.deleteDone'));
    }

    public function updateAll(Request $request)
    {
        if (!Helper::checkPermission(11)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }
        if ($request->ids != "") {
            if ($request->action == "delete") {
                $sub_services = SubService::wherein('id', $request->ids);
                SubService::wherein('id', $request->ids)
                    ->delete();
            }
        }
        return redirect()->action('Dashboard\SubServiceController@index')->with('doneMessage', __('backend.deleteDone'));
    }
}

