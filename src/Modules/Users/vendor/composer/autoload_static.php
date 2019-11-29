<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit30f6b2d29db4383de6711997071132c4
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Modules\\Users\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Modules\\Users\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Modules\\Users\\Database\\Seeders\\UsersDatabaseSeeder' => __DIR__ . '/../..' . '/Database/Seeders/UsersDatabaseSeeder.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit30f6b2d29db4383de6711997071132c4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit30f6b2d29db4383de6711997071132c4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit30f6b2d29db4383de6711997071132c4::$classMap;

        }, null, ClassLoader::class);
    }
}
