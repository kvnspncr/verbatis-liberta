<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['captcha'])) {
        $user_entered_code = $_POST['captcha'];
        $captcha_code = isset($_SESSION['captcha_code']) ? $_SESSION['captcha_code'] : '';

        if ($user_entered_code === $captcha_code) {
            echo "CAPTCHA verified successfully";
        } else {
            echo "CAPTCHA verification failed";
        }
    } else {
        generateCaptcha();
    }
} else {
    generateCaptcha();
}

function generateCaptcha() {
    function generateRandomCode($length = 6) {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $code;
    }

    $captcha_code = generateRandomCode(6);
    $_SESSION['captcha_code'] = $captcha_code;

    header('Content-type: image/jpeg');
    $image = imagecreatetruecolor(120, 40);
    $bg_color = imagecolorallocate($image, 0, 0, 0); // Set black background
    $text_color = imagecolorallocate($image, 0, 0, 255); // Set blue text color

    imagefilledrectangle($image, 0, 0, 120, 40, $bg_color);
    imagestring($image, 5, 20, 10, $captcha_code, $text_color);
    imagejpeg($image);
    imagedestroy($image);
}
?>