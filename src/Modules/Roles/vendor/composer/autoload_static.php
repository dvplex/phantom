<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit611def149ae8b9402eff901e4479dc98
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Modules\\Roles\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Modules\\Roles\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Modules\\Roles\\Database\\Seeders\\RolesDatabaseSeeder' => __DIR__ . '/../..' . '/Database/Seeders/RolesDatabaseSeeder.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit611def149ae8b9402eff901e4479dc98::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit611def149ae8b9402eff901e4479dc98::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit611def149ae8b9402eff901e4479dc98::$classMap;

        }, null, ClassLoader::class);
    }
}
