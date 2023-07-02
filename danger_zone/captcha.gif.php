<?php
// SPDX-License-Identifier: MIT
//----------------------------------------------------------------
// simple - no js needed
//////////////////////////////////////////////////////////////////
// This is a script that outputs a GIF image of random text.    //
// The text is placed in a session called "captcha".            //
// It can be used to check if the user is a bot.                //
// To prevent automatic reading, the image is filled with       //
// dots and lines.                                              //
//                                                              //
// Requires the GD library.                                     //
//////////////////////////////////////////////////////////////////

session_start();
class Captcha {
    public function generateCaptcha($width = 1240, $height = 120, $characters = 24) {
        $IP = dirname(__dir__);
        // Define characters the CAPTCHA is allowed to use.
        // Other characters will not be in the list.
        // Characters other than non-accent Latin characters and Arabic numerals, such as the letter æ,
        // may cause the captcha to use all letters it chooses to use.
        $charSet = '123456789*()&^%$£!<>{}()[]?.ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        for ($i = 0; $i < $characters; $i++) {
            $randomString .= $charSet[rand(0, strlen($charSet) - 1)];
        }
        // Create our CAPTCHA code
              $_SESSION['captcha'] = $randomString;
        // Create GD image
        $image = imagecreatetruecolor($width, $height);
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgColor);
        // Write the letters to the image
        for ($i = 0; $i < strlen($_SESSION['captcha']); $i++) {
            $textColor = imagecolorallocate($image, 0,0,0);
            imagettftext($image, 40, rand(-20, 20), ($i * ($width / strlen($_SESSION['captcha']))) + rand(5, 10), rand(($height / 2) - 10, ($height / 2) + 10), $textColor, $IP . "/captcha.ttf", $_SESSION['captcha'][$i]);
        }
        // Make the image harder to read by bots.
        for ($i = 0; $i < 75000; $i++) {
                  $dot_color = imagecolorallocate($image, 0,0,0);
                  $x = rand(0, $width);
                  $y = rand(0, $height);
                  imagesetpixel($image, $x, $y, $dot_color);
       }
       // Put the gif in the browser
       header('Content-type: image/gif');
       imagegif($image);
       // Nuke the image for security
       imagedestroy($image);
    }
}
$captcha = new Captcha();
$captcha->generateCaptcha();
