<?php
/**
 * Gets a list of all objects on the S3 server.
 */

require('../inc/s3/s3Start.php');

$objects = $s3->getIterator('ListObjects', [
    'Bucket' => $config['s3']['bucket'],
]);

$files = array();
$response = array('response' => 'failure',
                'files' => null
);


foreach($objects as $object) {
    array_push($files, $object['Key']);
    $response['files'] = $files;
}

if (!empty($response['files'])) {
    $response['response'] = 'success';
}

echo json_encode($response);
?>