<?php
// require_once "link.php";
include("App_login_server.php");
include("database_tables.php");
header("Access-Control-Allow-Origin: *");

date_default_timezone_set('Asia/Kolkata');
$c_on = date("Y-m-d H:i:s");
$doj = date("Y-m-d");
$status = 'Active';
function escape_string($link, $postData)
{
    $escapedData = [];
    foreach ($postData as $key => $value) {
        if (is_array($value)) {

            $escapedData[$key] = escape_string($link, $value);
        } else {

            $escapedData[$key] = mysqli_real_escape_string($link, trim($value));
        }
    }
    return $escapedData;
}

if($_POST['btn'] == "dlr"){
  echo json_encode(array("version" => '2.0.0'));

}

if ($_POST['btn'] == "google_login") {

 extract($_POST);

    $stmtuser = "SELECT `db_name` FROM `m_user` WHERE `email` = '$email'";
    $stmuser_result = mysqli_query($link, $stmtuser);



    if ($stmuser_result) {
        extract($_POST);
        $user = mysqli_fetch_assoc($stmuser_result);

         if (!$user || empty($user['db_name'])) {
            echo json_encode(array("status" => "notregistered", "message" => "User Not Registered"));
            exit();
        }

         $db_name = $user['db_name'];

         mysqli_select_db($link, $db_name);
        $master_user = "SELECT * FROM `m_emp` WHERE `mail`= '$email' LIMIT 1";
        $master_user_result = mysqli_query($link, $master_user);

        if ($master_user_result && mysqli_num_rows($master_user_result) > 0) {
            $data = mysqli_fetch_assoc($master_user_result);

            $id = $data['id'];
            $name = $data['name'];
            $des = $data['designation'];


              $s_cat = "SELECT `title` from `m_cat` where `id` = '$des' ";
              $q_cat = mysqli_query($link,$s_cat);
              $role = mysqli_fetch_assoc($q_cat)['title'];

            // $image = "SELECT `file` FROM `e_image` WHERE `fid`= '$id' AND `cat`= 'profile'  LIMIT 1";
            // $image_result = mysqli_query($link, $image);

            // $profile = mysqli_fetch_assoc($image_result);

            $list = array(
                "id" => $id,
                "name" => $name,
                "role" => $role,
                "db_name" => $db_name,
            );

            echo json_encode(array("status" => "success", "data" => $list));
        } else {
            echo json_encode(array("status" => "notregistered", "message" => "User Not Registered"));
        }
    }
    else {
        echo json_encode(array("status" => "notregistered", "message" => "Error fetching user data"));
    }
}

