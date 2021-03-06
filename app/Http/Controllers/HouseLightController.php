<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HouseLight;
use App\LightSetting;

use App\Jobs\TurnLightOff;
use App\Jobs\TurnLightOn;
use App\Jobs\SetLightColor;

class HouseLightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lights = HouseLight::all();
        $settings = LightSetting::all();
        return view('home',compact('lights','settings'));
    }

    /**
     * Turn light on or off as appropriate
     * @param  HouseLight $houselight
     * @return Response
     */
    public function toggle(HouseLight $houselight)
    {
        if($houselight->state==true)
        {
            $job = new TurnLightOff($houselight->light_id);
        }
        else
        {
            $job = new TurnLightOn($houselight->light_id);
        }
        $this->dispatch($job);
        return redirect('/');

    }

    public function colorchange_xy(HouseLight $houselight,$x,$y)
    {
        $job = new SetLightColor($houselight->light_id,$x,$y);
        $this->dispatch($job);
        return redirect('/');
    }

    public function colorchange_setting(Request $request, HouseLight $houselight)
    {
        $setting = LightSetting::findOrFail($request->input('lightsetting'));
        return $this->colorchange_xy($houselight,$setting->x,$setting->y);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }


    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
