<?php

return [
    /*
     *  Sets the primary key for the User model
     */

    'user_primary_key' => 'id',

    /*
     *  CMS default theme
     */

    'cms_theme' => env('CMS_THEME','phantom'),

    /*
     *  Available locales
     */

    'locales' => ['bg','en'],
];
