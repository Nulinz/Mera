<?php

echo "hello";

$conn = mysqli_connect('dlr.cnkeaaeu6io4.ap-south-1.rds.amazonaws.com', 'admin', 'newpassword123', 'nuscmy3y_dlr_db');


if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();

}
?>