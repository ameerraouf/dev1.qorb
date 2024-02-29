<?php


namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebmasterSection;
use File;
class ClientController extends Controller
{

    private $uploadPath = "uploads/employees/";

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
            $employees = Employee::where('created_by', '=', Auth::user()->id)->orwhere('id', '=', Auth::user()->id)->orderby('id',
                'asc')->paginate(env('BACKEND_PAGINATION'));
        } else {
            $clients = Teacher::orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        }
        return view("dashboard.clients.list", compact("clients","GeneralWebmasterSections"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
