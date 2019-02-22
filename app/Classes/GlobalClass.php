<?php

namespace App\Classes;

use App\Posts;
use App\Portfolio;
use App\Pricing;
use DB;
use Session;
use Response;
use Image;
use Auth;
use Youtube;

class GlobalClass
{
    public function __construct()
    {
        if (!file_exists(public_path('uploaded'))) {
            mkdir(public_path('uploaded'), 0777, true);
        }
    }

    public function UploadImage($files = array())
    {
        /*Make directory target*/
        if (!file_exists($files['path'])) {
            mkdir($files['path'], 0777, true);
        }

        /*Create random name*/
        $extension = $files['file']->getClientOriginalExtension();
        $file_name = rand(111111, 999999).".".$extension;

        /*Upload default size*/
        $files['file']->move(public_path($files['path']), $file_name);

        /*
            If property width true
            Create Thumbnail and Upload
        */
        if ($files['width']) {
            Image::make($files['path'].'/'.$file_name, array(
                'width' => $files['width'],
                'grayscale' => false
            ))->save($files['path'].'/thumb-'.$file_name);
        }
        return $file_name;
    }

    public function UploadFile($files = array())
    {
        if (!file_exists($files['path'])) {
            mkdir($files['path'], 0777, true);
        }
        /*Upload Files*/
        $ext = $files['files']->getClientOriginalExtension();
        $filename = 'files_'.rand(111111, 999999).".".$ext;
        $files['files']->move($files['path'], $filename);
        return $filename;
    }

    public function removeFile($params)
    {
        for ($i=0; $i <count($params) ; $i++) {
            @unlink(public_path($params[$i]['path']).'/'.$params[$i]['files']);
        }
    }

    public function Roleback($status)
    {
        /*Role user, if status exist then going to 404 error page*/
        for ($i=0; $i < count($status); $i++) {
            if (Auth::user()->status == $status[$i]) {
                abort(404);
            }
        }
    }

    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }
        return $bytes;
    }

    public function time($time)
    {
        if ($time == null) {
            return $time = '-';
        } else {
            $time = strtotime($time);
            $time = time() - $time;
            $time = ($time<1)? 1 : $time;
            $tokens = array(
                31536000 => 'year ago',
                2592000 => 'month ago',
                604800 => 'week ago',
                86400 => 'day ago',
                3600 => 'hours ago',
                60 => 'minute ago',
                1 => 'second ago'
            );
            foreach ($tokens as $unit => $text) {
                if ($time < $unit) {
                    continue;
                }
                $numberOfUnits = floor($time / $unit);
                return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'':'');
            }
        }
    }

    public function Posts($status = 'publish')
    {
        /*Relation Posts with Users*/
        $posts = Posts::join('users', 'posts.id_user', '=', 'users.id')
            ->select('posts.*', 'users.fullname')
            ->where('posts.status', $status)
            ->where('posts.deleted_at', null)
            ->orderBy('created_at', 'DESC');
        return $posts;
    }

    public function Youtube()
    {
        Youtube::setApiKey(env('YTKEY_API'));
        $channel = Youtube::listChannelVideos(env('YTKEY_CHANNEL'));
        return $channel;
    }

    public function checkPricing($id)
    {
        $check = Pricing::findOrfail($id);
        if ($check->category == 'Docobilling') {
            return true;
        }
        return false;
    }
}
