<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Children;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Models\PurchaseTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PurchaseTransactionController extends Controller
{
    public function index()
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('adminHome');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        // if (@Auth::user()->permissionsGroup->view_status) {
        //     $packages = PurchaseTransaction::where('created_by', '=', Auth::user()->id)->orwhere('id', '=', Auth::user()->id)->orderby('id',
        //         'asc')->paginate(env('BACKEND_PAGINATION'));
        // } else {
        $transactions = PurchaseTransaction::orderby('id', 'desc')->paginate(env('BACKEND_PAGINATION'));
        // }
        foreach ($transactions as $transaction) {
            $childrenIds = explode(',', $transaction->children_ids);
            $childrenNames = Children::whereIn('id', $childrenIds)->pluck('name')->toArray();
            $transaction->children_names = $childrenNames;
        }
        return view("dashboard.purchase-transactions.list", compact("transactions","GeneralWebmasterSections"));
    }

    public function change_status($id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }
        $transaction = PurchaseTransaction::findorfail($id);
        ($transaction->package_status  == '1') ? $transaction->package_status  = 0 : $transaction->package_status  = 1;
        $transaction->update();
        return redirect()->action('Dashboard\PurchaseTransactionController@index')->with('doneMessage', __('backend.saveDone'));

    }
}
