<?php
/**
 * Downloads files from the S3 server and transfered them to the web server for download.
 */

require '../inc/s3/s3start.php';

// Get the json data from the form body
$json = file_get_contents('php://input');

// Convert the json form data to an array
$data = json_decode($json, true);

$userName = $data['userName'];
$jobNumber = $data['jobNumber'];
$filePath = $data['filePath'];
$fileName = basename($filePath);
$s3Key = "user_" . $userName . "/job_" . $jobNumber . "/results/" . $fileName;

    try {
        // Get the object.
        $result = $s3->getObject([
            'Bucket'                     => $config['s3']['bucket'],
            'Key'                        => $s3Key, // need to get from get request
            'ResponseContentType'        => 'text/plain',
            'ResponseContentLanguage'    => 'en-US',
            'ResponseContentDisposition' => 'attachment; filename='.$fileName.'',
            'ResponseCacheControl'       => 'No-cache',
            'ResponseExpires'            => gmdate(DATE_RFC2822, time() + 3600),
        ]);

        if (!file_exists("user_{$userName}/job_{$jobNumber}/results")) {
            mkdir("user_{$userName}/job_{$jobNumber}/results", 0744, true);
        }
        // Create the file on the server
        file_put_contents("user_{$userName}/job_{$jobNumber}/results/{$fileName}", $result['Body']);
        
    } catch (S3Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
?>