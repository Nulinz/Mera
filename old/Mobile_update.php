<?php
include("App_server.php");
header("Access-Control-Allow-Origin: *");


date_default_timezone_set('Asia/Kolkata');
$c_on = date("Y-m-d h:i:s");
$status = 'Active';
$c_on = date("Y-m-d h:i:s");
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

// to check teh distance

function calculateEuclideanDistance(array $a, array $b): float
    {
        if (count($a) !== count($b)) {
            return PHP_FLOAT_MAX;
        }

        $sum = 0.0;
        $length = count($a);
        
        for ($i = 0; $i < $length; $i++) {
            $diff = $a[$i] - $b[$i];
            $sum += pow($diff, 2);
        }
        
        return sqrt($sum);
    }

if ($_POST['btn'] == "delete_account") {
    $dtl = escape_string($link, $_POST);
    extract($dtl);

     $up_pro = "UPDATE `m_user` SET `status` = 'InActive' WHERE `id`='$id' ";

    $q_pro = mysqli_query($link,$up_pro);

     if ($q_pro) {
        echo json_encode(array("status" => 'success'));
    } else {
        echo json_encode(array("status" => 'failed'));
    }

}
if ($_POST['btn'] == "edit_count") {
    $dtl = escape_string($link, $_POST);
    extract($dtl);

     $up_pro = "UPDATE `m_pro` SET `edited` = 'Yes' , `loc` = '$lat' WHERE `id`='$id' ";

    $q_pro = mysqli_query($link,$up_pro);

     if ($q_pro) {
        echo json_encode(array("status" => 'success'));
    } else {
        echo json_encode(array("status" => 'failed'));
    }

}
if ($_POST['btn'] == "edit_status") {
    $dtl = escape_string($link, $_POST);
    extract($dtl);

     $up_pro = "UPDATE `m_lab` SET `status` = 'pending'  WHERE `lab_id`='$id' ";

    $q_pro = mysqli_query($link,$up_pro);

     if ($q_pro) {
        echo json_encode(array("status" => 'success'));
    } else {
        echo json_encode(array("status" => 'failed'));
    }

}
if ($_POST['btn'] == "forgot_pswd") {
    $dtl = escape_string($link, $_POST);
    extract($dtl);
    $randomNumber = mt_rand(1000, 9999);
        $master_user = "SELECT * FROM `m_emp` WHERE `contact`= '$ph_no' LIMIT 1";
        $master_user_result = mysqli_query($link, $master_user);

         if ($master_user_result && mysqli_num_rows($master_user_result) > 0) {
          $data = mysqli_fetch_assoc($master_user_result);

            $id = $data['id'];
            $name = $data['name'];
           $rand = "$randomNumber - $code";

 $update = "UPDATE `m_emp` SET `otp`= '$randomNumber' where `id` = '$id'";
    $result = mysqli_query($link,$update);

    $mes_con = urlencode("Your password reset code is: $rand Use this code to reset your password. - ONSTRU");
    $otp_link = file_get_contents("http://promo.smso2.com/api/sendhttp.php?authkey=373776616e616e38313500&mobiles=$ph_no&message=$mes_con&sender=ONSTRU&route=2&country=0&DLT_TE_ID=1707172965888222588");

    //   $mes_con = urlencode("Welcome $name, Thank you for showing your interest in Lucky Matrimony your OTP Pin is $rand.");

    //  $link = file_get_contents("http://sms.nulinz.com/vb/apikey.php?apikey=xzqeyWZD82jT1caQ&senderid=LukyMa&number=$ph_no&message=$mes_con");

       $list = array(
                "id" => $id,
                "name" => $name);
      echo json_encode(array("status" => "success", "data" => $list));
         }
         else {
           echo json_encode(array("status" => "notregistered"));
         }
}
if ($_POST['btn'] == "otp_verify") {
    $dtl = escape_string($link, $_POST);
    extract($dtl);

    $select = "SELECT `id`, `otp`, `contact` FROM `m_emp` WHERE `contact`= '$ph_no' and `otp` = '$otp' LIMIT 1";
        $master_user_result = mysqli_query($link, $select);

        if ($master_user_result && mysqli_num_rows($master_user_result) > 0) {
            $result_id = mysqli_fetch_assoc($master_user_result);
          $id = $result_id['id'];
         $update = "UPDATE `m_emp` SET `otp_status`='Yes' where `id` = '$id'";
    $result = mysqli_query($link,$update);

    echo json_encode(array("status" => "success"));
}
else {
   echo json_encode(array("status" => "notregistered"));
}
}


