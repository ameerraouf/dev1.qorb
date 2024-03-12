<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Rules\CheckSpaces;
use App\Models\MainService;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MainServiceController extends Controller
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
        $main_services = MainService::orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view("dashboard.main-services.list", compact("main_services","GeneralWebmasterSections"));
    }

    public function create()
    {
        if (!Helper::checkPermission(11)) {
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

        return view("dashboard.main-services.create", compact("GeneralWebmasterSections"));
    }

    public function store(Request $request)
    {
        if (!Helper::checkPermission(11)) {
            return redirect()->route('NoPermission');
        }
        // dd($request);
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }

        $this->validate($request, [
            'description_en' => ['required','max:1000',new CheckSpaces],
            'description_ar' => ['required','max:1000',new CheckSpaces],
            'main_service_en' => ['required','max:256',new CheckSpaces],
            'main_service_ar' => ['required','max:256',new CheckSpaces],
        ]);

        try {
            $main_service = new MainService;
            $main_service->name_ar = $request->main_service_ar;
            $main_service->name_en = $request->main_service_en;
            $main_service->description_ar = $request->description_ar;
            $main_service->description_en = $request->description_en;
            $main_service->save();
            return redirect()->action('Dashboard\MainServiceController@index')->with('doneMessage', __('backend.addDone'));
        } catch (\Exception $e) {

        }
        return redirect()->action('Dashboard\MainServiceController@create')->with('errorMessage', __('backend.error'));
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

        $main_service = MainService::find($id);

        if (!empty($main_service)) {
            return view("dashboard.main-services.edit", compact("main_service", "GeneralWebmasterSections"));
        } else {
            return redirect()->action('Dashboard\MainServiceController@index');
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
        $main_service = MainService::find($id);
        if (!empty($main_service)) {

            $this->validate($request, [
                'description_en' => ['required','max:1000',new CheckSpaces],
                'description_ar' => ['required','max:1000',new CheckSpaces],
                'name_en' => ['required','max:256',new CheckSpaces],
                'name_ar' => ['required','max:256',new CheckSpaces],
            ]);

            try {
                $main_service->name_ar = $request->name_ar;
                $main_service->name_en = $request->name_en;
                $main_service->description_en = $request->description_en;
                $main_service->description_ar = $request->description_ar;
                $main_service->save();
                return redirect()->action('Dashboard\MainServiceController@index')->with('doneMessage', __('backend.saveDone'));
            } catch (\Exception $e) {
                return redirect()->action('Dashboard\MainServiceController@edit',$id)->with('errorMessage', __('backend.error'));
            }
        }
        return redirect()->action('Dashboard\MainServiceController@edit',$id)->with('errorMessage', __('backend.error'));
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
        $main_service = MainService::find($id);
        $main_service->delete();
        return redirect()->action('Dashboard\MainServiceController@index')->with('doneMessage', __('backend.deleteDone'));
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
                // Delete User photo
                MainService::wherein('id', $request->ids)
                    ->delete();
            }
        }
        return redirect()->action('Dashboard\MainServiceController@index')->with('doneMessage', __('backend.deleteDone'));
    }

}
