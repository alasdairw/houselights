<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\HouseLight;
use App\Jobs\TurnLightOff;

class LightsOut extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lights:lights-out';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Turns off all the lights in the house.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $lights = HouseLight::all();
        foreach($lights as $light)
        {
            $job = new TurnLightOff($light->light_id);
            $this->dispatch($job);
        }
    }
}
