<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\ConsultingReport;
use App\Models\TreatmentPlan;
use App\Models\FinancialTransaction;
use App\Models\Report;
use App\Models\FinalReport;
use App\Models\User;
use App\Models\VbmapReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    private $uploadPath = 'uploads/reports/';

    public function index()
    {
        $childrenCount = Children::count();
        return view('supervisor.home', compact('childrenCount'));
    }

    public function showChildrens()
    {
        $childrens = Children::with('media')->paginate(10);
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
            $report = new VbmapReport();
            $report->children_id = $id;
            if ($request->file) {
                $file = time() . rand(1111, 9999) . '.' . $request->file('file')->getClientOriginalExtension();
                $path = $this->getUploadPath();
                $request->file->move($path, $file);
                $report->file = $file;
            }
            $report->save();
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
            $report = new TreatmentPlan();
            $report->children_id = $id;
            $report->target = $request->target;
            $report->help_type = $request->help_type;
            $report->help_description = $request->help_description;
            $report->save();
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
            $report = new FinalReport();
            $report->children_id = $id;
            $report->target = $request->target;
            $report->develop = $request->develop;
            $report->recommends = $request->recommends;

            $report->save();
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
            $report = new ConsultingReport();
            $report->children_id = $id;
            $report->type = $request->type;
            $report->problem = $request->problem;
            $report->solution = $request->solution;
            $report->save();
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
            } else {
                $user->password = '';
            }
            if ($request->file) {
                $photo = time() . rand(1111, 9999) . '.' . $request->file('photo')->getClientOriginalExtension();
                $path = $this->getUploadPath();
                $request->file->move($path, $photo);
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