if ($_POST['btn'] == "login") {

 extract($_POST);

    $stmtuser = "SELECT `db_name` FROM `m_user` WHERE `user_id` = '$ph_no'";
    $stmuser_result = mysqli_query($link, $stmtuser);

    // echo json_encode(array("status" => $ph_no, "message" => "User Not Registered"));

    if ($stmuser_result) {
        extract($_POST);
        $user = mysqli_fetch_assoc($stmuser_result);

         if (!$user || empty($user['db_name'])) {
            echo json_encode(array("status" => "notregistered", "message" => "User Not Registered"));
            exit();
        }

         $db_name = $user['db_name'];

         mysqli_select_db($link, $db_name);
        $master_user = "SELECT * FROM `m_emp` WHERE `contact`= '$ph_no' AND `pwd`= '$password'  LIMIT 1";
        $master_user_result = mysqli_query($link, $master_user);

        if ($master_user_result && mysqli_num_rows($master_user_result) > 0) {
            $data = mysqli_fetch_assoc($master_user_result);

            $id = $data['id'];
            $name = $data['name'];
            $des = $data['designation'];


              $s_cat = "SELECT `title` from `m_cat` where `id` = '$des' ";
              $q_cat = mysqli_query($link,$s_cat);
              $role = mysqli_fetch_assoc($q_cat)['title'];

            // $image = "SELECT `file` FROM `e_image` WHERE `fid`= '$id' AND `cat`= 'profile'  LIMIT 1";
            // $image_result = mysqli_query($link, $image);

            // $profile = mysqli_fetch_assoc($image_result);

            // print_r($link);

            $list = array(
                "id" => $id,
                "name" => $name,
                "role" => $role,
                "db_name" => $db_name,

            );

            echo json_encode(array("status" => "success", "data" => $list));
        } else {
            echo json_encode(array("status" => "notregistered", "message" => "User Not Registered"));
        }
    }
    else {
        echo json_encode(array("status" => "notregistered", "message" => "Error fetching user data"));
    }
}
if ($_POST['btn'] == "resend_otp") {
    $dtl = escape_string($link, $_POST);
    extract($dtl);

    $randomNumber = mt_rand(1000, 9999);

     $update = "UPDATE `m_user` SET `otp`= '$randomNumber' where `user_id` = '$phno'";
    $result = mysqli_query($link,$update);

   $rand = "$randomNumber - $code";

    $mes_con = urlencode("welcome $name Your verification code is: $rand. Please enter this code to complete your registration. - ONSTRU");
    $otp_link = file_get_contents("http://promo.smso2.com/api/sendhttp.php?authkey=373776616e616e38313500&mobiles=$phno&message=$mes_con&sender=ONSTRU&route=2&country=0&DLT_TE_ID=1707172965885916248");

     echo json_encode(array("status" => "success"));

}
    if($_POST['btn'] == 'verify_user') {

           $dtl = escape_string($link, $_POST);
    extract($dtl);
         $master_user = "SELECT * FROM `m_user` WHERE `user_id`= '$contact' LIMIT 1";
        $master_user_result = mysqli_query($link, $master_user);

          if ($master_user_result && mysqli_num_rows($master_user_result) == 0) {

              $randomNumber = mt_rand(1000, 9999);
              $rand = "$randomNumber - $code";
  //   $mes_con = urlencode("Welcome $name, Thank you for showing your interest in Lucky Matrimony your OTP Pin is $rand.");

    //  $link = file_get_contents("http://sms.nulinz.com/vb/apikey.php?apikey=xzqeyWZD82jT1caQ&senderid=LukyMa&number=$ph_no&message=$mes_con");

    $mes_con = urlencode("welcome $name Your verification code is: $rand. Please enter this code to complete your registration. - ONSTRU");
    $otp_link = file_get_contents("http://promo.smso2.com/api/sendhttp.php?authkey=373776616e616e38313500&mobiles=$contact&message=$mes_con&sender=ONSTRU&route=2&country=0&DLT_TE_ID=1707172965885916248");

         $m_user = "INSERT INTO `m_user`(`c_name`, `name`, `email`, `user_id`, `pwd`, `otp`, `status`, `c_on`, `c_by`)
                                 VALUES ('$com_name','$name','$mail','$contact','$pwd','$randomNumber','$status','$c_on','1')";

                          $result = mysqli_query($link, $m_user);

    echo json_encode(array("status" => "success", "data" => "success"));
          }
          else {
 echo json_encode(array("status" => "notregistered", "message" => "User Not Registered"));
          }

    }
    if($_POST['btn'] == "Register") {
               extract($_POST);
     $master_user = "SELECT * FROM `m_user` WHERE `user_id`= '$contact' and `otp` = '$otp' LIMIT 1";
        $master_user_result = mysqli_query($link, $master_user);

          if ($master_user_result && mysqli_num_rows($master_user_result) > 0) {
              $s_db = "SELECT * FROM m_db WHERE `status` = 'free'";
                $q_db = mysqli_query($link, $s_db);
                $d_db = mysqli_fetch_assoc($q_db);
                $db_name = $d_db['db_name'] ?? 'null';

           $upd_db = "UPDATE m_db SET `status`='occupied', `occ_on`='$c_on' WHERE `db_name`='$db_name'";
           $qry_db = mysqli_query($link,$upd_db);


           $user = "UPDATE `m_user` SET `db_name`='$db_name',`otp_status`='Yes' where `user_id`= '$contact' and `otp` = '$otp'";
            $result_user =  mysqli_query($link, $user);
           create_db($db_name);

           $link = mysqli_connect('dlr.cnkeaaeu6io4.ap-south-1.rds.amazonaws.com', 'admin', 'newpassword123',$db_name);
                  extract($_POST);
           $memp = "SELECT COUNT(*) AS total_rows FROM m_emp";
            $resultmemp =  mysqli_query($link, $memp);
            $empcount = mysqli_fetch_assoc($resultmemp)['total_rows'];
            $code = 'DLR0' . $empcount + 1;

           $emp = "INSERT INTO `m_emp`( `code`, `cat`, `com_name`, `name`, `mail`, `contact`, `pwd`, `otp_status` ,`designation`, `doj`, `status`, `c_by`)
                                VALUES ('$code','company','$com_name','$name','$mail','$contact','$pwd','Yes','1','$doj','Active','1')";
          $result_emp = mysqli_query($link, $emp);


           $last_id = mysqli_insert_id($link);


              $add = "INSERT INTO m_add( f_id, status, c_by)

                  VALUES ('$last_id','Active','1')";

              $q_add = mysqli_query($link, $add);

              $profile = "INSERT INTO `m_file`( `f_id`, `cat`,  `status`,  `c_by`)

                VALUES ('$last_id','Profile','Active','1')";

          $q_profile = mysqli_query($link, $profile);

              $list = array(
                "id" => $last_id,
                "name" => $name,
                "db_name" => $db_name,
                "role" => 'Admin'
            );
         if($emp) {
           echo json_encode(array("status" => "success", "data" => $list));
         }
        }

    else {
        echo json_encode(array("status" => "notregistered", "message" => "User Not Registered"));
    }

    }

