<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\Teacher\AdminAddEarlyDetectionReport;
use App\Models\Children;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Http\Controllers\Controller;
use App\Models\EarlyDetectionReport;
use App\Models\Notification;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class EarlyDetectionReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private $uploadPath = 'uploads/reports/Early Detecting Reports';

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function EarlyDetectionReports ()
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('adminHome');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $children = Children::orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view("dashboard.early-detection-report.list-child", compact("children","GeneralWebmasterSections"));
    }

    public function ShowEarlyDetectionReports ($id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('adminHome');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $child_id = $id;
        $reports = EarlyDetectionReport::where('child_id',$id)->orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view("dashboard.early-detection-report.list", compact("reports","child_id","GeneralWebmasterSections"));
    }

    public function EditEarlyDetectionReports($id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status && @Auth::user()->id != $id) {
            return redirect()->route('NoPermission');
        }
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $report = EarlyDetectionReport::find($id);

        if (!empty($report)) {
            return view("dashboard.early-detection-report.edit", compact("report", "GeneralWebmasterSections"));
        } else {
            return redirect()->action('Dashboard\EarlyDetectionReportController@EarlyDetectionReports');
        }
    }

    public function UpdateEarlyDetectionReports(Request $request, $id)
    {
        if($request->photo_delete == 1){
            $this->validate($request, [
                'file' => 'required|mimes:png,jpeg,jpg,gif,svg',
            ]);
        }
        $report = EarlyDetectionReport::find($id);
        if (!empty($report)) {
            try {
                if ($request->file) {
                    $file = time() . rand(1111, 9999) . '.' . $request->file('file')->getClientOriginalExtension();
                    $path = $this->getUploadPath();
                    $request->file->move($path, $file);
                    $report->file = $file;
                }
                $report->save();
                return redirect()->action('Dashboard\EarlyDetectionReportController@ShowEarlyDetectionReports',$report->child_id)->with('doneMessage', __('backend.addDone'));
            } catch (\Exception $e) {

            }
        }
        return redirect()->action('Dashboard\EarlyDetectionReportController@EditEarlyDetectionReports',$id)->with('errorMessage', __('backend.error'));
    }

    public function AjaxCreate($id)
    {
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }

        $message = 'Added';
        return response()->json([
            'message' => $message,
        ]);
    }

    public function EarlyDetectionReportsCreate($id)
    {
        // Check Permissions
        // dd(app()->getLocale());
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $child = Children::find($id);
        return view("dashboard.early-detection-report.create", compact("child","GeneralWebmasterSections"));
    }

    public function StoreEarlyDetectionReports(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:png,jpeg,jpg,gif,svg',
        ]);
        try {
            $children = Children::where('id', $request->child_id)->select('id' , 'name', 'teacher_id')->first();
            $teacher = Teacher::where('id', $children->teacher_id)->first();
            $report = new EarlyDetectionReport;
            if ($request->file) {
                $file = time() . rand(1111, 9999) . '.' . $request->file('file')->getClientOriginalExtension();
                $path = $this->getUploadPath();
                $request->file->move($path, $file);
                $report->file = $file;
            }
            $report->child_id = $request->child_id;
            $report->save();

            event(new AdminAddEarlyDetectionReport(' تم إضافة تقرير الكشف المبكر ل'.$children->name, $teacher->id));

            Notification::create([
                'teacher_id' => $teacher->id,
                'message' => ' تم إضافة تقرير الكشف المبكر ل'.$children->name
            ]);
            return redirect()->action('Dashboard\EarlyDetectionReportController@ShowEarlyDetectionReports',$request->child_id)->with('doneMessage', __('backend.addDone'));
        } catch (\Exception $e) {
            return redirect()->action('Dashboard\EarlyDetectionReportController@EarlyDetectionReportsCreate',$request->child_id)->with('errorMessage', __('backend.error'));
        }
    }
}

