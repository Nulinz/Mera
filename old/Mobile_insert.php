<?php
include("App_server.php");
// error_log(print_r($_SERVER, true)); // check
header("Access-Control-Allow-Origin: *");

date_default_timezone_set('Asia/Kolkata');
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
  if ($_POST['btn'] == "attendance_in") {
    // $att = escape_string($link, $_POST);
    extract($_POST);

    // error_log("🔹 POST Data: " . print_r($_POST, true));
    // $empData = json_decode($_POST['empData'], true);

    // die(json_encode(array("data" => $_POST,"files"=>$_FILES)));

    // if (json_last_error() !== JSON_ERROR_NONE || empty($empData)) {
    //     echo json_encode(array("data" => 'failed', "error" => 'No employee IDs found.'));
    //     return;
    // }

    // database

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

                    $result = $s3->putObject([
                    'Bucket'     => $bucketName,
                    'Key'        => $keyName,
                    'SourceFile' => $fileTmpName,
                        // 'ACL'        => 'public-read', // or 'private'
                    ]);



            }
            else {
                echo json_encode(array("data" => "failed", "message" => "File upload error."));
                exit;
            }

            

    }
    // else {
    //     echo json_encode(array("data" => "failed", "message" => "No file is send Isset failed"));
    //     exit;
    // }
    $allActive = true;
    $inserted = false;

    $loc_in = $latitude.",".$longitude;
    $platform = 'Android';

    foreach ($empData as $emp) {

        $work_in = null;
        $fileName = null;

        // if (!isset($emp['status']) || $emp['status'] !== 'Active') {
            $allActive = false;

            $ins_po = "INSERT INTO `m_attend`(`emp_id`,`pro_id`, `shift_in`, `cap_in`, `loc_in`, `work_in`, `remark_in`, `c_by`, `c_on`, `platform`, `status`)
                                         VALUES ('$emp', '$pro_id','$shift_in', '$c_on', '$loc_in', '$work_in', '$fileName', '$c_by', '$c_on','$platform', 'Active')";
            $qry_po = mysqli_query($link, $ins_po);

            if ($qry_po) {
                $inserted = true;
            }
        // }
    }
      $_SESSION['photo_updated'] = true;   // SET SESSION HERE

      ?>
      <!-- <script>
        alert('uploaded')
      <script> -->

      <?php

    if($qry_po){
      if (!empty($_SERVER['HTTP_REFERER'])) {
       
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
       
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
            exit; // ✅ Always call exit after a redirect
    }
    else{
       
       header("Location: " . $_SERVER['HTTP_REFERER']);
            exit; // ✅ Always call exit after a redirect
    }

    // if ($allActive) {
    //     echo json_encode(array("data" => 'success', "message" => "All employees are already active. No records were inserted."));
    // } elseif ($inserted) {
    //     http_response_code(200);
    //     echo json_encode(array("data" => 'success', "message" => "Records inserted successfully."));
    // } else {
    //     echo json_encode(array("data" => 'failed', "message" => "No records were inserted."));
    // }
}

 if ($_POST['btn'] == "create_project") {
    $add_pro = escape_string($link, $_POST);

    extract($add_pro);


    $ins_pro = "INSERT INTO `m_pro`( `title`, `branch`, `b_type`, `budget`, `des`, `loc`, `radius`,`st_date`, `end_date`, `status`, `c_by`)

                             VALUES ('$title','$branch','$b_type','$budget','$des','$loc','$radius','$st_date','$end_date','$status','$c_by')";

    $q_pro = mysqli_query($link,$ins_pro);

     if ($q_pro) {
        echo json_encode(array("status" => 'success'));
    } else {
        echo json_encode(array("status" => 'failed'));
    }
 }