//     if($_POST['btn'] == "Register") {
//     $s_db = "SELECT * FROM m_db WHERE `status` = 'free'";
// $q_db = mysqli_query($link, $s_db);
// $d_db = mysqli_fetch_assoc($q_db);
// $db_name = $d_db['db_name'] ?? 'null';

//  $regs_dtl = escape_string($link, $_POST);

//     extract($regs_dtl);
//  $master_user = "SELECT * FROM `m_user` WHERE `user_id`= '$c_contact' LIMIT 1";
//         $master_user_result = mysqli_query($link, $master_user);

//         if ($master_user_result && mysqli_num_rows($master_user_result) == 0) {
//     $ins_regs = "INSERT INTO `m_clinic`(`clinic_name`, `dr_name`, `ph_no`, `password`, `address`, `status`, `c_by`)
//                                 VALUES('$c_name', '$c_drname','$c_contact', '$c_password', '$c_address', 'Active', 'Admin')";
//     $qry_regs = mysqli_query($link, $ins_regs);

//      $last = mysqli_insert_id($link);

//     $upd_cby = "UPDATE m_clinic SET `c_by` = '$last' WHERE `ph_no`='$c_contact'";
//     $qry_cby = mysqli_query($link, $upd_cby);

//     $upd_db = "UPDATE m_db SET `status`='occupied', `occ_on`='$curdate_time' WHERE `db_name`='$db_name'";
//     $qry_db = mysqli_query($link,$upd_db);


//     $ins_user = "INSERT INTO `m_user` (`user_id`, `db_name`, `status`, `c_by`)
//                                 VALUES('$c_contact', '$db_name','Active', 'Admin')";
//     $qry_user = mysqli_query($link, $ins_user);



//     $upd_db_name = "UPDATE m_clinic SET `db_name`='$db_name' WHERE `ph_no`='$c_contact'";
//     $qry_db_name = mysqli_query($link,$upd_db_name);

//      $list = array(
//                 "id" => $last,
//                 "c_name" => $c_name,
//                 "name" => $c_drname,
//                 "address" => $c_address,
//                 "db" => $db_name

//             );


// echo json_encode(array("status" => "success", "data" => $list));

// }
// else {
//      echo json_encode(array("status" => "notregistered"));
// }
// }

