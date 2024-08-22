<?php

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

if (!function_exists('gravatar')) {
    function gravatar(string $name): string
    {
        $gravatarId = md5(strtolower(trim($name)));

        return 'https://gravatar.com/avatar/' . $gravatarId . '?s=240';
    }
}

if (!function_exists('format_number')) {
    function format_number(int $number): string
    {
        return number_format($number, 0, '', '.');
    }
}

if (!function_exists('href_profile')) {
    function href_profile(string $username): string
    {
        $appurl = url(config('app.url'));

        return sprintf('%s/storage/image/profiles/%s', $appurl, $username);
    }
}

if (!function_exists('carbon')) {
    function carbon(string $parseString = '', string $tz = null): Carbon
    {
        return new Carbon($parseString, $tz);
    }
}

if (!function_exists('size_for_humans')) {
    function size_for_humans($bytes): string
    {
        if ($bytes >= 1000000000) {
            $bytes = number_format($bytes / 1000000000, 1) . 'GB';
        } elseif ($bytes >= 1000000) {
            $bytes = number_format($bytes / 1000000, 1) . 'MB';
        } elseif ($bytes >= 1000) {
            $bytes = number_format($bytes / 1000, 0) . 'KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}

if (!function_exists('unique_random')) {
    function unique_random($table, $col, $chars = 16): string
    {
        $unique = false;
        $tested = [];
        do {
            $random = Str::random($chars);
            if (in_array($random, $tested)) {
                continue;
            }

            $count = DB::table($table)->where($col, '=', $random)->count();
            $tested[] = $random;
            if ($count == 0) {
                $unique = true;
            }
        } while (!$unique);

        return $random;
    }
}

if (!function_exists('is_photo')) {
    function is_photo($path)
    {
        $exploded = explode('.', $path);
        $ext = strtolower(end($exploded));

        $photoExtensions = ['png', 'jpg', 'jpeg', 'gif', 'jfif', 'tif'];
        if (in_array($ext, $photoExtensions)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('is_video')) {
    function is_video($path)
    {
        $exploded = explode('.', $path);
        $ext = end($exploded);

        $videoExtensions = ['mov', 'mp4', 'avi', 'wmf', 'flv', 'webm'];
        if (in_array($ext, $videoExtensions)) {
            return true;
        }

        return false;
    }
}

// if (!function_exists('generate_token')) {
//     function generate_token()
//     {
//         do {
//             $token = mt_rand(100000, 999999);
//         } while (Token::where('token', $token)->exists());

//         return (string) $token;
//     }
// }

//
if (!function_exists('generateTempPassword')) {
    function generateTempPassword()
    {
        return bin2hex(random_bytes(3));
    }
}
