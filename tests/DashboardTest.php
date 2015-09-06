<?php
//TODO: need much better/consistent Application State setup - these test rely heavily on a basic
//set up that reflects my house right now.
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\HouseLight;
use App\LightSetting;
use App\Jobs\TurnLightOn;
use App\Jobs\TurnLightOff;
use App\Jobs\SetLightColor;

class DashboardTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations, DatabaseTransactions, DispatchesJobs;

    /**
     * Basic check that the bashboard is rendering  
     * 
     */
    public function testDashboardLoad()
    {
        $this->initialise();
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
             ->visit('/')
             ->see($user->name);
    }

    private function turnLightOff()
    {
        $this->initialise();
        $light = HouseLight::where('light_id', 1)->first();
        $this->assertInstanceOf('App\HouseLight',$light);
        $job = new TurnLightOff($light->light_id);
        $this->dispatch($job);
    }

    public function testToggle()
    {
        $this->initialise();
        $this->turnLightOff();
        $user = factory(App\User::class)->create();
        $this->actingAs($user)
             ->visit('/')
             ->see('light_toggle_1')
             ->click('light_toggle_1')
             ->see('fa-toggle-on');
    }
}