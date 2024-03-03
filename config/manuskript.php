<?php

return [

    /*
    |----------------------------------------------------
    | Manuskript Path
    |----------------------------------------------------
    | The URI path from where Manuskript can be reached.
    | Feel free to change this to anything you like.
    */
    'path' => env('MANUSKRIPT_PATH', 'manuskript'),

    /*
    |----------------------------------------------------
    | Manuskript Route Middleware
    |----------------------------------------------------
    | These middleware will get attached onto each route.
    | You may add your own middleware to this list.
    */
    'middleware' => ['web'],

    /*
    |----------------------------------------------------
    | Manuskript Filesystem
    |----------------------------------------------------
    | Here you define the default disk of the filesystem.
    | These files will be available from Manuskript.
    */
    'filesystem' => [
        'disk' => 'public',
        'folder' => null,
    ],
];
