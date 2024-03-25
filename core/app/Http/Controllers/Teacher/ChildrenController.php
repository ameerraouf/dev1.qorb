<?php

namespace App\Http\Controllers\Teacher;

use App\Events\Admin\RegisterNewChild;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\ChildrenRequest;
use App\Models\Children;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class ChildrenController extends Controller
{
   public function index()
   {
    $childrens = Children::with('mother')
      ->where('teacher_id',auth()->guard('teacher')->user()->id)
      ->latest()
      ->paginate(10);
      return view('teacher.children.index',compact('childrens'));
   }
   public function create()
   {
      return view('teacher.children.create');
   }
  
   public function store(ChildrenRequest $request)
   {
    // dd($request->all());
        $input['name'] = $request->name;
        $input['problem'] = $request->problem;
        $input['specialist_id'] = 0;
        $input['supervisor_id'] = 0;
        // $input['name_ar'] = $request->name_ar;
        // $input['name_en'] = $request->name_en;
        // $input['problem_ar'] = $request->problem_ar;
        // $input['problem_en'] = $request->problem_en;
        $input['age'] = $request->age;
        $input['teacher_id'] = auth()->guard('teacher')->user()->id;
        $children=Children::create($input);
        if ($request->file('images') && count($request->file('images')) > 0) {
            $i = 1;
            foreach ($request->file('images') as $key =>$file) {
                $file_name =  time().$file->getClientOriginalName();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $files[] = store_file($file, '/children');
                $children->media()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => true,
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }
        
        event(new RegisterNewChild('تم تسجيل طفل جديد فى النظام'));
        
        Notification::create([
            'teacher_id' => auth()->guard('teacher')->user()->id,
            'message' => 'تم تسجيل طفل جديد فى النظام'
        ]);
        
        return redirect()->route('childrens.index')->with('doneMessage', __('backend.saveDone'));
   }
   public function edit($id)
   {
       $children = Children::findOrFail($id);
       return view('teacher.children.edit',compact('children'));
   }
   public function update(ChildrenRequest $request ,$id)
   {
       $children = Children::findOrFail($id);
       $input['name'] = $request->name;
        $input['problem'] = $request->problem;
        // $input['name_ar'] = $request->name_ar;
        // $input['name_en'] = $request->name_en;
        // $input['problem_ar'] = $request->problem_ar;
        // $input['problem_en'] = $request->problem_en;
        $input['age'] = $request->age;
        $input['teacher_id'] = auth()->guard('teacher')->user()->id;
        $children->update($input);
        if ($request->file('images') && count($request->file('images')) > 0) {
            $i = $children->media()->count() +1;
            foreach ($request->file('images') as $key =>$file) {
                $file_name =  time().$file->getClientOriginalName();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $files[] = store_file($file, '/children');
                $children->media()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => true,
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

       return redirect()->route('childrens.index')->with('doneMessage', __('backend.saveDone'));
   }

   public function destroy($id){
    // dd($id);
    $children = Children::findOrFail($id);
    if($children->media()->count() > 0){
        foreach ($children->media as $media){
            if (File::exists('uploads/children/'. $media->file_name)){
                unlink('uploads/children/'. $media->file_name);
            }
            $media->delete();
        }
    }
    $children->delete();
    return redirect()->route('childrens.index')->with('doneMessage', __('backend.deleteDone'));
   }
   public function remove_image(Request $request)
    {
        $children = Children::findOrFail($request->children_id);
        $media = $children->media()->whereId($request->image_id)->first();
        if (File::exists('uploads/children/'. $media->file_name)){
            unlink('uploads/children/'. $media->file_name);
        }
        $media->delete();
        return true;
    }

}
