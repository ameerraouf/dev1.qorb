<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebmasterSection;
use File;

class EmployeeController extends Controller
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
            $employees = User::where('role', '!=', 'admin')->orderby('id',
                'asc')->paginate(env('BACKEND_PAGINATION'));
        } else {
            $employees = User::where('role', '!=', 'admin')->orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
        }
        return view("dashboard.employees.list", compact("employees","GeneralWebmasterSections"));
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
        
        $roles = Role::orderby('id', 'asc')->get();

        return view("dashboard.employees.create", compact("roles", "GeneralWebmasterSections"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status) {
            return redirect()->route('NoPermission');
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'phone' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|unique:employees',
            'password' => 'required|min:6',
            'photo' => 'mimes:png,jpeg,jpg,gif,svg',
            'role' => 'required'
        ]);


        // Start of Upload Files
        $formFileName = "photo";
        $fileFinalName_ar = "";
        if ($request->$formFileName != "") {
            $fileFinalName_ar = time() . rand(1111,
                    9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
            $path = $this->getUploadPath();
            $request->file($formFileName)->move($path, $fileFinalName_ar);
        }
        // End of Upload Files

        if ($request->password != "" && $request->email != "") {
            try {
                $employee = new User;
                $employee->name = $request->name;
                $employee->email = $request->email;
                $employee->phone = $request->phone;
                $employee->password = bcrypt($request->password);
                $employee->photo = $fileFinalName_ar;
                $employee->role = $request->role;
                $employee->permissions_id = 1;
                $employee->status = 1;
                $employee->save();

                return redirect()->action('Dashboard\EmployeeController@index')->with('doneMessage', __('backend.addDone'));
            } catch (\Exception $e) {
                return redirect()->back()->with('errorMessage', $e->getMessage());
            }
        }
        return redirect()->action('Dashboard\EmployeeController@index')->with('errorMessage', __('backend.error'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status && @Auth::user()->id != $id) {
            return redirect()->route('NoPermission');
        }
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $roles = Role::orderby('id', 'asc')->get();

        if (@Auth::user()->permissionsGroup->view_status) {
            $employee = Employee::where('created_by', '=', Auth::user()->id)->orwhere('id', '=', Auth::user()->id)->find($id);
        } else {
            $employee = Employee::find($id);
        }
        if (!empty($employee)) {
            return view("dashboard.employees.edit", compact("employee", "roles", "GeneralWebmasterSections"));
        } else {
            return redirect()->action('Dashboard\EmployeeController@index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status && @Auth::user()->id != $id) {
            return redirect()->route('NoPermission');
        }
        $employee = Employee::find($id);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,'. $employee->id,
            'phone' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|unique:employees,phone,'. $employee->id,
            'password' => 'required|min:6',
            'photo' => 'mimes:png,jpeg,jpg,gif,svg',
            'role_id' => 'required'
        ]);

        if (!empty($employee)) {

            try {


                // if ($request->email != $employee->email) {
                //     $this->validate($request, [
                //         'email' => 'required|email|unique:employees',
                //     ]);
                // }

                // Start of Upload Files
                $formFileName = "photo";
                $fileFinalName_ar = "";
                if ($request->$formFileName != "") {
                    $fileFinalName_ar = time() . rand(1111,
                            9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                    $path = $this->getUploadPath();
                    File::delete($this->getUploadPath() . $employee->photo);
                    $request->file($formFileName)->move($path, $fileFinalName_ar);
                    $employee->photo = $fileFinalName_ar;
                }
                // End of Upload Files

                $employee->name = $request->name;
                $employee->email = $request->email;
                $employee->phone = $request->phone;
                $employee->password = bcrypt($request->password);
                $employee->role_id = $request->role_id;
                
                if ($request->photo_delete == 1) {
                    // Delete a User file
                    if ($employee->photo != "") {
                        File::delete($this->getUploadPath() . $employee->photo);
                    }

                    $employee->photo = "";
                }
                if ($fileFinalName_ar != "") {
                    // Delete a User file
                    if ($employee->photo != "") {
                        File::delete($this->getUploadPath() . $employee->photo);
                    }

                    $employee->photo = $fileFinalName_ar;
                }

                $employee->save();
                return redirect()->action('Dashboard\EmployeeController@index', $id)->with('doneMessage', __('backend.saveDone'));
            } catch (\Exception $e) {

            }
        }
        return redirect()->action('Dashboard\EmployeeController@index');
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
        $employee = Employee::find($id);
            if ($employee->photo != "") {
                File::delete($this->getUploadPath() . $employee->photo);
            }

            $employee->delete();
            return redirect()->action('Dashboard\EmployeeController@index')->with('doneMessage', __('backend.deleteDone'));
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = Config::get('app.APP_URL') . $uploadPath;
    }
}
