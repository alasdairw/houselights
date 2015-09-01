<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\HouseLight;

class CheckLights extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lights:checklights';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks with the Hue bridge for lights, and light state.';

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
        $lights = new HouseLight;
        $all_lights = $lights->get_lights_on_network();
        foreach($all_lights as $light)
        {
            HouseLight::save_from_phue_light($light);
        }


    }
}
