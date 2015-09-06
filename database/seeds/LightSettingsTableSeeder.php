<?php

use Illuminate\Database\Seeder;
use App\LightSetting;

class LightSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!LightSetting::all()->count() > 0)
        {    
            

          

            $csvFile = public_path().'/../resources/basic_light_settings.csv';

            $settings = $this->csv_to_array($csvFile);
            foreach($settings as $setting)
            {
                $color_data = explode(',',str_replace('(','',str_replace(')','',$setting['R,G,B'])));
                $red = $color_data[0];
                $green = $color_data[1];
                $blue = $color_data[2];
                $xy = json_decode($setting['XY']);
                LightSetting::create(['name'=>$setting['Name'],'red'=>$red,'green'=>$green,'blue'=>$blue,'x'=>$xy[0],'y'=>$xy[1]]);
            }
        }
    }

    public function csv_to_array($filename='', $delimiter=',')
    {
        if(!file_exists($filename) || !is_readable($filename))
        {
            return FALSE;
        }

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                {
                    $header = $row;
                }
                else
                {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
}