if($_POST['btn'] == 'change_pswd') {
    $dtl = escape_string($link, $_POST);
    extract($dtl);
    $update =  "UPDATE `m_emp` SET `pwd`='$password' WHERE `id` = $id";
    $result_about = mysqli_query($link,$update);

    if($result_about) {
        echo json_encode(array("status" => "success", "data" => "$id"));
    }
}

if ($_POST['btn'] == "resend_otp") {
    $dtl = escape_string($link, $_POST);
    extract($dtl);

    $randomNumber = mt_rand(1000, 9999);

     $update = "UPDATE `m_emp` SET `otp`= '$randomNumber' where `id` = '$id'";
    $result = mysqli_query($link,$update);

   $rand = "$randomNumber - $code";

    $mes_con = urlencode("Your password reset code is: $rand Use this code to reset your password. - ONSTRU");
    $otp_link = file_get_contents("http://promo.smso2.com/api/sendhttp.php?authkey=373776616e616e38313500&mobiles=$phno&message=$mes_con&sender=ONSTRU&route=2&country=0&DLT_TE_ID=1707172965888222588");

     echo json_encode(array("status" => "success"));

}
if ($_POST['btn'] == "attendance_in") {
    // $expense = escape_string($link, $_POST);
    // extract($_POST);

    extract($_POST);

    // error_log("🔹 POST Data: " . print_r($_POST, true));

    //    die(json_encode(array("data" => $_POST,"files"=>$_FILES)));

    // $empData = json_decode($_POST['id'], true);

     $link = mysqli_connect('dlr.cnkeaaeu6io4.ap-south-1.rds.amazonaws.com', 'admin', 'newpassword123', $database);


     $fileName = 'Nil';

   if (isset($_FILES['file_added'])) {
        $files = $_FILES['file_added'];


      $currentDateTime = date('Y-m-d_H-i-s');

           $fileName = $currentDateTime . '-' . $files['name'];
            $fileTmpName = $files['tmp_name'];
            $fileSize = $files['size'];
            $fileError = $files['error'];
            $fileType = $files['type'];

            if ($fileError === 0) {

                  $keyName = 'docs/' . $fileName; // ✅ Save inside docs/ folder

                // move_uploaded_file($tem, $dir . $file_name1);

                    $result = $s3->putObject([
                    'Bucket'     => $bucketName,
                    'Key'        => $keyName,
                    'SourceFile' => $fileTmpName,
                        // 'ACL'        => 'public-read', // or 'private'
                    ]);

           
            } else {
                echo json_encode(array("data" => "failed", "message" => "File upload error."));
                exit;
            }

    }

    $loc_in = $latitude.",".$longitude;
    $platform = 'Android';
    $c_by = '1';
    $work_in = 'NULL';

    $dateOnly = date('Y-m-d', strtotime($c_on));
    

    try{
    // if (json_last_error() === JSON_ERROR_NONE && is_array($empData)) {
      foreach ($empData as $employee) {
            $update_po = "UPDATE `m_attend`
                        SET `shift_out` = '$shift_in',
                            `cap_out` = '$c_on',
                            `loc_out` = '$loc_in',
                            `work_out` = '$work_in',
                            `remark_out` = '$fileName',
                            `c_by` = '$c_by',
                            `platform` = '$platform' ,
                            `status` = 'Inactive'
                        WHERE `emp_id` = '$employee' AND DATE(`c_on`)='$dateOnly'";

            $qry_po = mysqli_query($link, $update_po);

            // error_log("❌ SQL Error: " . mysqli_error($link));
            // error_log("❌ Failed Query: $update_po");
        }
    }catch(Exception $e){
         error_log("⚠️ Exception: " . $e->getMessage());
    }

    $_SESSION['photo_updated'] = true;   // SET SESSION HERE

        // Check if the query was successful
            if ($qry_po) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
            } else {
                 header("Location: " . $_SERVER['HTTP_REFERER']);
            }
    // }
}

 if ($_POST['btn'] == "edit_project") {
    $add_pro = escape_string($link, $_POST);

    extract($add_pro);


   $up_pro = "UPDATE `m_pro` SET `title`='$title',`branch`='$branch',`b_type`='$b_type',`budget`='$budget',`des`='$des',

                `loc`='$loc',`st_date`='$st_date',`end_date`='$end_date', `radius` = '$radius' WHERE `id`='$id' ";

    $q_pro = mysqli_query($link,$up_pro);

     if ($q_pro) {
        echo json_encode(array("status" => 'success'));
    } else {
        echo json_encode(array("status" => 'failed'));
    }
 }

 if($_POST['btn']=='face_check'){
   
    // print_r($_POST);
    extract($_POST);


    // $link = mysqli_connect('dlr.cnkeaaeu6io4.ap-south-1.rds.amazonaws.com', 'admin', 'newpassword123', $db_base);

    try {
        $descriptor = $_POST['descriptor'] ? json_decode($_POST['descriptor'], true) : null;
        // $imageBase64 = $request->input('face_image');

        if (!$descriptor || !is_array($descriptor)) {
                echo json_encode(array("status" => "error", "message" => "Invalid face descriptor provided"));
            exit;
        
        }

        $select_pro = "SELECT * FROM `m_lab` WHERE `pro_id` = '$pro_id'";
        $query_pro = mysqli_query($link, $select_pro);

        if (!$query_pro) {
            die("Query failed: " . mysqli_error($link));
        }

        $result = [];
        while ($face = mysqli_fetch_assoc($query_pro)) {
            // $face['emp_pro'] = $face['id'];
            $result[] = $face['id']; // store only emp_pro IDs
        }

         $emp_ids = implode("','", $result); // join all ids with commas


         $allFaces = "SELECT * FROM `user_face` where `status` = 'active' AND `user_id` IN ('$emp_ids')";

        //  $allFaces = "SELECT * FROM `user_face` where `status` = 'active'";
        // print_r($db);

        $matchedUser = null;
        $minDistance = 1.0;
        // reduce the threshold get the highest accuracy but may not match some faces
        $threshold = 0.45;
        
        $result = mysqli_query($link, $allFaces);
        while ($face = mysqli_fetch_assoc($result)) {
            $storedDescriptor = json_decode($face['encode'], true);

            if (is_array($storedDescriptor) && count($storedDescriptor) === count($descriptor)) {
                $distance = calculateEuclideanDistance($descriptor, $storedDescriptor);

                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $matchedUser = $face;
                }
            }
        }

        if ($matchedUser && $minDistance < $threshold) {
            // $emp = Employee::find($matchedUser['user_id']);
            $emp = $matchedUser['user_id'];
            
            $file = $matchedUser['file'];

            $emp_code = "SELECT * FROM `m_lab` where `id`='$emp'";
            $query_code = mysqli_query($link,$emp_code);
            $data_code = mysqli_fetch_assoc($query_code);


            $co = $data_code['con_id'];

            $s_con = "select * from `m_con` where `id`='$co'";
            $q_con = mysqli_query($link, $s_con);
            $cont_det = mysqli_fetch_assoc($q_con);

            // $cont_det = con_name();

            $today_date = date('Y-m-d', strtotime($c_on));

            $select_check = "SELECT * FROM `m_attend` WHERE `emp_id`= '$emp' and DATE(`c_on`) = '$today_date' LIMIT 1";
            $master_user_result = mysqli_query($link,$select_check);
            $num_check = mysqli_num_rows($master_user_result);

            // error_log($today_date);

            // if()

            if($type=='In'){
                $status = $num_check == 0 ? true : false;
                $message = $status ? "Attendance needs to be In" : "Attendance Available";
            }else{

                $fetch_result = mysqli_fetch_assoc($master_user_result);
                $shift_out = $fetch_result['shift_out'] ?? NULL;
                if($shift_out==Null){
                    // $num_check = 0;
                     $status = $num_check > 0 ? true : false;
                     $message = $status ? "Attendance needs to be Out" : "Attendance Not Registered";
                }else{
                    // $num_check = 2;
                    $status = false;
                    $message = "Attendance Already Out";
                }
               
            }

            // if($num_check > 0){

            //     $status = 'Not In';
            // }else{
            //     $status = 'In';
            // }

            echo  json_encode(array("status" => "success", "emp_id"=>$emp,"emp_code" => $data_code['lab_id'],"emp_name"=>$data_code['lab_name'],"cont_name"=>$cont_det['name'], "file" => $file,'status'=>$status,'message'=>$message));
            exit;
            
            // if (!$emp) {
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Employee not found for matched face',
            //     ], 404);
            // }

            // Process attendance
            // $attendanceResult = $this->processAttendance($emp);

            // return response()->json([
            //     'status' => 'success',
            //     'emp_code' => $emp,
            //     // 'emp_name' => $emp->name,
            //     // 'distance' => round($minDistance, 4),
            //     // 'message' => $attendanceResult['message'],
            //     // 'attendance_action' => $attendanceResult['action']
            // ]);
        }else{

            echo json_encode(array(
            "status" => "no_match",
            "distance" => round($minDistance, 4),
            "message" => "Face not recognized - Attendance failed to mark"
        ));
        }

        

        // return response()->json([
        //     'status' => 'no_match',
        //     'distance' => round($minDistance, 4),
        //     'message' => 'Face not recognized - Attendance failed to mark',
        // ]);

    } catch (\Exception $e) {

        echo json_encode(array(
            "status" => "error",
            "message" => "Server error occurred",
            "error" => $e->getMessage()
        ));
        // return response()->json([
        //     'status' => 'error',
        //     'message' => 'Server error occurred',
        //     'error' => $e->getMessage()
        // ], 500);
    }

 }

