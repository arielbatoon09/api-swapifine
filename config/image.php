<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Image Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default image driver to use for various image
    | manipulation functions. You may choose between the "gd" or "imagick"
    | drivers, or you may extend this package to add your own drivers.
    |
    */

    'driver' => 'imagick',

    /*
    |--------------------------------------------------------------------------
    | Image Cache
    |--------------------------------------------------------------------------
    |
    | This configuration option defines the cache settings for processed
    | images. You can specify the disk and directory where processed images
    | will be cached.
    |
    */

    'cache' => [

        'driver' => 'file',

        'path' => storage_path('app/public/image-cache'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Image Manipulation
    |--------------------------------------------------------------------------
    |
    | These settings control the image manipulation process, such as encoding
    | and quality settings for various file formats, as well as any other
    | options your image driver may support.
    |
    */

    'manipulate' => [

        'quality' => 90,

        'encoding' => 'jpg',

    ],

];


?>