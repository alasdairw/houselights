<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\HouseLight;
use App\Jobs\TurnLightOff;

class SetLightColor extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $client;
    protected $light_id;
    protected $x;
    protected $y;
    protected $brightness;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($light_id,$x,$y,$brightness=250)
    {
        $this->client = new \Phue\Client(env('PHUE_BRIDGE_IP', '127.0.0.1'), env('PHUE_APP_NAME', 'my-phue-app'));
        $this->light_id = $light_id;
        $this->x = $x;
        $this->y = $y;
        $this->brightness = $brightness;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $houselight = HouseLight::where('light_id', '=', $this->light_id)->firstOrFail();
        $light = $this->client->getLights()[$this->light_id];
        
        $off_after = false;
        if(!$light->isOn())
        {
            $off_after = true;
        }

        $light->setOn(true);
        $light->setXY($this->x,$this->y);
        $light->setBrightness($this->brightness);
        if($off_after)
        {
            $job = new TurnLightOff($this->light_id);
            $this->dispatch($job);
        }

        $houselight->x = $this->x;
        $houselight->y = $this->y;
        $houselight->xy = $this->x.','.$this->y;
        $houselight->brightness = $this->brightness;
        $houselight->save();
    }
}
