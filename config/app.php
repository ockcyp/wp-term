<?php

return array(
    'post_src' => 'post_src_db',
    'post_src_file' => array(
        'type' => 'file',
        'path' => 'posts.csv',
    ),
    'post_src_db' => array(
        'type' => 'db',
        'driver' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'wordpress',
        'username' => 'wpterm',
        'password' => 'tas3RE',
    ),
);
