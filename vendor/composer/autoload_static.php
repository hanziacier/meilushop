<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit606118fa9589414ccc658c54e031e6a1
{
    public static $files = array (
        '1cfd2761b63b0a29ed23657ea394cb2d' => __DIR__ . '/..' . '/topthink/think-captcha/src/helper.php',
        'ffc1d7141d4fcbaeb47a6929f0811ed1' => __DIR__ . '/..' . '/topthink/think-worker/src/command.php',
    );

    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\worker\\' => 13,
            'think\\composer\\' => 15,
            'think\\captcha\\' => 14,
        ),
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
        'G' => 
        array (
            'GatewayWorker\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\worker\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-worker/src',
        ),
        'think\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-installer/src',
        ),
        'think\\captcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-captcha/src',
        ),
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
        'GatewayWorker\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/gateway-worker/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit606118fa9589414ccc658c54e031e6a1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit606118fa9589414ccc658c54e031e6a1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