if($_POST['btn']=='save_face_data'){

    
    // print_r($_POST);
    extract($_POST);
    // print_r($_FILES);

      $link = mysqli_connect('dlr.cnkeaaeu6io4.ap-south-1.rds.amazonaws.com', 'admin', 'newpassword123', $db_base);

    if (isset($_FILES['file_added'])) {
        $files = $_FILES['file_added'];


      $currentDateTime = date('Y-m-d_H-i-s');

           $fileName = $currentDateTime . '-' . $files['name'];
            $fileTmpName = $files['tmp_name'];
            $fileSize = $files['size'];
            $fileError = $files['error'];
            $fileType = $files['type'];

            if ($fileError === 0) {

                  $keyName = 'docs/' . $fileName; // ✅ Save inside docs/ folder

                // move_uploaded_file($tem, $dir . $file_name1);

                    $result = $s3->putObject([
                    'Bucket'     => $bucketName,
                    'Key'        => $keyName,
                    'SourceFile' => $fileTmpName,
                        // 'ACL'        => 'public-read', // or 'private'
                    ]);

            //     $uploadDir = "../web/docs/";
            //     $destPath1 = $uploadDir . basename($fileName);
            //      if (!move_uploaded_file($fileTmpName, $destPath1)) {
            // echo json_encode(array("data" => "failed", "message" => "File could not be moved."));
            // exit;
        // }

            } else {
                echo json_encode(array("data" => "failed", "message" => "File upload error."));
                exit;
            }

    }

    $check_user = "SELECT * FROM `user_face` where `user_id` = '$emp_id' and `status` = 'active' ";
    $q_check = mysqli_query($link,$check_user);
    $num_check = mysqli_num_rows($q_check);
    if($num_check > 0){
        $update_face = "UPDATE `user_face` SET `file`='$fileName',`encode`='$face_descriptor',`updated_at`='$c_on' WHERE `user_id`='$emp_id' and `status` = 'active' ";
        $query = mysqli_query($link,$update_face);

        $update_file = "UPDATE `m_file` SET `file`='$fileName' where `f_id`='$emp_id' and `cat`='image'";
        $query_file = mysqli_query($link,$update_file);

        if($query){
             $_SESSION['photo_updated'] = true;   // SET SESSION HERE
           header("Location: ./camera_web.php?emp_id=".$emp_id);
            exit; // ✅ Always call exit after a redirect
        }else{
            header("Location: ./camera_web.php?emp_id=".$emp_id);
            exit; // ✅ Always call exit after a redirect
        }
        exit;
    }

    $store_face = "INSERT INTO `user_face`(`user_id`, `file`,`encode`, `status`,`c_by`, `created_at`,`updated_at`) VALUES ('$emp_id','$fileName','$face_descriptor','active','$c_by','$c_on','$c_on')";
    $query = mysqli_query($link,$store_face);


    $ins_file = "INSERT INTO `m_file`( `f_id`, `cat`, `file`, `status`, `c_by`)
        VALUES ('$emp_id','image','$fileName','$status','$dlr_emp')";
        $q_file = mysqli_query($link, $ins_file);

        // session_start();
        // $_SESSION['photo_updated'] = true;
        // setcookie("photo_updated", "1", time() + 5); // expires in 5 seconds

        // print_r($_COOKIE['photo_updated']);
        // die;

    if($query){
        $_SESSION['photo_updated'] = true;   // SET SESSION HERE
       header('Location: ./camera_web.php?emp_id='.$emp_id);
            exit; // ✅ Always call exit after a redirect
    }else{
        header("Location: ./camera_web.php?emp_id=".$emp_id);
            exit; // ✅ Always call exit after a redirect
    }

}


