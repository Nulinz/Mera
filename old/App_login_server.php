<?php

$link = mysqli_connect('dlr.cnkeaaeu6io4.ap-south-1.rds.amazonaws.com', 'admin', 'newpassword123', 'nuscmy3y_dlr_db');



if (mysqli_connect_errno()) {

  echo "Failed to connect to MySQL: " . mysqli_connect_error();

}
// else{
//   echo "✅ Connected successfully to the MySQL database.";
// }
// echo "Loading: " . __DIR__ . '/../web/vendor/autoload.php';



?>