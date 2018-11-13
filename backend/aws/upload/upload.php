<?php
/**
 * Uploads the files to the S3 file.
 * Note: Requires php.ini post_max_size 0, upload_max_filesize 0
 * Note: Requires nginx.conf client_max_body_size 0
 */

require('../inc/s3/s3Start.php');

use Aws\S3\Exception\S3Exception;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

$bucket = $config['s3']['bucket'];

// Variables for file structure
$userId = 123456;
$jobNumber = 789;
$status = "unprocessed";

// Check if the uploadedFile variable exists in the $_FILES global
if(isset($_FILES['uploadedFile'])) {
    $file = $_FILES['uploadedFile'];
   
    // File details
    $name = $file['name'];
    $tmp_name = $file['tmp_name'];

    // Headers below function is required for getallheaders() to work on nginx servers
    // See http://www.php.net/manual/en/function.getallheaders.php#84262
    if (!function_exists('getallheaders')) {
        function getallheaders() {
           $headers = [];
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;
        }
    } 
    
    $headers = getallheaders();

    // File path

    // Check if the file has an 'energy' request header
    if (isset($headers['energy'])) {
        $energy = $headers['energy'];
        
        // File path
        if (!file_exists("user_{$userId}/job_{$jobNumber}/{$status}/{$energy}")) {
            mkdir("user_{$userId}/job_{$jobNumber}/{$status}/{$energy}", 0777, true);
        }

        // Temp details
        $tmp_file_path = "user_{$userId}/job_{$jobNumber}/{$status}/{$energy}/{$name}";
    } else {
        if (!file_exists("user_{$userId}/job_{$jobNumber}/{$status}")) {
            mkdir("user_{$userId}/job_{$jobNumber}/{$status}", 0777, true);
        }
        // Temp details
        $tmp_file_path = "user_{$userId}/job_{$jobNumber}/{$status}/{$name}";
    }

    // Move the file
    move_uploaded_file($tmp_name, $tmp_file_path);
    // On AWS beanstalk this corresponds to var/app/current/backend/upload/files/
    // Need SSH to access this location.

    // Upload to S3
    $uploader = new MultipartUploader($s3, $tmp_file_path, [
            'bucket' => $bucket,
            'key'    => "{$tmp_file_path}",
        ]);
        
    try {
        $result = $uploader->upload();
        echo "Upload complete: {$result['ObjectURL']}\n";

        // Delete the file
        unlink($tmp_file_path);

    } catch (MultipartUploadException $e) {
        error_log($e);
        echo $e->getMessage() . "\n";
    }
}
?>