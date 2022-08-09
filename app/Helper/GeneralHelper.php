<?php

use App\Models\User;
use App\Models\Permission;
use Spatie\Valuestore\Valuestore;
use App\Models\Post;



function path($path, $value)
{

    switch ($path) {
        case 'posts':
            return isset($value) ? Post::Post_PATH . $value : (Post::Post_PATH . Post::Post_Defualt);
            break;

        case 'users':
            return isset($value) ? User::User_PATH . $value : (User::User_PATH . User::User_Defualt);
            break;
    }
}

function getSettingsOf($key)
{
    $settings = Valuestore::make(config_path('settings.json'));
    return $settings->get($key);
}

function getUrlOf($param)
{
    $f = str_replace('admin/', '', $param);
    return $f;
}

function getParentShowOf($param)
{
    $f = str_replace('admin.', '', $param);
    $perm = Permission::where('route', $f)->first();
    return $perm ? $perm->parent_show : $f;
}

function getParentOf($param)
{
    $f = str_replace('admin.', '', $param);
    $perm = Permission::where('route', $f)->first();
    return $perm ? $perm->parent : $f;
}

function getParentIdOf($param)
{
    $f = str_replace('admin.', '', $param);
    $perm = Permission::where('route', $f)->first();
    return $perm ? $perm->id : null;
}

function getIdMenuOf($param)
{
    $perm = Permission::where('id', $param)->first();
    return $perm ? $perm->parent_show : null;
}

function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";

    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}
