<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\ConsultingReport;
use App\Models\FinancialTransaction;
use App\Models\Report;
use App\Models\StatusReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    private $uploadPath = "uploads/users/";

    public function index()
    {
        $childrenCount = Children::count();
        return view('supervisor.home', compact('childrenCount'));
    }


    public function showChildrens(){
        $childrens = Children::with('media')->paginate(10);
        return view('supervisor.childrens.list', compact('childrens'));
    }

    public function showChildrenReports($id){
        
        $reports = Report::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id' , $id) -> select('id')->first()->id;
        return view('supervisor.reports.list', compact('reports','child_id'));
    }

    public function showChildrenConsultingReports($id){
        
        $reports = ConsultingReport::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id' , $id) -> select('id')->first()->id;
        return view('supervisor.consulting_reports.list', compact('reports','child_id'));
    }

    public function showChildrenStatusReports($id){
        
        $reports = StatusReport::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id' , $id) -> select('id')->first()->id;
        return view('supervisor.status_reports.list', compact('reports','child_id'));
    }

    public function showFTransactions(){
        
        $transactions = FinancialTransaction::where('user_id', Auth::user()->id)->orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view('supervisor.financial-transactions.list', compact('transactions'));
    }

    public function createReportPage($id){
        
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.reports.create', compact('child_id'));
    } 

    public function createConsultingReportPage($id){
        
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.consulting_reports.create', compact('child_id'));
    } 
    public function createStatusReportPage($id){
        
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('supervisor.status_reports.create', compact('child_id'));
    } 

    public function editReportPage($id){
        
        $report = Report::find($id);
        $children_id = Children::where('id', $report->children_id)->select('id')->first()->id;
        return view('supervisor.reports.edit', compact('report', 'children_id'));
    }

    public function editConsultingReportPage($id){
        
        $report = ConsultingReport::find($id);
        $children_id = Children::where('id', $report->children_id)->select('id')->first()->id;
        return view('supervisor.consulting_reports.edit', compact('report', 'children_id'));
    }

    public function editStatusReportPage($id){
        
        $report = StatusReport::find($id);
        $children_id = Children::where('id', $report->children_id)->select('id')->first()->id;
        return view('supervisor.status_reports.edit', compact('report', 'children_id'));
    }

    public function storeReport(Request $request , $id){
        
        
        $this->validate($request, [
            'children_id'=>'required',
            'target' => 'required|max:256',
            'help_method' => 'required|max:1000',
            'behaviours' => ['required','max:1000'],
            'success_number' => ['required','numeric', 'gt:0'],
        ]);

        try {
            $report = new Report;
            $report->children_id = $id;
            $report->target = $request->target;
            $report->help_method = $request->help_method;
            $report->behaviours = $request->behaviours;
            $report->success_number = $request->success_number;
            $report->save();
            return redirect()->route('SChildrenReports',$id)->with('doneMessage', __('backend.addDone'));

        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->route('SChildrenReports',$id)->with('errorMessage', __('backend.error'));
    }  


    public function storeConsultingReport(Request $request , $id){
        
        
        $this->validate($request, [
            'children_id'=>'required',
            'type' => 'required|max:255',
            'problem' => 'required|max:1000',
            'solution' => ['required','max:1000'],
        ]);

        try {
            $report = new ConsultingReport;
            $report->children_id = $id;
            $report->type = $request->type;
            $report->problem = $request->problem;
            $report->solution = $request->solution;
            $report->save();
            return redirect()->route('SChildrenConsultingReports',$id)->with('doneMessage', __('backend.addDone'));

        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->route('SChildrenConsultingReports',$id)->with('errorMessage', __('backend.error'));
    } 

    public function storeStatusReport(Request $request , $id){
        
        
        $this->validate($request, [
            'children_id'=>'required',
            'companion' => 'required|max:255',
            'status_type' => 'required',
            'strength_weakness' => 'required|max:1000',
            'reinforcers' => 'required|max:1000',
            'status_target' => 'required|max:1000',
        ]);

        try {
            $report = new StatusReport;
            $report->children_id = $id;
            $report->companion = $request->companion;
            $report->status_type = $request->status_type;
            $report->strength_weakness = $request->strength_weakness;
            $report->reinforcers = $request->reinforcers;
            $report->status_target = $request->status_target;
            $report->save();
            return redirect()->route('SChildrenStatusReports',$id)->with('doneMessage', __('backend.addDone'));

        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->route('SChildrenStatusReports',$id)->with('errorMessage', __('backend.error'));
    } 
    
    public function updateReport(Request $request , $id){
        
        $report = Report::find($id);
        if(!empty($report)){

            $this->validate($request, [
                'target' => 'required|max:256',
                'help_method' => 'required|max:1000',
                'behaviours' => ['required','max:1000'],
                'success_number' => ['required','numeric', 'gt:0'],
            ]);
    
            try {
                $report->target = $request->target;
                $report->help_method = $request->help_method;
                $report->behaviours = $request->behaviours;
                $report->success_number = $request->success_number;
                $report->save();
                return redirect()->route('SChildrenReports',$report->children_id)->with('doneMessage', __('backend.saveDone'));
    
            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }

        }
        return redirect()->route('SChildrenReports',$report->children_id)->with('errorMessage', __('backend.error'));
    }

    public function updateConsultingReport(Request $request , $id){
        
        $report = ConsultingReport::find($id);
        if(!empty($report)){

            $this->validate($request, [
                'type' => 'required|max:255',
                'problem' => 'required|max:1000',
                'solution' => ['required','max:1000'],
            ]);
    
            try {
                $report->type = $request->type;
                $report->problem = $request->problem;
                $report->solution = $request->solution;
                $report->save();
                return redirect()->route('SChildrenConsultingReports',$report->children_id)->with('doneMessage', __('backend.saveDone'));
    
            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }

        }
        return redirect()->route('SChildrenConsultingReports',$report->children_id)->with('errorMessage', __('backend.error'));
    }

    public function updateStatusReport(Request $request , $id){
        
        $report = StatusReport::find($id);
        if(!empty($report)){

            $this->validate($request, [
                'companion' => 'required|max:255',
                'status_type' => 'required',
                'strength_weakness' => 'required|max:1000',
                'reinforcers' => 'required|max:1000',
                'status_target' => 'required|max:1000',
            ]);
    
            try {
                $report->companion = $request->companion;
                $report->status_type = $request->status_type;
                $report->strength_weakness = $request->strength_weakness;
                $report->reinforcers = $request->reinforcers;
                $report->status_target = $request->status_target;
                $report->save();
                return redirect()->route('SChildrenStatusReports',$report->children_id)->with('doneMessage', __('backend.saveDone'));
    
            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }

        }
        return redirect()->route('SChildrenStatusReports',$report->children_id)->with('errorMessage', __('backend.error'));
    }

    function fileDownload($name) {
        try{
            
            return Storage::download($name);
        }

        catch (\Exception $e) {
        return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        
    }


    function showProfile(){
        $user = Auth::user();
        if ($user) {
            return view('supervisor.profile', compact('user'));
        }
        else{
            return redirect()->back()->with('errorMessage', 'User not found');
        }
    }

    function updateProfile(Request $request) {
        $id = Auth::user()->id;
        $user = User::find($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:6',
            'photo' => 'nullable|mimes:png,jpeg,jpg,gif,svg',
        ]);

        try{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            else{
                $user->password = "";
            }
            if ($request->photo) {
                $photo = time() . rand(1111,
                        9999) . '.' . $request->file('photo')->getClientOriginalExtension();
                $path = $this->getUploadPath();
                $request->photo->move($path, $photo);
                $user->photo = $photo;
            }
            $user->update();
            return redirect()->route('SProfile')->with('doneMessage', __('backend.saveDone'));
        }
        catch(\Exception $e){
            return redirect()->route('SProfile')->with('errorMessage', $e->getMessage());
        }
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

}
