<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf141b97675a61dc4f3e1551eecf15acc
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WordPress\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WordPress\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'WordPress\\WordPressAuth' => __DIR__ . '/../..' . '/src/WordPressAuth.php',
        'WordPress\\WordPressLoginUrl' => __DIR__ . '/../..' . '/src/WordPressLoginUrl.php',
        'WordPress\\WordPressMe' => __DIR__ . '/../..' . '/src/WordPressMe.php',
        'WordPress\\WordPressRequest' => __DIR__ . '/../..' . '/src/WordPressRequest.php',
        'WordPress\\WordPressStateManager' => __DIR__ . '/../..' . '/src/WordPressStateManager.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf141b97675a61dc4f3e1551eecf15acc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf141b97675a61dc4f3e1551eecf15acc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf141b97675a61dc4f3e1551eecf15acc::$classMap;

        }, null, ClassLoader::class);
    }
}