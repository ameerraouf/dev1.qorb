<?php

namespace App\Http\Controllers\Teacher;

use App\Events\Teacher\SubscribePackage;
use App\Models\Report;
use App\Models\Package;
use App\Models\Children;
use App\Models\FinalReport;
use App\Models\MainService;
use App\Models\VbmapReport;
use App\Models\StatusReport;
use Illuminate\Http\Request;
use App\Models\TreatmentPlan;
use App\Http\Middleware\Teacher;
use App\Models\ConsultingReport;
use App\Models\PurchaseTransaction;
use App\Models\TeacherSubscription;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\SubService;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher as ModelsTeacher;

class HomeController extends Controller
{
    private $uploadPath = 'uploads/users/';

    public function index()
    {
        return view('teacher.home');
    }

    public function showPackages()
    {
        $packages = Package::paginate(8);
        if(app()->getLocale() == 'ar'){
            $packages->each(function ($p) {
                $p->advantages = explode(',', $p->advantages_ar);
            });
        }else{
            $packages->each(function ($p) {
                $p->advantages = explode(',', $p->advantages_en);
            });
        }
        $user = Auth::user();
        $main_services = MainService::all();
        return view('teacher.packages.list', compact('main_services','user','packages'));
    }

    public function getSubServices($id)
    {
        $main_service = MainService::find($id);

        if ($main_service) {
            $subServices = $main_service->subServices()->get(['id', 'title_ar','title_en']); // Assuming you have defined the relationship in your MainService model
            return response()->json($subServices);
        } else {
            return response()->json([]);
        }
    }

    public function checkout(Request $request)
    {
        $children_number = count($request->children_ids);
        $childrenIdsAsString = implode(',', $request->children_ids);
        $main_service_id = $request->main_service_id;
        $sub_service_id = $request->sub_service_id ?? '';
        $package = Package::find($request->package_id);
        $user = Auth::guard('teacher')->user();
        return view('teacher.checkout',compact('package','user','children_number','sub_service_id','main_service_id','childrenIdsAsString'));
    }

    public function SubscribePackage(Request $request)
    {
        try {
            $transaction = new PurchaseTransaction;

            $childrenIds = $request->children_ids;
            // dd($request->sub_service_id);
            $childrenIdsAsString = implode(',', $childrenIds);
            $package = Package::where('id', $request->package_id)->first();

            $transaction = $transaction->create([
                'main_service_id' => $request->main_service_id,
                'teacher_id' => Auth::user()->id,
                'package_id' => $request->package_id,
                'sub_service_id' => $request->sub_service_id,
                'price' => $request->price,
                'children_ids' => $childrenIdsAsString,
            ]);
            event(new SubscribePackage(' قامت المدرسة'.Auth::user()->name . ' بالاشتراك بالباقة '. $package->name));

            Notification::create([
                'teacher_id' => Auth::user()->id,
                'message' => ' قامت المدرسة'.Auth::user()->name . ' بالاشتراك بالباقة '. $package->name
            ]);

            return redirect()->route('TshowSubscriptionsPage')->with('doneMessage', __('backend.saveDone'));
        } catch (\Exception $e) {
            return redirect()->route('TshowSubscriptionsPage')->with('errorMessage', $e->getMessage());
        }
    }

    public function showSubscriptionsPage()
    {
        $transactions = PurchaseTransaction::where('teacher_id', Auth::user()->id)->paginate(10);
        foreach ($transactions as $transaction) {
            $childrenIds = explode(',', $transaction->children_ids);
            $childrenNames = Children::whereIn('id', $childrenIds)->pluck('name')->toArray();
            $transaction->children_names = $childrenNames;
            $mainService = MainService::where('id', $transaction->main_service_id)->first();
            $subService = SubService::where('id', $transaction->sub_service_id)->first();
            $transaction->main_service = $mainService;
            $transaction->sub_service = $subService;

        }
        // dd($transactions);
        // return $transactions;
        return view('teacher.subscriptions.list', compact('transactions'));
    }

    function showChildrenReports($id)
    {
        $reports = Report::where('children_id', $id)->paginate(6);
        $child_name = Children::where('id', $id)->select('name')->first()->name;
        return view('teacher.reports.list', compact('reports','child_name'));
    }

    function showChildrenConsultingReports($id)
    {
        $reports = ConsultingReport::where('children_id', $id)->paginate(6);
        return view('teacher.consulting-reports.list', compact('reports'));
    }

    function showChildrenStatusReports($id)
    {
        $reports = StatusReport::where('children_id', $id)->paginate(6);
        return view('teacher.status_reports.list', compact('reports'));
    }

    public function showChildrenVbmap($id)
    {
        $reports = VbmapReport::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('teacher.vbmap_reports.list', compact('reports', 'child_id'));
    }

    public function showChildrenTreatmentPlan($id)
    {
        $reports = TreatmentPlan::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('teacher.treatment_plans.list', compact('reports', 'child_id'));
    }

    public function showChildrenFinalReports($id)
    {
        $reports = FinalReport::where('children_id', $id)->paginate(10);
        $child_id = Children::where('id', $id)->select('id')->first()->id;
        return view('teacher.final_reports.list', compact('reports', 'child_id'));
    }

    function showTeacherProfile()
    {
        $user = Auth::user();
        return view('teacher.profile', compact('user'));
    }

    function updateTeacherProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = ModelsTeacher::find($id);
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
            return redirect()->route('TeacherProfile')->with('doneMessage', __('backend.saveDone'));
        } catch (\Exception $e) {
            return redirect()->route('TeacherProfile')->with('errorMessage', $e->getMessage());
        }
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }
}
