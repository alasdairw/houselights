<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\LightSetting;
use App\Http\Requests\LightSettingRequest;

class LightSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lightsettings = LightSetting::all();
        return view('lightsettings.index',compact('lightsettings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('lightsettings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(LightSettingRequest $request)
    {
        LightSetting::create($request->all());
        return redirect('lightsettings');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(LightSetting $lightsetting)
    {
        return view('lightsettings.edit',compact('lightsetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(LightSetting $lightsetting,LightSettingRequest $request)
    {
        $lightsetting->update($request->all());
        return redirect('lightsettings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
