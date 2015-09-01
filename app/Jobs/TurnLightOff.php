<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\HouseLight;

class TurnLightOff extends Job implements SelfHandling
{
    protected $client;
    protected $light_id;
    /**
     * Create a new job instance.
     * @param int $light_id
     * @return void
     */
    public function __construct($light_id)
    {
        $this->client = new \Phue\Client(env('PHUE_BRIDGE_IP', '127.0.0.1'), env('PHUE_APP_NAME', 'my-phue-app'));
        $this->light_id = $light_id;
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
        $light->setOn(false);
        if(!$light->isOn())
        {
            $houselight->state = false;
            $houselight->save();
        }
    }
}
