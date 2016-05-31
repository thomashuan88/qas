<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Password {

    public function password_gen($length = 8){

    $characters = "abcdefghjkmnpqrstuvwxyz";
    $caps = "ABCDEFGHIJKLMNPRTUVWXYZ";
    $num ="23456789";
    $symbol = "@#$%^&+=.-_*";
    $randomString = '';
    $charactersLength = strlen($characters);
    $randomString .= $symbol[rand(0, 11)];
    $randomString .= $num[rand(0, 7)];
    $randomString .= $caps[rand(0, 23)];


        for ($i = 0; $i < $length-2; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
    $password = str_shuffle($randomString);
    return $password;
    }

}
