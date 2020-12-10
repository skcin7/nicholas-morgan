<?php
/*
|--------------------------------------------------------------------------
| Custom helper functions go here
|--------------------------------------------------------------------------
|
| Add custom helper functions that could be used throughout the app here
|
*/

if (! function_exists('get_ip_address')) {
    /**
     * percentage() - get the IP address of the user accessing the service
     *
     * @return string
     */
    function get_ip_address() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

if(! function_exists('slugify')) {
    /**
     * slugify - slugify some text
     *
     * @param type $str
     * @return type
     */
    function slugify($str) {
        $clean = iconv('UTF-8', 'ASCII//IGNORE', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_| -]+/", '-', $clean);
        return $clean;
    }
}

if(! function_exists('slug_parts')) {
    /**
     * slug_parts - get a single part (segment) of a slug
     *
     * @param $slug
     * @param int $part
     * @param string $delimiter
     * @return mixed
     */
    function slug_parts($slug, $part = 0, $delimiter = '-') {
        return explode($delimiter, $slug)[$part];
    }
}
