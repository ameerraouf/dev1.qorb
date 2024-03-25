<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\Admin\SendFinancialTransaction;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Http\Controllers\Controller;
use App\Models\FinancialTransaction;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use File;


class FinancialTransactionController extends Controller
{

    private $uploadPath = "uploads/financial-transactions/";

    // Define Default Variables

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (!Helper::checkPermission(2)) {
            return redirect()->route('NoPermission');
        }

        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('adminHome');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $transactions = FinancialTransaction::orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        return view("dashboard.financial-transactions.list", compact("transactions","GeneralWebmasterSections"));
    }

    public function create()
    {
        if (!Helper::checkPermission(2)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $users = User::where('role' , '!=' , 'admin')->get();
        
        return view("dashboard.financial-transactions.create", compact("GeneralWebmasterSections", "users"));
    }

    public function store(Request $request)
    {
        
        if (!Helper::checkPermission(2)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }

        $this->validate($request, [
            'image' => 'mimes:png,jpeg,jpg,gif,svg',
            'notes' => 'nullable|max:256',
        ]);

        // Start of Upload Files
        $formFileName = "image";
        $fileFinalName_ar = "";
        if ($request->$formFileName != "") {
            $fileFinalName_ar = time() . rand(1111,
                    9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
            $path = $this->getUploadPath();
            $request->file($formFileName)->move($path, $fileFinalName_ar);
        }
        // End of Upload Files
        $userid = User::where('id', $request->user)->select('id','name','role')->first();

        try {
            $transaction = new FinancialTransaction;
            $transaction->name = $userid->name;
            $transaction->image = $fileFinalName_ar;
            $transaction->notes = $request->notes;
            $transaction->user_id = $request->user;
            $transaction->save();
            
            event(new SendFinancialTransaction('لقد تم ارسال دفعة مالية اليك', $userid->id));
            Notification::create([
                'admin_id' => Auth()->user()->id,
                'message' => 'لقد تم ارسال دفعة مالية الى '.$userid->name
            ]);    
            if ($userid->role == 'specialist') {
                Notification::create([
                    'specialist_id' => $userid->id,
                    'message' => 'لقد تم ارسال دفعة مالية اليك '.$userid->name
                ]); 
            }
            else {
                Notification::create([
                    'supervisor_id' => $userid->id,
                    'message' => 'لقد تم ارسال دفعة مالية اليك '.$userid->name
                ]); 
            }
            return redirect()->action('Dashboard\FinancialTransactionController@index')->with('doneMessage', __('backend.addDone'));
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        return redirect()->action('Dashboard\FinancialTransactionController@index')->with('errorMessage', __('backend.error'));
    }

    public function edit($id)
    {
        if (!Helper::checkPermission(2)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status && @Auth::user()->id != $id) {
            return redirect()->route('NoPermission');
        }
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $transaction = FinancialTransaction::find($id);
        $users = User::where('role' , '!=' , 'admin')->get();

        if (!empty($transaction)) {
            return view("dashboard.financial-transactions.edit", compact("transaction", "GeneralWebmasterSections", "users"));
        } else {
            return redirect()->action('Dashboard\FinancialTransactionController@index');
        }
    }

    public function update(Request $request, $id)
    {
        if (!Helper::checkPermission(2)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status && @Auth::user()->id != $id) {
            return redirect()->route('NoPermission');
        }
        $transaction = FinancialTransaction::find($id);
        if (!empty($transaction)) {
            try {

                $this->validate($request, [
                    'image' => 'mimes:png,jpeg,jpg,gif,svg',
                    'notes' => 'nullable|max:256',
                ]);
                // Start of Upload Files
                $formFileName = "image";
                $fileFinalName_ar = "";
                if ($request->$formFileName != "") {
                    $fileFinalName_ar = time() . rand(1111,
                            9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                    $path = $this->getUploadPath();
                    File::delete($this->getUploadPath() . $transaction->image);
                    $request->file($formFileName)->move($path, $fileFinalName_ar);
                    $transaction->image = $fileFinalName_ar;
                }
                // End of Upload Files

                //$transaction->name = $request->name;
                $transaction->notes = $request->notes;
                $transaction->user_id = $request->user;
                $transaction->save();
                return redirect()->action('Dashboard\FinancialTransactionController@index', $id)->with('doneMessage', __('backend.saveDone'));
            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }
        }
        return redirect()->action('Dashboard\FinancialTransactionController@index');
    }

    public function destroy($id)
    {
        if (!Helper::checkPermission(2)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }
        $transaction = FinancialTransaction::find($id);
            if ($transaction->image != "") {
                File::delete($this->getUploadPath() . $transaction->image);
            }

            $transaction->delete();
            return redirect()->action('Dashboard\FinancialTransactionController@index')->with('doneMessage', __('backend.deleteDone'));
    }

    public function updateAll(Request $request)
    {
        if (!Helper::checkPermission(2)) {
            return redirect()->route('NoPermission');
        }
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }
        if ($request->ids != "") {
            if ($request->action == "delete") {
                // Delete User photo
                $transactions = FinancialTransaction::wherein('id', $request->ids)->where('id', '!=', 1)->get();
                foreach ($transactions as $transaction) {
                    if ($transaction->image != "") {
                        File::delete($this->getUploadPath() . $transaction->image);
                    }
                }
                FinancialTransaction::wherein('id', $request->ids)
                    ->delete();
            }
        }
        return redirect()->action('Dashboard\FinancialTransactionController@index')->with('doneMessage', __('backend.saveDone'));
    }

    public function getUploadPath()
    {
        if (!Helper::checkPermission(2)) {
            return redirect()->route('NoPermission');
        }
        return $this->uploadPath;
    }

    public function setUploadPath($uploadPath)
    {
        if (!Helper::checkPermission(2)) {
            return redirect()->route('NoPermission');
        }
        $this->uploadPath = Config::get('app.APP_URL') . $uploadPath;
    }


}
