<?php
session_start();
$db = $_SERVER['HTTP_DB'];

// error_log(print_r($_SERVER,true));

$link = mysqli_connect('dlr.cnkeaaeu6io4.ap-south-1.rds.amazonaws.com', 'admin', 'newpassword123', $db);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();

}

 $buck_link ='https://onstru.s3.ap-south-1.amazonaws.com/docs/';


require __DIR__ . '/vendor/autoload.php';


use Aws\S3\S3Client;
use Aws\Exception\AwsException;

?>