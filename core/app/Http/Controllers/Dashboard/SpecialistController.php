<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\Supervisor\ConsultingReportCreated;
use App\Events\Supervisor\SessionsReportCreated;
use App\Events\Supervisor\StatusReportCreated;
use App\Events\Teacher\SpecialistAddConsultingReport;
use App\Events\Teacher\SpecialistAddSessionReport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Children;
use App\Models\ConsultingReport;
use App\Models\FinancialTransaction;
use App\Models\Notification;
use App\Models\Report;
use App\Models\StatusReport;
use App\Models\Teacher;
use App\Models\User;
use App\Models\WebmasterSection;
use Illuminate\Support\Facades\Auth;
use Storage;

class SpecialistController extends Controller
{

    private $uploadPath = "uploads/users/";
    private $filePath = "uploads/media/";

    public function index()
    {
        $childrenCount = Children::where('specialist_id',Auth::user()->id)->count();
        return view('specialist.home', compact('childrenCount'));
    }

    public function showChildrens(){
        // return Children::with('media')->get();
        $childrens = Children::with('media')->where('specialist_id', Auth::user()->id)->paginate(10);
        return view('specialist.childrens.list', compact('childrens'));
    }

    public function showChildrenReports($id){

        $reports = Report::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id' , $id) -> select('id')->first()->id;
        return view('specialist.reports.list', compact('reports','child_id'));
    }

    public function showChildrenConsultingReports($id){

        $reports = ConsultingReport::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id' , $id) -> select('id')->first()->id;
        return view('specialist.consulting_reports.list', compact('reports','child_id'));
    }

    public function showChildrenStatusReports($id){

        $reports = StatusReport::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id' , $id) -> select('id')->first()->id;
        return view('specialist.status_reports.list', compact('reports','child_id'));
    }

    public function showFTransactions(){

        $transactions = FinancialTransaction::where('user_id', Auth::user()->id)->orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view('specialist.financial-transactions.list', compact('transactions'));
    }

    public function createReportPage($id){

        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('specialist.reports.create', compact('child_id'));
    }

    public function createConsultingReportPage($id){

        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('specialist.consulting_reports.create', compact('child_id'));
    }
    public function createStatusReportPage($id){

        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('specialist.status_reports.create', compact('child_id'));
    }

    // public function showReportPage($id){

    //     $report = Report::find($id);
    //     $children_id = Children::where('id', $report->children_id)->select('id')->first()->id;
    //     return view('specialist.reports.show', compact('report', 'children_id'));
    // }

    public function editReportPage($id){

        $report = Report::find($id);
        $children_id = Children::where('id', $report->children_id)->select('id')->first()->id;
        return view('specialist.reports.edit', compact('report', 'children_id'));
    }

    public function editConsultingReportPage($id){

        $report = ConsultingReport::find($id);
        $children_id = Children::where('id', $report->children_id)->select('id')->first()->id;
        return view('specialist.consulting_reports.edit', compact('report', 'children_id'));
    }

    public function editStatusReportPage($id){

        $report = StatusReport::find($id);
        $children_id = Children::where('id', $report->children_id)->select('id')->first()->id;
        return view('specialist.status_reports.edit', compact('report', 'children_id'));
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
            $children =  Children::where('id', $id)->select('id', 'name','supervisor_id', 'teacher_id')->first();
            $supervisor = User::where('role', 'supervisor')->where('id', $children->supervisor_id)->first();
            $specialist = User::where('role', 'specialist')->where('id', Auth::user()->id)->first();
            $teacher = Teacher::where('id', $children->teacher_id)->first();
            $report = new Report;
            $report->children_id = $id;
            $report->target = $request->target;
            $report->help_method = $request->help_method;
            $report->behaviours = $request->behaviours;
            $report->success_number = $request->success_number;
            $report->save();

            event(new SessionsReportCreated($children->name.' تم إضافة تقرير الجلسات ل', $supervisor->id));

            event(new SpecialistAddSessionReport($specialist->name.' بواسطة '.$children->name.' تم إضافة تقرير الجلسات ل', $teacher->id));

            Notification::create([
                'teacher_id' => $teacher->id,
                'message' => $supervisor->name.' بواسطة '.$children->name.' تم إضافة تقرير الجلسات ل'
            ]);

            Notification::create([
                'supervisor_id' => $supervisor->id,
                'message' => $children->name.' تم إضافة تقرير الجلسات ل'

            ]);
            Notification::create([
                'specialist_id' => $specialist->id,
                'message' => $children->name.' لقد قمتِ بإضافة تقرير الجلسات ل'
            ]);

            return redirect()->route('ChildrenReports',$id)->with('doneMessage', __('backend.addDone'));

        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->route('ChildrenReports',$id)->with('errorMessage', __('backend.error'));
    }