// if($_POST['btn']=='save_face_data'){

// }










    // if ($_POST['btn'] == "edit_labour") {
    //   $labour = escape_string($link, $_POST);

    //     extract($labour);
    //     $file_names = array();

    //     // print_r($_FILES['file_added']);



    //     if (isset($_FILES['file_added'])) {
    //         $files = $_FILES['file_added'];

    //         // echo "hello";


    //       $currentDateTime = date('Y-m-d_H-i-s');
    //     //    print_r(count($files['name']);
    //         for ($i = 0; $i < count($files['name']); $i++) {

    //            $file_name = $currentDateTime . '-' . $files['name'][$i];
    //             $fileTmpName = $files['tmp_name'][$i];
    //             $fileSize = $files['size'][$i];
    //             $fileError = $files['error'][$i];
    //             $fileType = $files['type'][$i];

    //             if ($fileError === 0) {

    //                   $keyName = 'docs/' . $file_name; // ✅ Save inside docs/ folder

    //                 // try {
    //                     $result = $s3->putObject([
    //                         'Bucket'     => $bucketName,
    //                         'Key'        => $keyName,
    //                         'SourceFile' => $fileTmpName,
    //                         // 'ACL'     => 'public-read' // Optional: make the file public
    //                     ]);

    //                 //     echo "✅ File uploaded successfully.\n";
    //                 //     echo "📎 File URL: " . $result['ObjectURL'] . "\n";

    //                 // } catch (S3Exception $e) {
    //                 //     // AWS SDK-specific exception
    //                 //     echo "❌ AWS S3 Upload Error: " . $e->getMessage() . "\n";
    //                 // } catch (Exception $e) {
    //                 //     // General PHP exception (e.g. file not found)
    //                 //     echo "❌ General Error: " . $e->getMessage() . "\n";
    //                 // }

    //                 // $uploadDir = "../web/docs/";
    //                 // $destPath1 = $uploadDir . basename($file_name);

    //                 // if (move_uploaded_file($fileTmpName, $destPath1)) {
    //                     $file_names[] = $file_name;


    //                       $ins_file = "UPDATE `m_file` SET `file`='$file_name'  WHERE `f_id`='$id' and `cat` = 'image'";


    //                         $q_file = mysqli_query($link, $ins_file);
    //                 // } else {
    //                 //     echo json_encode(array("status" => "Failure", "message" => "Failed to move uploaded file."));
    //                 //     exit;
    //                 // }
    //             } else {
    //                 echo json_encode(array("status" => "Failure", "message" => "File upload error.","data"=>$_FILES),201);
    //                 exit;
    //             }
    //         }
    //     }


    //     if ($q_file) {
    //         echo json_encode(array("status" => 'success'));
    //     } else {
    //         echo json_encode(array("status" => 'failed', "message" => "Failed to insert file record: " . mysqli_error($link)));
    //     }
    // }

