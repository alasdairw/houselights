<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\HouseLight;
use App\LightSetting;
use App\Jobs\TurnLightOn;
use App\Jobs\TurnLightOff;
use App\Jobs\SetLightColor;

class HouseLightTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, DispatchesJobs;

    /**
     * This isn't ideal - it assumes a correctly set up database, and accessible lights on network
     * 
     */
    
    //use DatabaseTransactions, DatabaseMigrations;
    /**
     * Tests what happens when a light that is off is toggled on.
     *
     * @return void
     */
    public function testLightOn()
    {
        $this->initialise();
        $light = HouseLight::where('light_id', 1)->first();
        $this->assertInstanceOf('App\HouseLight',$light);
        $job = new TurnLightOn($light->light_id);
        $this->dispatch($job);
        $this->seeInDatabase('lights', ['light_id' => $light->light_id,'state'=> '1']);
    }

    /**
     * Tests what happens when a light that is on is toggled off.
     * @return void
     */
    public function testLightOff()
    {
        $this->initialise();
        $light = HouseLight::where('light_id', 1)->first();
        $this->assertInstanceOf('App\HouseLight',$light);
        $job = new TurnLightOff($light->light_id);
        $this->dispatch($job);
        $this->seeInDatabase('lights', ['light_id' => $light->light_id,'state'=> '0']);    
    }

    public function testLightColorChange()
    {
        $this->initialise();
        $this->testLightOn();
        
        $light = HouseLight::where('light_id', 1)->first();
        $this->assertInstanceOf('App\HouseLight',$light);
        
        $color = LightSetting::all()->random(1);
        $this->assertInstanceOf('App\LightSetting',$color);

        $job = new SetLightColor($light->light_id,$color->x,$color->y);
        $this->dispatch($job);
        $this->seeInDatabase('lights', ['light_id' => $light->light_id,'state'=> '1','xy'=>$color->x.','.$color->y]);
        $this->testLightOff();


    }

    /**
     * Turn off all lights after test.
     * TODO: It'd be nice to save a pre-test state and return to that.
     */
    public function tearDown()
    {
        $lights = HouseLight::all();
        foreach($lights as $light)
        {
            $job = new TurnLightOff($light->light_id);
        }
        $this->dispatch($job);
        parent::tearDown();
        
    }

}
