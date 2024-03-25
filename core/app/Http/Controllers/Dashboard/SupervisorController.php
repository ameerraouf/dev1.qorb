<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\Specialist\CreateConsultingReport;
use App\Events\Specialist\CreateFinalReport;
use App\Events\Specialist\CreateTreatmentPlan;
use App\Events\Specialist\CreateVbMap;
use App\Events\Teacher\SupervisorAddConsultingReport;
use App\Events\Teacher\SupervisorAddFinalReport;
use App\Events\Teacher\SupervisorAddTreatmentplan;
use App\Events\Teacher\SupervisorAddVbmap;
use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\ConsultingReport;
use App\Models\TreatmentPlan;
use App\Models\FinancialTransaction;
use App\Models\Report;
use App\Models\FinalReport;
use App\Models\Notification;
use App\Models\Teacher;
use App\Models\User;
use App\Models\VbmapReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    private $uploadPath = 'uploads/users/';

    public function index()
    {
        $childrenCount = Children::where('supervisor_id',Auth::user()->id)->count();
        return view('supervisor.home', compact('childrenCount'));
    }

    public function showChildrens()
    {
        $childrens = Children::with('media')->where('supervisor_id', Auth::user()->id)->paginate(10);
        return view('supervisor.childrens.list', compact('childrens'));
    }

    public function showChildrenVbmap($id)
    {
        $reports = VbmapReport::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.vbmap_reports.list', compact('reports', 'child_id'));
    }

    public function showChildrenTreatmentPlan($id)
    {
        $reports = TreatmentPlan::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.treatment_plans.list', compact('reports', 'child_id'));
    }

    public function showChildrenFinalReports($id)
    {
        $reports = FinalReport::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.final_reports.list', compact('reports', 'child_id'));
    }

    public function showFTransactions()
    {
        $transactions = FinancialTransaction::where('user_id', Auth::user()->id)
            ->orderby('id', 'asc')
            ->paginate(env('BACKEND_PAGINATION'));
        return view('supervisor.financial-transactions.list', compact('transactions'));
    }

    public function createVbmapPage($id)
    {
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.vbmap_reports.create', compact('child_id'));
    }

    public function createTreatmentPlanPage($id)
    {
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.treatment_plans.create', compact('child_id'));
    }
    public function createFinalReportPage($id)
    {
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.final_reports.create', compact('child_id'));
    }

    public function editVbmapPage($id)
    {
        $report = VbmapReport::find($id);
        $children_id = Children::where('id', $report->children_id)
            ->select('id')
            ->first()->id;
        return view('supervisor.vbmap_reports.edit', compact('report', 'children_id'));
    }

    public function editTreatmentPlanPage($id)
    {
        $report = TreatmentPlan::find($id);
        $children_id = Children::where('id', $report->children_id)
            ->select('id')
            ->first()->id;
        return view('supervisor.treatment_plans.edit', compact('report', 'children_id'));
    }

    public function editFinalReportPage($id)
    {
        $report = FinalReport::find($id);
        $children_id = Children::where('id', $report->children_id)
            ->select('id')
            ->first()->id;
        return view('supervisor.final_reports.edit', compact('report', 'children_id'));
    }

    public function storeVbmap(Request $request, $id)
    {
        $this->validate($request, [
            'children_id' => 'required',
            'file' => 'required',
        ]);

        try {
            $children =  Children::where('id', $id)->select('id', 'name','specialist_id','teacher_id')->first();
            $specialist = User::where('role', 'specialist')->where('id', $children->specialist_id)->first();
            $teacher = Teacher::where('id', $children->teacher_id)->first();
            $supervisor = User::where('role', 'supervisor')->where('id', Auth::user()->id)->first();
            $report = new VbmapReport();
            $report->children_id = $id;
            if ($request->file) {
                $file = time() . rand(1111, 9999) . '.' . $request->file('file')->getClientOriginalExtension();
                $path = $this->getUploadPath();
                $request->file->move($path, $file);
                $report->file = $file;
            }

            $report->save();

            event(new CreateVbMap($children->name.' ل vb-map تم إضافة تقييم', $specialist->id));

            event(new SupervisorAddVbmap($supervisor->name.' بواسطة '.$children->name.' ل vb-map تم إضافة تقييم', $teacher->id));


            Notification::create([
                'teacher_id' => $teacher->id,
                'message' => $supervisor->name.' بواسطة '.$children->name.' ل vb-map تم إضافة تقييم'
            ]);

            Notification::create([
                'specialist_id' => $specialist->id,
                'message' => $children->name.' ل vb-map تم إضافة تقييم'
            ]);

            Notification::create([
                'supervisor_id' => $supervisor->id,
                'message' => $children->name.' ل vb-map لقد قمتِ بإضافة تقرير '
            ]);

            return redirect()->route('showChildrenVbmap', $id)->with('doneMessage', __('backend.addDone'));

        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->route('showChildrenVbmap', $id)->with('errorMessage', __('backend.error'));
    }

    public function storeTreatmentPlan(Request $request, $id)
    {
        $this->validate($request, [
            'children_id' => 'required',
            'target' => 'max:1000',
            'help_type' => 'max:255',
            'help_description' => 'max:255',
        ]);

        try {
            $children =  Children::where('id', $id)->select('id', 'name','specialist_id','teacher_id')->first();
            $specialist = User::where('role', 'specialist')->where('id', $children->specialist_id)->first();
            $teacher = Teacher::where('id', $children->teacher_id)->first();
            $supervisor = User::where('role', 'supervisor')->where('id', Auth::user()->id)->first();
            $admin = User::where('role', 'admin')->where('id', Auth::user()->id)->first();
            $report = new TreatmentPlan();
            $report->children_id = $id;
            $report->target = $request->target;
            $report->help_type = $request->help_type;
            $report->help_description = $request->help_description;
            $report->save();

            event(new CreateTreatmentPlan($children->name.' تم إضافة الخطة العلاجية ل', $specialist->id));

            event(new SupervisorAddTreatmentplan($supervisor->name.' بواسطة '.$children->name.' تم إضافة الخطة العلاجية ل', $teacher->id));


            Notification::create([
                'teacher_id' => $teacher->id,
                'admin_id' => $admin->id,
                'message' => $supervisor->name.' بواسطة '.$children->name.' تم إضافة الخطة العلاجية ل'
            ]);

            Notification::create([
                'specialist_id' => $specialist->id,
                'message' => $children->name.' تم إضافة الخطة العلاجية ل'

            ]);
            Notification::create([
                'supervisor_id' => $supervisor->id,
                'message' => $children->name.' لقد قمتِ بإضافة تقرير الخطة العلاجية ل'

            ]);

            return redirect()->route('showChildrenTreatmentPlan', $id)->with('doneMessage', __('backend.addDone'));
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->route('showChildrenTreatmentPlan', $id)->with('errorMessage', __('backend.error'));
    }

    public function storeFinalReport(Request $request, $id)
    {
        $this->validate($request, [
            'children_id' => 'required',
            'target' => 'required|max:1000',
            'develop' => 'required|numeric',
            'recommends' => 'required|max:1000',
        ]);

        try {
            $children =  Children::where('id', $id)->select('id', 'name','specialist_id', 'teacher_id')->first();
            $specialist = User::where('role', 'specialist')->where('id', $children->specialist_id)->first();
            $supervisor = User::where('role', 'supervisor')->where('id', Auth::user()->id)->first();
            $admin = User::where('role', 'admin')->where('id', Auth::user()->id)->first();
            $teacher = Teacher::where('id', $children->teacher_id)->first();
            $report = new FinalReport();
            $report->children_id = $id;
            $report->target = $request->target;
            $report->develop = $request->develop;
            $report->recommends = $request->recommends;

            $report->save();
            event(new CreateFinalReport($children->name.' تم إضافة التقرير النهائى ل', $specialist->id));

            event(new SupervisorAddFinalReport($supervisor->name.' بواسطة '.$children->name.' تم إضافة التقرير النهائى ل', $teacher->id));


            Notification::create([
                'teacher_id' => $teacher->id,
                'admin_id' => $admin->id,
                'message' => $supervisor->name.' بواسطة '.$children->name.' تم إضافة التقرير النهائى ل'
            ]);

            Notification::create([
                'specialist_id' => $specialist->id,
                'message' => $children->name.' تم إضافة التقرير النهائى ل'

            ]);

            Notification::create([
                'supervisor_id' => $supervisor->id,
                'message' => $children->name.' لقد قمتِ بإضافة التقرير النهائى ل'

            ]);

            return redirect()->route('showChildrenFinalReports', $id)->with('doneMessage', __('backend.addDone'));
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->route('showChildrenFinalReports', $id)->with('errorMessage', __('backend.error'));
    }

    public function updateVbmap(Request $request, $id)
    {
        $report = VbmapReport::find($id);
        if (!empty($report)) {
            try {
                if ($request->file) {
                    $file = time() . rand(1111, 9999) . '.' . $request->file('file')->getClientOriginalExtension();
                    $path = $this->getUploadPath();
                    $request->file->move($path, $file);
                    $report->file = $file;
                }
                $report->save();
                return redirect()
                    ->route('showChildrenVbmap', $report->children_id)
                    ->with('doneMessage', __('backend.saveDone'));
            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }
        }
        return redirect()
            ->route('showChildrenVbmap', $report->children_id)
            ->with('errorMessage', __('backend.error'));
    }

    public function updateTreatmentPlan(Request $request, $id)
    {
        $report = TreatmentPlan::find($id);
        if (!empty($report)) {
            $this->validate($request, [
                'target' => 'max:1000',
                'help_type' => 'max:255',
                'help_description' => 'max:255',
            ]);

            try {
                $report->target = $request->target;
                $report->help_type = $request->help_type;
                $report->help_description = $request->help_description;
                $report->save();
                return redirect()
                    ->route('showChildrenTreatmentPlan', $report->children_id)
                    ->with('doneMessage', __('backend.saveDone'));
            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }
        }
        return redirect()
            ->route('showChildrenTreatmentPlan', $report->children_id)
            ->with('errorMessage', __('backend.error'));
    }

    public function updateFinalReport(Request $request, $id)
    {
        $report = FinalReport::find($id);
        if (!empty($report)) {
            $this->validate($request, [
                'target' => 'required|max:1000',
                'develop' => 'required|numeric',
                'recommends' => 'required|max:1000',
            ]);

            try {
                $report->target = $request->target;
                $report->develop = $request->develop;
                $report->recommends = $request->recommends;
                $report->save();
                return redirect()
                    ->route('showChildrenFinalReports', $report->children_id)
                    ->with('doneMessage', __('backend.saveDone'));
            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }
        }
        return redirect()
            ->route('showChildrenFinalReports', $report->children_id)
            ->with('errorMessage', __('backend.error'));
    }

    public function showChildrenConsultingReports($id)
    {
        $reports = ConsultingReport::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.consulting_reports.list', compact('reports', 'child_id'));
    }


    public function createConsultingReportPage($id)
    {
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.consulting_reports.create', compact('child_id'));
    }



    public function editConsultingReportPage($id)
    {
        $report = ConsultingReport::find($id);
        $children_id = Children::where('id', $report->children_id)
            ->select('id')
            ->first()->id;
        return view('supervisor.consulting_reports.edit', compact('report', 'children_id'));
    }


    public function storeConsultingReport(Request $request, $id)
    {
        $this->validate($request, [
            'children_id' => 'required',
            'type' => 'required|max:255',
            'problem' => 'required|max:1000',
            'solution' => ['required', 'max:1000'],
        ]);

        try {
            $children =  Children::where('id', $id)->select('id', 'name','specialist_id','teacher_id')->first();
            $specialist = User::where('role', 'specialist')->where('id', $children->specialist_id)->first();
            $supervisor = User::where('role', 'supervisor')->where('id', Auth::user()->id)->first();
            // who will be the admin ?
            $admin = User::where('role', 'admin')->first();
            $teacher = Teacher::where('id', $children->teacher_id)->first();
            $report = new ConsultingReport();
            $report->children_id = $id;
            $report->type = $request->type;
            $report->problem = $request->problem;
            $report->solution = $request->solution;
            $report->save();

            if($specialist){
                event(new CreateConsultingReport($children->name.' تم إضافة تقرير الاستشارات ل', $specialist->id));
            }

            event(new SupervisorAddConsultingReport($supervisor->name.' بواسطة '.$children->name.' تم إضافة الاستشارات ل', $teacher->id));

            Notification::create([
                'teacher_id' => $teacher->id,
                'admin_id' => $admin->id,
                'message' => $supervisor->name.' بواسطة '.$children->name.' تم إضافة الاستشارات ل'
            ]);

            if($specialist){
                Notification::create([
                    'specialist_id' => $specialist->id,
                    'message' => $children->name.' تم إضافة تقرير الاستشارات ل'

                ]);
            }
            Notification::create([
                'supervisor_id' => $supervisor->id,
                'message' => $children->name.' لقد قمتِ بإضافة تقرير الاستشارات ل'
            ]);


            return redirect()->route('showChildrenConsultingReports', $id)->with('doneMessage', __('backend.addDone'));
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->route('showChildrenConsultingReports', $id)->with('errorMessage', __('backend.error'));
    }
    public function updateConsultingReport(Request $request, $id)
    {
        $report = ConsultingReport::find($id);
        if (!empty($report)) {
            $this->validate($request, [
                'type' => 'required|max:255',
                'problem' => 'required|max:1000',
                'solution' => ['required', 'max:1000'],
            ]);

            try {
                $report->type = $request->type;
                $report->problem = $request->problem;
                $report->solution = $request->solution;
                $report->save();
                return redirect()
                    ->route('showChildrenConsultingReports', $report->children_id)
                    ->with('doneMessage', __('backend.saveDone'));
            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }
        }
        return redirect()
            ->route('showChildrenConsultingReports', $report->children_id)
            ->with('errorMessage', __('backend.error'));
    }

    function fileDownload($name)
    {
        try {
            return Storage::download($name);
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    function showProfile()
    {
        $user = Auth::user();
        if ($user) {
            return view('supervisor.profile', compact('user'));
        } else {
            return redirect()->back()->with('errorMessage', 'User not found');
        }
    }

    function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:6',
            'photo' => 'nullable|mimes:png,jpeg,jpg,gif,svg',
        ]);

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            if ($request->photo) {
                $photo = time() . rand(1111, 9999) . '.' . $request->file('photo')->getClientOriginalExtension();
                $path = $this->getUploadPath();
                $request->photo->move($path, $photo);
                $user->photo = $photo;
            }
            $user->update();
            return redirect()->route('SProfile')->with('doneMessage', __('backend.saveDone'));
        } catch (\Exception $e) {
            return redirect()->route('SProfile')->with('errorMessage', $e->getMessage());
        }
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }
}
