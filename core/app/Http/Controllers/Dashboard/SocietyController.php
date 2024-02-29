<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebmasterSection;


class SocietyController extends Controller
{

    // Define Default Variables

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('adminHome');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        if (@Auth::user()->permissionsGroup->view_status) {
            $societies = Society::where('created_by', '=', Auth::user()->id)->orwhere('id', '=', Auth::user()->id)->orderby('id',
                'asc')->paginate(env('BACKEND_PAGINATION'));
        } else {
            $societies = Society::orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        }
        return view("dashboard.societies.list", compact("societies","GeneralWebmasterSections"));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        return view("dashboard.societies.create", compact("GeneralWebmasterSections"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if (!@Auth::user()->permissionsGroup->settings_status) {
        //     return redirect()->route('NoPermission');
        // }

        $this->validate($request, [
            'question' => 'required|string|max:256',
            // 'question_en' => 'required|string',
        ]);


        try {
            $society = new Society;
            $society->question_ar = $request->question;
            $society->user_id = Auth::user()->id;
            $society->question_en = $request->question;
            $society->status = 0;
            $society->save();
            return redirect()->action('HomeController@Society')->with('doneMessage', ('the question will be reviewed by admin'));
        } catch (\Exception $e) {

        }
        return redirect()->action('HomeController@Society')->with('errorMessage', __('backend.error'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Society $society)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Society $society)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Society $society)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }
        $society = Society::find($id);

        $society->delete();

        return redirect()->action('Dashboard\SocietyController@index')->with('doneMessage', __('backend.deleteDone'));
    }

    public function change_status($id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }
        $society = Society::findorfail($id);
        ($society->status  == '1') ? $society->status  = 0 : $society->status  = 1;
        $society->update();
        return redirect()->action('Dashboard\SocietyController@index')->with('doneMessage', __('backend.saveDone'));

    }
}