// if ($_POST['btn'] == "edit_labour") {
//   $labour = escape_string($link, $_POST);

//     extract($labour);
//     $file_names = array();

//      $up_date = "UPDATE `m_lab` SET `pro_id`='$pro_id',`con_id`='$con_id',`lab_name`='$lab_name',`lab_con`='$lab_con',`desgination`='$desgination',`med_no`='$med_no',`saf_no`='$saf_no',`nmr`='$nmr',`unit`='$unit',`induction_ren`='$induction_ren'

//                 ,`id_proof`='$id_proof',`remark`='$remark',`induction_date`='$induction_date',`doj`='$doj' WHERE `id`='$id'";

//     $q_update = mysqli_query($link,$up_date);


//     if (isset($_FILES['file_added']) && isset($_POST['category'])) {
//         $files = $_FILES['file_added'];
//           $categories = explode(',', $_POST['category']);

//       $currentDateTime = date('Y-m-d_H-i-s');
//         for ($i = 0; $i < count($files['name']); $i++) {
//           $file_name = $currentDateTime . '-' . $files['name'][$i];
//             $fileTmpName = $files['tmp_name'][$i];
//             $fileSize = $files['size'][$i];
//             $fileError = $files['error'][$i];
//             $fileType = $files['type'][$i];

//             if ($fileError === UPLOAD_ERR_OK) {
//                 $uploadDir = "../web/docs/";
//                 $destPath1 = $uploadDir . basename($file_name);

//                 if (move_uploaded_file($fileTmpName, $destPath1)) {
//                     $file_names[] = $file_name;

//                       $cat = isset($categories[$i]) ? $categories[$i] : null;
//                       $ins_file = "UPDATE `m_file` SET `file`='$file_name'  WHERE `f_id`='$id' and `cat` = '$cat'";


//                     $q_file = mysqli_query($link, $ins_file);
//                 } else {
//                     echo json_encode(array("status" => "Failure", "message" => "Failed to move uploaded file."));
//                     exit;
//                 }
//             } else {
//                 echo json_encode(array("status" => "Failure", "message" => "File upload error."));
//                 exit;
//             }
//         }
//     }


//     if ($q_update != null) {
//         echo json_encode(array("status" => 'success'));
//     } else {
//         echo json_encode(array("status" => 'failed', "message" => "Failed to insert file record: " . mysqli_error($link)));
//     }
// }
?>
