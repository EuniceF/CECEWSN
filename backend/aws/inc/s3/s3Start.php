<?php
require '../inc/vendor/autoload.php';

use Aws\S3\S3Client;

$config = require('s3Config.php');

// S3
$s3 = S3Client::factory([
    'region' => $config['s3']['region'],
    'version' => $config['s3']['version'],
    'credentials' => array(
        'key' => $config['s3']['key'],
        'secret' => $config['s3']['secret'],
    )
]);