if ($_POST['btn'] == "create_labour") {
  $labour = escape_string($link, $_POST);

    extract($labour);
    $file_names = array();

    $ins_lab = "INSERT INTO `m_lab`( `pro_id`, `con_id`, `lab_name`, `lab_con`, `desgination`, `med_no`, `saf_no`, `nmr`, `unit`, `induction_ren`, `id_proof`, `remark`, `induction_date`, `doj`, `status`, `c_by`)

          VALUES ('$pro_id','$con_id','$lab_name','$lab_con','$desgination','$med_no','$saf_no','$nmr','$unit','$induction_ren','$id_proof','$remark','$induction_date','$doj','$status','$c_by')";
    $q_lab = mysqli_query($link, $ins_lab);
    $last = mysqli_insert_id($link);

 $last1 = strval($db."-".$last);

    $up_labid = "UPDATE `m_lab` SET `lab_id`='$last1' where `id` ='$last'";
    $q_lab_id = mysqli_query($link,$up_labid);

    if (isset($_FILES['file_added']) && isset($_POST['category'])) {
        $files = $_FILES['file_added'];
           $categories = explode(',', $_POST['category']);

      $currentDateTime = date('Y-m-d_H-i-s');
        for ($i = 0; $i < count($files['name']); $i++) {
           $file_name = $currentDateTime . '-' . $files['name'][$i];
            $fileTmpName = $files['tmp_name'][$i];
            $fileSize = $files['size'][$i];
            $fileError = $files['error'][$i];
            $fileType = $files['type'][$i];

            if ($fileError === UPLOAD_ERR_OK) {
                // $uploadDir = "../web/docs/";
                // $destPath1 = $uploadDir . basename($file_name);

                 $sanitizedFileName = str_replace(' ', '_', $file_name); // Replace spaces with underscores (optional step for safety)
                 $file_name1 = date("d-m-Y_H_i_s")."_".$sanitizedFileName;

                  $keyName = 'docs/' . $file_name1; // ✅ Save inside docs/ folder

                // move_uploaded_file($tem, $dir . $file_name1);

                    $result = $s3->putObject([
                    'Bucket'     => $bucketName,
                    'Key'        => $keyName,
                    'SourceFile' => $fileTmpName,
                        // 'ACL'        => 'public-read', // or 'private'
                    ]);

                // if (move_uploaded_file($fileTmpName, $destPath1)) {
                    $file_names[] = $file_name1;

                      $cat = isset($categories[$i]) ? $categories[$i] : null;
                     $ins_file = "INSERT INTO `m_file`(`f_id`, `cat`, `file`, `status`, `c_by`)
                                 VALUES ('$last', '$cat', '$file_name1', '$status', '$c_by')";
                    $q_file = mysqli_query($link, $ins_file);
                // } else {
                //     echo json_encode(array("status" => "Failure", "message" => "Failed to move uploaded file."));
                //     exit;
                // }

            } else {
                echo json_encode(array("status" => "Failure", "message" => "File upload error."));
                exit;
            }

        }

        $image_file = "SELECT `file` from `m_file` where `cat` = 'image' and `f_id` = '$last' ";
                $result_file = mysqli_query($link, $image_file);
                $fetch_result = mysqli_fetch_assoc($result_file);
                $img = $fetch_result['file'];
    //              $imagePath = '../web/docs/' . $img;
    // $imageData = file_get_contents($imagePath);
    // $base64 = base64_encode($imageData);

      $sample_file1 = "SELECT `file` from `m_file` where `cat` = 'p_sample1' and `f_id` = '$last' ";
                $result_sample1 = mysqli_query($link, $sample_file1);
                $fetch_result1 = mysqli_fetch_assoc($result_sample1);
                $img1 = $fetch_result1['file'];
    //              $imagePath1 = '../web/docs/' . $img1;
    // $imageData1 = file_get_contents($imagePath1);
    // $sample1 = base64_encode($imageData1);

      $sample_file2 = "SELECT `file` from `m_file` where `cat` = 'p_sample2' and `f_id` = '$last' ";
                $result_sample2 = mysqli_query($link, $sample_file2);
                $fetch_result2 = mysqli_fetch_assoc($result_sample2);
                $img2 = $fetch_result2['file'];
    //              $imagePath2 = '../web/docs/' . $img2;
    // $imageData2 = file_get_contents($imagePath2);
    // $sample2 = base64_encode($imageData2);

    $data = array(
        "time" => "$c_on",
        "db_name" => "$db",
        "emp_id" => "$last1",
        "image_bytes" => "$img",
        "sample_1" => "$img1",
         "sample_2" => "$img2",
    );
     if ($q_lab_id != null) {
        echo json_encode(array("status" => 'success', "message" => $data));
    } else {
        echo json_encode(array("status" => 'failed', "message" => "Failed to insert file record: " . mysqli_error($link)));
    }
    }
}


if (isset($_POST['btn']) && $_POST['btn'] == "workdone_check") {

    extract($_POST);

    // print_r($_FILES);

     $fileName = 'NULL';

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

                    $result = $s3->putObject([
                    'Bucket'     => $bucketName,
                    'Key'        => $keyName,
                    'SourceFile' => $fileTmpName,
                        // 'ACL'        => 'public-read', // or 'private'
                    ]);



            }
            else {
                echo json_encode(array("data" => "failed", "message" => "File upload error."));
                exit;
            }

           

    }

    // $remarksValue = ($fileName === NULL) ? "NULL" : "'$fileName'";

     $remarksValue = mysqli_real_escape_string($link, $fileName);

        $ins_docs = "INSERT INTO `cont_docs`(`cont_id`,`pro_id`,`work_done`, `remarks`, `c_by`)
                                    VALUES ('$cont_id', '$pro_id','$work_done','$remarksValue', '$c_by')";
        $qry_docs = mysqli_query($link, $ins_docs);

        if($qry_docs){
              $_SESSION['photo_updated'] = true;   // SET SESSION HERE
            echo json_encode(array("data" => "success", "message" => "Remarks Updated Successfully"));
        }else{
            echo json_encode(array("data" => "false", "message" => "Remarks Update Failed"));
        }

}