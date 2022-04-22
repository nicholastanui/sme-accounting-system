<?php
namespace App\V1\Interfaces;
interface SecretKeyInterface
{

    const JWT_SECRET_KEY = "6546j87rhfgbtyuno089km0ungtv7tvyoiu90in-9nyr665e6cww7900iuy";
}

// function getRandomString() {
//     $n=10;
//     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//     $randomString = '';
//
//     for ($i = 0; $i < $n; $i++) {
//         $index = rand(0, strlen($characters) - 1);
//         $randomString .= $characters[$index];
//     }
//
//     return $randomString;
// }
