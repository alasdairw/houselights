<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Phue\Light;

class HouseLight extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lights';
    protected $client;

    

    public function __construct()
    {
        
    }

    public function get_lights_on_network()
    {
        try
        {
            $lights = $this->client->getLights();
            return $lights;
        }
        catch(Exception $error)
        {
            return false;
        }
    }

    public static function save_from_phue_light(Light $light)
    {
        $db_light = HouseLight::firstOrNew(['uniqueid' => $light->getUniqueid()]);
        $db_light->name = $light->getName();
        $db_light->light_id = $light->getId();
        $db_light->type = $light->getType();
        $db_light->uniqueid = $light->getUniqueId();
        $db_light->state = $light->isOn();
        $db_light->reachable = $light->isReachable();
        $db_light->brightness = $light->getBrightness();
        $db_light->hue = $light->getHue();
        $db_light->saturation = $light->getSaturation();
        $db_light->effect = $light->getEffect();
        $db_light->alert = $light->getAlert();
        $db_light->colormode = $light->getColorMode();
        $db_light->xy = $light->getXY()['x'].','.$light->getXY()['y'];
        $db_light->x = $light->getXY()['x'];
        $db_light->y = $light->getXY()['y'];

        $db_light->save();
    }

    //Simplified versions of functions from
    //https://github.com/FredBardin/phpMyHue/blob/master/include/huecolor.php

    // Convert xy to rgb color
    public static function xy_to_rgb($x,$y,$bri)
    {
        // Check if point in lamp gamut triangle
        /*
            if (checkPointInLampGamut($x,$y,$type)){
                echo "x=$x y=$y OK";
            } else {
                echo "x=$x y=$y KO";
            }
        */
        // Calculate XYZ values
        $z = 1 - $x - $y;
        $Y = $bri / 254; // Brightness coeff.
        if ($y == 0){
            $X = 0;
            $Z = 0;
        } else {
            $X = ($Y / $y) * $x;
            $Z = ($Y / $y) * $z;
        }
        // Convert to sRGB D65 (official formula on meethue)
        $r = $X * 3.2406 - $Y * 1.5372 - $Z * 0.4986;
        $g = - $X * 0.9689 + $Y * 1.8758 + $Z * 0.0415;
        $b = $X * 0.0557 - $Y * 0.204 + $Z * 1.057;
        // Apply reverse gamma correction
        $r = ($r <= 0.0031308 ? 12.92 * $r : (1.055) * pow($r, (1 / 2.4)) - 0.055);
        $g = ($g <= 0.0031308 ? 12.92 * $g : (1.055) * pow($g, (1 / 2.4)) - 0.055);
        $b = ($b <= 0.0031308 ? 12.92 * $b : (1.055) * pow($b, (1 / 2.4)) - 0.055);
        // Calculate final RGB
        $r = ($r < 0 ? 0 : round($r * 255));
        $g = ($g < 0 ? 0 : round($g * 255));
        $b = ($b < 0 ? 0 : round($b * 255));
        $r = ($r > 255 ? 255 : $r);
        $g = ($g > 255 ? 255 : $g);
        $b = ($b > 255 ? 255 : $b);
        // Create a web RGB string
        $RGB = "#".substr("0".dechex($r),-2).substr("0".dechex($g),-2).substr("0".dechex($b),-2);
        return $RGB;
    } 

    // xyToRGB
    // ------------------------------------------
    // Convert RGB to xy color + bri
    // parameter : RGB in #XXXXXX format (hexa values)
    // return json string : {"x":"xval","y":"yval","bri":"brival"}
    // ------------------------------------------
    public static function rgb_to_xy($RGB)
    {
        // Get decimal RGB
        $r = hexdec(substr($RGB,1,2));
        $g = hexdec(substr($RGB,3,2));
        $b = hexdec(substr($RGB,5,2));
        // Calculate rgb as coef
        $r = $r / 255;
        $g = $g / 255;
        $b = $b / 255;
        // Apply gamma correction
        $r = ($r > 0.04055 ? pow(($r + 0.055) / 1.055, 2.4) : ($r / 12.92));
        $g = ($g > 0.04055 ? pow(($g + 0.055) / 1.055, 2.4) : ($g / 12.92));
        $b = ($b > 0.04055 ? pow(($b + 0.055) / 1.055, 2.4) : ($b / 12.92));
        // Convert to XYZ
        $X = $r * 0.649926 + $g * 0.103455 + $b * 0.197109;
        $Y = $r * 0.234327 + $g * 0.743075 + $b * 0.022598;
        $Z = $r * 0        + $g * 0.053077 + $b * 1.035763;
        // Calculate xy and bri
        if (($X+$Y+$Z) == 0){
            $x = 0;
            $y = 0;
        } else { // round to 4 decimal max (=api max size)
            $x = round($X / ($X + $Y + $Z),4);  
            $y = round($Y / ($X + $Y + $Z),4);
        }
        $bri = round($Y * 254);
        if ($bri > 254){$bri = 254;}
        // ajust to closest point if not
        return ['xy'=>['x'=>$x,'y'=>$y],'brightness'=>$bri];
    } // RGBToXy

}
