<?php

namespace App\Http\Controllers;

use App\Models\SocietyReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocietyReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(SocietyReply $societyReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocietyReply $societyReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocietyReply $societyReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocietyReply $societyReply)
    {
        //
    }

    public function replySociety(Request $request, $id)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        
        $replySociety = new SocietyReply;
        $replySociety->reply = $request->reply;
        $replySociety->society_id = $id;

        if(Auth::user()->type == 'teacher' || Auth::user()->type == 'mother'){
            $replySociety->teacher_id = Auth::user()->id;
            $replySociety->user_id = 0;

        } else {
            $replySociety->user_id = Auth::user()->id;
            $replySociety->teacher_id = 0;

        }
        // $replySociety->user_id = Auth::user()->id;
        // $replySociety->teacher_id = 0;

        $replySociety->save();
        return redirect()->back();
        
    }


}