    public function storeConsultingReport(Request $request , $id){


        $this->validate($request, [
            'children_id'=>'required',
            'type' => 'required|max:255',
            'problem' => 'required|max:1000',
            'solution' => ['required','max:1000'],
        ]);

        try {
            $children =  Children::where('id', $id)->select('id', 'name','supervisor_id', 'teacher_id')->first();
            $supervisor = User::where('role', 'supervisor')->where('id', $children->supervisor_id)->first();
            $specialist = User::where('role', 'specialist')->where('id', Auth::user()->id)->first();
            $admin = User::where('role', 'admin')->first(); // all admins
            $teacher = Teacher::where('id', $children->teacher_id)->first();
            $report = new ConsultingReport;
            $report->children_id = $id;
            $report->type = $request->type;
            $report->problem = $request->problem;
            $report->solution = $request->solution;
            $report->save();

            if($supervisor){
                event(new ConsultingReportCreated($children->name.' تم إضافة تقرير الاستشارات ل', $supervisor->id));
            }
            event(new SpecialistAddConsultingReport($specialist->name.' بواسطة '.$children->name.' تم إضافة تقرير الاستشارات ل', $teacher->id));

            Notification::create([
                'teacher_id' => $teacher->id,
                'admin_id' => $admin->id,
                'message' => $specialist->name.' بواسطة '.$children->name.' تم إضافة تقرير الاستشارات ل'
            ]);

            if($supervisor){
                Notification::create([
                    'supervisor_id' => $supervisor->id,
                    'message' => $children->name.' تم إضافة تقرير الاستشارات ل'

                ]);
            }
            Notification::create([
                'specialist_id' => $specialist->id,
                'message' => $children->name.' لقد قمتِ بإضافة تقرير الاستشارات ل'
            ]);

            return redirect()->route('ChildrenConsultingReports',$id)->with('doneMessage', __('backend.addDone'));

        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->route('ChildrenConsultingReports',$id)->with('errorMessage', __('backend.error'));
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
            $children =  Children::where('id', $id)->select('id', 'name','supervisor_id', 'teacher_id')->first();
            $supervisor = User::where('role', 'supervisor')->where('id', $children->supervisor_id)->first();
            $specialist = User::where('role', 'specialist')->where('id', Auth::user()->id)->first();
            $admin = User::where('role', 'admin')->first();
            $teacher = Teacher::where('id', $children->teacher_id)->first();
            $report = new StatusReport;
            $report->children_id = $id;
            $report->companion = $request->companion;
            $report->status_type = $request->status_type;
            $report->strength_weakness = $request->strength_weakness;
            $report->reinforcers = $request->reinforcers;
            $report->status_target = $request->status_target;
            $report->save();

            if($supervisor){
                event(new StatusReportCreated($children->name.' تم إضافة تقرير الحالة ل', $supervisor->id));
            }

            event(new SpecialistAddConsultingReport($specialist->name.' بواسطة '.$children->name.' تم إضافة تقرير الحالة ل', $teacher->id));

            Notification::create([
                'teacher_id' => $teacher->id,
                'admin_id' => $admin->id,
                'message' => $specialist->name.' بواسطة '.$children->name.' تم إضافة تقرير الحالة ل'
            ]);

            if($supervisor){
                Notification::create([
                    'supervisor_id' => $supervisor->id,
                    'message' => $children->name.' تم إضافة تقرير الحالة ل'

                ]);
            }

            Notification::create([
                'specialist_id' => $specialist->id,
                'message' => $children->name.' لقد قمتِ بإضافة تقرير الحالة ل'
            ]);

            return redirect()->route('ChildrenStatusReports',$id)->with('doneMessage', __('backend.addDone'));

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->route('ChildrenStatusReports',$id)->with('errorMessage', __('backend.error'));
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
                return redirect()->route('ChildrenReports',$report->children_id)->with('doneMessage', __('backend.saveDone'));

            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }

        }
        return redirect()->route('ChildrenReports',$report->children_id)->with('errorMessage', __('backend.error'));
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
                return redirect()->route('ChildrenConsultingReports',$report->children_id)->with('doneMessage', __('backend.saveDone'));

            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }

        }
        return redirect()->route('ChildrenConsultingReports',$report->children_id)->with('errorMessage', __('backend.error'));
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
                return redirect()->route('ChildrenStatusReports',$report->children_id)->with('doneMessage', __('backend.saveDone'));

            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }

        }
        return redirect()->route('ChildrenStatusReports',$report->children_id)->with('errorMessage', __('backend.error'));
    }

    function fileDownload($name) {
        try{
            $filePath = $this->filePath;

            return response()->download($filePath .'/'. $name);
        }

        catch (\Exception $e) {
        return redirect()->back()->with('errorMessage', $e->getMessage());
        }

    }


    function showProfile(){
        $user = Auth::user();
        if ($user) {
            return view('specialist.profile', compact('user'));
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
            if ($request->photo) {
                $photo = time() . rand(1111,
                        9999) . '.' . $request->file('photo')->getClientOriginalExtension();
                $path = $this->getUploadPath();
                $request->photo->move($path, $photo);
                $user->photo = $photo;
            }
            $user->update();
            return redirect()->route('Profile')->with('doneMessage', __('backend.saveDone'));
        }
        catch(\Exception $e){
            return redirect()->route('Profile')->with('errorMessage', $e->getMessage());
        }
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

}
