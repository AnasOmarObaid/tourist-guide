<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        return view('dashboard.setting.index');
    }//-- end index


    public function store(Request $request){

        // store setting
        setting($request->except('_token'))->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }//-- end store
}
