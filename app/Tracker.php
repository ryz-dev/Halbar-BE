<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    public $attributes = ['hits' => 0];
    protected $fillable = ['ip_address', 'date', 'url', 'browser', 'country', 'region', 'city', 'device'];
    protected $table = 'visitors';

    public static function boot()
    {
        date_default_timezone_set('Asia/Jakarta');

        /* When a new instance of this model is created... */
        static::creating(function ($tracker) {
            $tracker->hits = 0;
        });

        /* Any time the instance is saved (create OR update) */
        static::saving(function ($tracker) {
            $tracker->hits++;
        });
    }

    /* Fill in the IP and today's date */
    public function scopeCurrent($query)
    {
        date_default_timezone_set('Asia/Jakarta');
        return $query->where('date', date('Y-m-d'));
    }

    public static function hit()
    {
        date_default_timezone_set('Asia/Jakarta');

        /* info country, region, and city */
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$ip_address"));
        $country = $geo["geoplugin_countryName"]==null?'Indonesia':$geo["geoplugin_countryName"];
        $region  = $geo["geoplugin_region"]==null?'Sulawesi Selatan':$geo["geoplugin_region"];
        $city    = $geo["geoplugin_city"]==null?'Makassar':$geo["geoplugin_city"];

        /* Browser Info */
        $info_browser = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($info_browser, "Firefox")==true) {
            $browser = "Mozilla Firefox";
        } elseif (strpos($info_browser, "Chrome")==true) {
            $browser = "Google Chrome";
        } elseif (strpos($info_browser, "IE")==true) {
            $browser = "Internet Explorer";
        } elseif (strpos($info_browser, "Opera")==true) {
            $browser = "Opera";
        } elseif (strpos($info_browser, "Navigator")==true) {
            $browser = "Netscape";
        } elseif (strpos($info_browser, "Safari")==true) {
            $browser = "Safari";
        } elseif (strpos($info_browser, "Edge")==true) {
            $browser = "Microsoft Edge";
        } else {
            $browser = "Any browser";
        }

        /* Device Info */
        $type_device = '';
        $device = "Dekstop";

        static::firstOrCreate([
          'ip_address'   => $_SERVER['REMOTE_ADDR'],
          'url'          => $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
          'browser' 	   => $browser,
          'device'       => $device,
          'country'      => $country,
          'region'       => $region,
          'city'         => $city,
        'date'         => date('Y-m-d')
      ])->save();
    }
}
