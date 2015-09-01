<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LightSetting extends Model
{
    protected $table = 'lightsettings';

    protected $fillable = [
                'name',
                'brightness',
                'hue',
                'saturation',
                'colormode',
                'x',
                'y'
    ];
}
