<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function randomString($n, $suffix = '')
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $characters = '0123456789';
        $str = '';
        for ($i = 1; $i < $n + 1; $i++) {
            if ($i % 4 === 0) {
                $str .= '-';
            } else {
                $index = rand(0, strlen($characters) - 1);
                $str .= $characters[$index];
            }
        }

        if (!empty($suffix)) {
            $str .= '-' . $suffix;
        }

        return $str;
    }

    public static function randomNumber($length)
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    public static function passwordMatch($value)
    {
        if (Hash::check($value, auth()->user()->password)) {
            return true;
        }
        return false;
    }

    public static function renameFile($path, $fileName)
    {
        $hasExt = false;
        $ext = '';
        if ($pos = strrpos($fileName, '.')) {
            // $name = substr($fileName, 0, $pos);
            $name = self::randomString(3);
            $ext = substr($fileName, $pos);
            $hasExt = true;
        } else {
            $name = $fileName;
        }

        $newPath = $path . '/' . $fileName;
        if ($hasExt) {
            $newName = $name . $ext;
        } else {
            $newName = $fileName;
        }
        $counter = 0;
        // $answer = '';

        while (Storage::disk('local')->exists($newPath)) {
            $newName = $name . '(copy' . ($counter + 1) . ')' . $ext;
            $newPath = $path . '/' . $newName;
            $counter++;
            // $answer = 'File Exists';
        }

        return $newName;

        // return 'name:' . $name . '---' . 'ext:' . $ext . '---' . 'newpath:' . $newPath . '---' . 'newname:' . $newName . '---' . 'answer:' . $answer . '---' . 'counter:' . $counter;
    }
}
