<?php

include("App_server.php");
error_log(print_r($_SERVER, true)); 
header('Content-Type: application/json; charset=utf-8');

function pro_name($pr)
{
     include("App_server.php");
    $s_pro = "select * from `m_pro` where `id`='$pr'";
    $q_pro = mysqli_query($link, $s_pro);
    $d_pro = mysqli_fetch_assoc($q_pro);
    return $d_pro;
}
function con_name($co)
{
    include("App_server.php");
    $s_con = "select * from `m_con` where `id`='$co'";
    $q_con = mysqli_query($link, $s_con);
    $d_con = mysqli_fetch_assoc($q_con);
    return $d_con;
}
function des_name($id)
{
     include("App_server.php");
    $s_cat = "select * from `m_cat` where `id`='$id'";
    $q_cat = mysqli_query($link, $s_cat);
    $d_cat = mysqli_fetch_assoc($q_cat);
    return $d_cat;
}

function lab_name($id)
{
    include("App_server.php");
    $s_cat = "select * from `m_lab` where `id`='$id' ";
    $q_cat = mysqli_query($link, $s_cat);
    $d_cat = mysqli_fetch_assoc($q_cat);
    return $d_cat;
}

if ($_POST['btn'] == "edit_labour") {

    extract($_POST);

    // $id = $_POST['id'];
    // $file_name_original = $_POST['filename'];  // e.g., "test.pdf"
    // $base64_string = $_POST['file_added'];


    //  if (!$base64_string || !$file_name_original) {
    //     die(json_encode(["data" => "❌ Missing file or filename."]));
    // }

    // $currentDateTime = date('Y-m-d_H-i-s');
    // $file_name = $currentDateTime . '-' . $file_name_original;
    // $keyName = 'docs/' . $file_name;

    // // Remove base64 prefix if present
    // if (preg_match('/^data:\w+\/[\w-]+;base64,/', $base64_string)) {
    //     $base64_string = substr($base64_string, strpos($base64_string, ',') + 1);
    // }

    // $decoded = base64_decode($base64_string);
    // if ($decoded === false) {
    //     die(json_encode(["data" => "❌ Invalid base64 string."]));
    // }

    //     $uploadTempDir = __DIR__ . '/upload_temp';
    //     if (!is_dir($uploadTempDir)) {
    //         mkdir($uploadTempDir, 0755, true);
    //     }

    // // Save to temporary file
    // $tmp_file = tempnam($uploadTempDir, 'upload_');
    // file_put_contents($tmp_file, $decoded);

    // $tmp_file = tempnam(sys_get_temp_dir(), 'upload_');
    // file_put_contents($tmp_file, $decoded);


    // Upload to S3
    // try {
    //     $result = $s3->putObject([
    //         'Bucket'     => $bucketName,
    //         'Key'        => $keyName,
    //         'SourceFile' => $tmp_file,
    //     ]);
    //     // unlink($tmp_file); // Cleanup

    // } catch (Exception $e) {
    //     //  unlink($tmp_file);
    //     die(json_encode(["data" => "❌ Upload failed: " . $e->getMessage()]));
    // }

    //  die(json_encode(["data" => $_POST]));


    $file_names = array();
    $currentDateTime = date('Y-m-d_H-i-s');

    $img = $_FILES['file_added'];

    //   die(json_encode(["file" => $img]));

      $error = $img['error'];

    // if (isset($_FILES['file_added']) && $_FILES['file_added']['error'] == 0) {
    if (isset($_FILES['file_added']) && ($error == 0)) {

        $files = $_FILES['file_added'];
        $fileName = $files['name'];
        $file_name = $currentDateTime . '-' . $fileName;
        $fileTmpName = $files['tmp_name'];
        $keyName = 'docs/' . $file_name;

        try {
            $result = $s3->putObject([
                'Bucket'     => $bucketName,
                'Key'        => $keyName,
                'SourceFile' => $fileTmpName,
                // 'ACL'     => 'public-read'
            ]);

            // Optional: Log or echo the result
            // echo "✅ File uploaded: " . $result['ObjectURL'];

        } catch (S3Exception $e) {
            // error_log("S3 Upload failed: " . $e->getMessage());
            die(json_encode(["error" => "❌ S3 Error: " . $e->getMessage()]));
        } catch (Exception $e) {
            die(json_encode(["error" => "❌ General Error: " . $e->getMessage()]));
        }

    } else {
        http_response_code(400);
        echo json_encode(["status" => "Failure", "message" => "Uploaded file not found on server.","data"=>$_FILES['file_added']]);
         die();
    }

    // MySQL: check then insert/update
    $check_query = "SELECT * FROM `m_file` WHERE `f_id`='$id' AND `cat`='image'";
    $result = mysqli_query($link, $check_query);

    if (!$result) {
        die(json_encode(["error" => "❌ DB check query failed: " . mysqli_error($link)]));
    }

    if (mysqli_num_rows($result) > 0) {
        $update_query = "UPDATE `m_file` SET `file`='$file_name' WHERE `f_id`='$id' AND `cat`='image'";
        $q_file = mysqli_query($link, $update_query);
        if (!$q_file) {
            die(json_encode(["error" => "❌ DB update failed: " . mysqli_error($link)]));
        }
        echo json_encode(["data" => true, "status" => "updated"]);
    } else {
        $insert_query = "INSERT INTO `m_file` (`f_id`, `cat`, `file`, `status`) VALUES ('$id', 'image', '$file_name', 'Active')";
        $q_file = mysqli_query($link, $insert_query);
        if (!$q_file) {
            die(json_encode(["error" => "❌ DB insert failed: " . mysqli_error($link)]));
        }
        echo json_encode(["data" => true, "status" => "inserted"]);
    }
}

// if ($_POST['btn'] == "edit_labour") {

//     extract($_POST);
//     $file_names = array();
//    $currentDateTime = date('Y-m-d_H-i-s');
//     if (isset($_FILES['file_added'])) {
//         $files = $_FILES['file_added'];
//         $fileName = $files['name'];
//          $file_name = $currentDateTime . '-' . $files['name'];
//         $fileTmpName = $files['tmp_name'];

//           $keyName = 'docs/' . $file_name; // ✅ Save inside docs/ folder

//                 // move_uploaded_file($tem, $dir . $file_name1);

//                     $result = $s3->putObject([
//                     'Bucket'     => $bucketName,
//                     'Key'        => $keyName,
//                     'SourceFile' => $fileTmpName,
//                         // 'ACL'        => 'public-read', // or 'private'
//                     ]);
//         // $uploadDir =  "../web/docs/";
//         // $destPath1 = $uploadDir . $file_name;
//         // move_uploaded_file($fileTmpName, $destPath1);
//     }

//                      $check_query = "SELECT * FROM `m_file` WHERE `f_id`='$id' AND `cat`='image'";
//                     $result = mysqli_query($link, $check_query);

//                     if (mysqli_num_rows($result) > 0) {  // If the record exists, update it
//                         $update_query = "UPDATE `m_file` SET `file`='$file_name' WHERE `f_id`='$id' AND `cat`='image'";
//                         $q_file = mysqli_query($link, $update_query);
//                         echo json_encode(array("data" => true));
//                     } else {

//                         $insert_query = "INSERT INTO `m_file` (`f_id`, `cat`, `file`, `status`) VALUES ('$id', 'image', '$file_name', 'Active')";
//                         $q_file = mysqli_query($link, $insert_query);
//                         echo json_encode(array("data" => true));
//                     }


//         }

if ($_POST['btn'] == 'permissions') {
    extract($_POST);
    $view = [];

    $s_per = "SELECT * FROM `m_permission` WHERE `emp`='$id'";
    $q_perm = mysqli_query($link, $s_per);

    while ($row = mysqli_fetch_assoc($q_perm)) {
        $view[] = $row;
    }

    $result = [];
    foreach ($view as $entry) {
        $key = $entry['module'] . '_' . $entry['type'];
        $is_active = $entry['status'] === 'Active' ? true : false;

        $result[] = [
            "module" => $key,
            "is_active" => $is_active
        ];
    }
    echo json_encode(array("data" => $result));
}

if ($_POST['btn'] == 'attend_details') {
    extract($_POST);
 $fileName = 'Nil';

    if (isset($_FILES['file_added'])) {
        $files = $_FILES['file_added'];
        $fileName = $files['name'];
        $fileTmpName = $files['tmp_name'];

        $sanitizedFileName = str_replace(' ', '_', $fileName); // Replace spaces with underscores (optional step for safety)
        $file_name1 = date("d-m-Y_H_i_s")."_".$sanitizedFileName;

        $keyName = 'uploads/' . $file_name1; // ✅ Save inside docs/ folder

    // move_uploaded_file($tem, $dir . $file_name1);

        $result = $s3->putObject([
        'Bucket'     => $bucketName,
        'Key'        => $keyName,
        'SourceFile' => $fileTmpName,
            // 'ACL'        => 'public-read', // or 'private'
        ]);

        // $uploadDir = "uploads/";
        // $destPath1 = $uploadDir . $fileName;
        // move_uploaded_file($fileTmpName, $destPath1);
    }
    else {
        echo json_encode(array("data" => "failed", "message" => "No file is send Isset failed"));
        exit;
    }

    $emp_ids = str_replace(array('[', ']'), '', $emp_ids); // Remove brackets
    $emp_ids_array = explode(',', $emp_ids);

    $valid_emp_ids = array_filter($emp_ids_array, function($id) {
        $id = trim($id); // Trim any surrounding whitespace
        return !is_null($id) && $id !== 'Unknown';
    });

    //  die(json_encode(array("data" => $_POST,"files"=>$_FILES)));

    // Ensure valid_emp_ids is properly formatted for SQL
    if (!empty($valid_emp_ids)) {
        $valid_emp_ids = "'" . implode("','", array_map('trim', $valid_emp_ids)) . "'"; // Prepare for SQL IN clause

        $query = "SELECT `id`, `lab_name`, `lab_id` FROM m_lab WHERE `lab_id` IN ($valid_emp_ids)";
        $result = mysqli_query($link, $query);

        if (!$result) {
            echo json_encode(array("success" => false, "message" => "Query failed: " . mysqli_error($link)));
            return;
        }

        $view = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                if (in_array($row['lab_id'], explode(',', str_replace("'", '', $valid_emp_ids)))) {
                    $emp_id = $row['id'];

                    // Fetch image details
                    $imageQuery = "SELECT `file` FROM `m_file` WHERE `cat` = 'image' AND `f_id` = $emp_id AND `status` = 'Active'";
                    $result_image = mysqli_query($link, $imageQuery);
                    $images = mysqli_fetch_assoc($result_image);

                    $today = date("Y-m-d");
                    // Fetch attendance status
                    $statusQuery = "SELECT `status`, `id` FROM `m_attend` WHERE `emp_id` = $emp_id and DATE(`cap_in`)='$today'  ORDER BY `id` DESC";
                    $result_status = mysqli_query($link, $statusQuery);
                    $status_con = mysqli_fetch_assoc($result_status);

                    $shift = $status_con['status'] ?? 'no_status';



                    if($attendtype=='attend_in'){

                        if($shift == 'Active'){

                            $row_data = 'skip';

                        }else{
                             $row_data = 'add';
                        }


                    }else{

                        if($shift == 'Active'){

                            $row_data = 'add';

                        }else{
                             $row_data = 'skip';
                        }

                    }

                    // Build the result array
                    $row['status'] = $status_con['status'] ?? 'no_status';
                    $row['log_status'] = $row_data;
                    $row['attend_id'] = $status_con['id'] ?? 'no_id';
                    $row['logo'] = $images['file'] ?? 'No_logo.jpg';



                    $view[] = $row;
                }
            }
        }

        if (!empty($view)) {
            echo json_encode(array("success" => true, "data" => $view));
        } else {
            echo json_encode(array("success" => true, "data" => [], "message" => "No matching records found."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "No valid employee IDs provided."));
    }
}

if ($_POST['btn'] == 'aadhar_found') {
    extract($_POST);
    $master_user = "SELECT `id_proof` FROM `m_lab` WHERE `id_proof`= '$aadhar'  LIMIT 1";
        $master_user_result = mysqli_query($link, $master_user);

          if ($master_user_result && mysqli_num_rows($master_user_result) > 0) {
             echo json_encode(array("data" => 'found'));

}
else {
     echo json_encode(array("data" => 'notfound'));
}
  }

if ($_POST['btn'] == 'l_building') {
   extract($_POST);
        $data = [];
     $s_cat = "SELECT `title`, `id` from `m_cat` where `status`='Active' and `cat`='$cat'";
                                    $q_cat = mysqli_query($link,$s_cat);
                                    while($d_cat = mysqli_fetch_assoc($q_cat)){

        $data[] = $d_cat;
    }

    echo json_encode(array("data" => $data));
}

if ($_POST['btn'] == 'l_contractor') {
      $data = [];

     $s_cat = "SELECT `name`, `id` from `m_con` where `status`='Active' ";
                                    $q_cat = mysqli_query($link,$s_cat);
                                    while($d_cat = mysqli_fetch_assoc($q_cat)){

        $data[] = $d_cat;
    }

    echo json_encode(array("data" => $data));
}

if ($_POST['btn'] == 'l_labour') {
   extract($_POST);
      $s_lab = "SELECT * from `m_lab` where `status`= 'Active' and `pro_id` = '$id'  order by id desc";
      $q_lab = mysqli_query($link,$s_lab);

    $data = [];

    while($d_list = mysqli_fetch_assoc($q_lab)){

        $proid = pro_name($d_list['pro_id']);
        $conid = con_name($d_list['con_id']);
        $desgi = des_name($d_list['desgination']);
        $id = $d_list['id'];
        $d_list['pro_id'] = $proid['title'];
        $d_list['con_id'] = $conid['name'];
        $d_list['desgination'] = $desgi['title'];
        $dateTime = new DateTime($d_list['doj']);
        $d_list['doj'] = $dateTime->format('d-m-y');
        $imageQuery = "SELECT `file` FROM `m_file` WHERE `cat` = 'image' AND `f_id` = $id AND `status` = 'Active'";
        $result_image = mysqli_query($link, $imageQuery);
        $images = mysqli_fetch_assoc($result_image);
                        //  $d_list['image'] = $images['file'] ?? 'No_logo.jpg';

        $data[] = $d_list;
    }

    // print_r($data);

    echo json_encode(array("data" => $data));
}

if($_POST['btn'] == "labour_details"){
    extract($_POST);

    $projectQuery = "SELECT * from `m_lab` where `id` = '$id' ";
    $result_projects = mysqli_query($link, $projectQuery);
    $values = mysqli_fetch_assoc($result_projects);

    $id =  $values['id'];

    $conid = con_name($values['con_id']);
    $desgi = des_name($values['desgination']);
    $proid = pro_name($values['pro_id']);
    $values['pro_id'] = $proid['title'];
    $values['con_id'] = $conid['name'];
    $values['desgination'] = $desgi['title'];

    $imageQuery = "SELECT `file` FROM `m_file` WHERE `f_id` = $id  AND `cat` = 'bimage' AND `status` = 'Active' ";
    $result_image = mysqli_query($link, $imageQuery);
    $images = mysqli_fetch_assoc($result_image);
    $values['bimage'] = $images['file'] ?? 'No_logo.jpg';

    $fimage_q = "SELECT `file` FROM `m_file` WHERE `f_id` = $id AND `cat` = 'fimage' AND `status` = 'Active' ";
    $result_fimage = mysqli_query($link, $fimage_q);
    $fimage = mysqli_fetch_assoc($result_fimage);
    $values['fimage'] = $fimage['file'] ?? 'No_logo.jpg';

    $profile = "SELECT `file` FROM `m_file` WHERE `f_id` = $id AND `cat` = 'image' AND `status` = 'Active' ";
    $result_profile = mysqli_query($link, $profile);
    $image_pro = mysqli_fetch_assoc($result_profile);
    $values['image'] = $image_pro['file'] ?? 'No_logo.jpg';

    echo json_encode(array("data" => $values));

}

if($_POST['btn'] == "project_details"){
    extract($_POST);

    $projectQuery = "SELECT * FROM `m_pro` where `id` = '$id' ";
    $result_projects = mysqli_query($link, $projectQuery);
    $values = mysqli_fetch_assoc($result_projects);

    $id = $values['b_type'];
     $s_cat = "SELECT `title` from `m_cat` where `status`='Active' and `id`='$id '";
                                    $q_cat = mysqli_query($link,$s_cat);
     $result = mysqli_query($link, $s_cat);

        $values['b_type'] =  mysqli_fetch_assoc($result)['title'];

     echo json_encode(array("data" => $values));

}
if($_POST['btn'] == "project"){

    // echo "hello";

    extract($_POST);
    $data = [];
    if($_POST['cat'] == 'Admin') {
        $sql = "SELECT * FROM `m_pro` WHERE  `status` = 'Active' ORDER BY `id` DESC";
                $result = mysqli_query($link, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $project_id = $row['id'];
                        $imageQuery = "SELECT `file` FROM `m_file` WHERE `cat` = 'image' AND `f_id` = $project_id AND `status` = 'Active' ";
                        $result_image = mysqli_query($link, $imageQuery);
                        $images = mysqli_fetch_assoc($result_image);
                        $row['logo'] = $images['file'] ?? 'No_logo.jpg';
                        $dateTime = new DateTime($row['st_date']);
                        $row['st_date'] = $dateTime->format('d-m-y');

                        $data[] = $row;
                    }
                }
    }
    else {
        $projectQuery = "SELECT `pro_id` FROM `m_assign` WHERE `status` = 'Active' AND `emp` = $id order by id desc";
        $result_projects = mysqli_query($link, $projectQuery);

        if ($result_projects) {
            while ($values = mysqli_fetch_assoc($result_projects)) {
                $pro_id = $values['pro_id'];

                $sql = "SELECT * FROM `m_pro` WHERE  `id` = $pro_id AND `status` = 'Active' ORDER BY `id` DESC";
                $result = mysqli_query($link, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $project_id = $row['id'];
                        $imageQuery = "SELECT `file` FROM `m_file` WHERE `cat` = 'image' AND `f_id` = $project_id AND `status` = 'Active' ";
                        $result_image = mysqli_query($link, $imageQuery);
                        $images = mysqli_fetch_assoc($result_image);
                        $row['logo'] = $images['file'] ?? 'No_logo.jpg';
                        $dateTime = new DateTime($row['st_date']);
                        $row['st_date'] = $dateTime->format('d-m-y');

                        $data[] = $row;
                    }
                }

            }
        }
    }

    echo json_encode(array("data" => $data));
}


// project list
if($_POST['btn'] == 'project_list'){
    $projectQuery = "SELECT `id`, `title` from `m_pro` ";
    $result_projects = mysqli_query($link, $projectQuery);
    $values = array();
    while ($row = mysqli_fetch_assoc($result_projects)) {
        $values[] = $row;   // push each row into the array
    }
    echo json_encode(array("data" => $values ));
}

if ($_POST['btn'] == 'projectwise_labour_strength') {

    $project = $_POST['project'];
    $sdate   = $_POST['sdate'];
    $edate   = $_POST['edate'];

    $response = [];
    $i = 1;

    // $sql = "select *,count(emp_id)as count_emp from `m_attend` where `pro_id`='$project' and date(`cap_in`) between '$sdate' and '$edate' GROUP by date(cap_in),emp_id order by date(cap_in)";
    $sql = "
        SELECT *,
            COUNT(emp_id) AS count_emp
        FROM m_attend
        WHERE pro_id = '$project'
          AND DATE(cap_in) BETWEEN '$sdate' AND '$edate'
        GROUP BY DATE(cap_in), emp_id
        ORDER BY DATE(cap_in)
    ";

    $query = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_assoc($query)) {

        $emp_id = $row['emp_id'];
        $cap_in = $row['shift_in'];
        $cap_out = $row['shift_out'];
        $count_emp = $row['count_emp'];

        $lab_de = lab_name($emp_id);
        $con_id = $lab_de['con_id'];
        $trade_id = $lab_de['desgination'];

        $cat_sql = "SELECT * FROM m_cat WHERE id='$trade_id' AND cat='Trade' AND status='Active'";
        $cat_q   = mysqli_query($link, $cat_sql);
        $cat_row = mysqli_fetch_assoc($cat_q);

        $con_de = con_name($con_id);

        $response[] = [
            "sl_no"     => $i++,
            "date"      => date("d-m-Y", strtotime($row['cap_in'])),
            "contractor"=> $con_de['name'],
            "trade"     => $cat_row['title'],
            "count_emp" => $count_emp,
            "time_in"   => date("h:i a", strtotime($cap_in)),
            "time_out"  => $cap_out ? date("h:i a", strtotime($cap_out)) : null,
        ];
    }

    echo json_encode([
        "status" => "success",
        "data"   => $response
    ]);
}


if ($_POST['btn'] == "nmr_report") {

    extract($_POST);
    error_log(print_r($_POST,true));
    
    $project = $_POST['project'];
    $type    = $_POST['type'];
    $cont    = $_POST['cont'] ?? 0;
    $trade   = $_POST['trade'] ?? 0;
    $lab     = $_POST['labour'] ?? 0;
    $sdate   = $_POST['sdate'];
    $edate   = $_POST['edate'];
    // echo $cont;
    // echo $type;
    // echo 'here';
    $response = [];
    $i = 1;
    $total_amount = 0;

    if ($type == "Contractor") {

        $sql = "SELECT ma.*, ml.* 
                FROM m_attend ma 
                JOIN m_lab ml ON ma.emp_id = ml.id 
                WHERE ma.pro_id = '$project' 
                  AND ml.con_id = '$cont'
                  AND DATE(ma.cap_in) BETWEEN '$sdate' AND '$edate'
                -- GROUP BY ma.emp_id 
                ORDER BY DATE(ma.cap_in)";
    }

    elseif ($type == "Trader") {

        $sql = "SELECT ma.*, ml.* 
                FROM m_attend ma 
                JOIN m_lab ml ON ma.emp_id = ml.id 
                WHERE ma.pro_id = '$project' 
                  AND ml.desgination = '$trade'
                  AND DATE(ma.cap_in) BETWEEN '$sdate' AND '$edate'
                -- GROUP BY ma.emp_id 
                ORDER BY DATE(ma.cap_in)";
    }

    elseif ($type == "Labour") {

        $sql = "select *,count(emp_id)as count_emp from `m_attend` where `pro_id`='$project' and `emp_id`='$lab' and date(`cap_in`) between '$sdate' and '$edate' GROUP by date(cap_in),emp_id order by date(cap_in)";
        // $sql = "SELECT ma.*, ml.*, COUNT(emp_id) AS count_emp 
        //         FROM m_attend ma
        //         JOIN m_lab ml ON ma.emp_id = ml.id
        //         WHERE ma.pro_id = '$project'
        //           AND ma.emp_id = '$lab'
        //           AND DATE(cap_in) BETWEEN '$sdate' AND '$edate'
        //         GROUP BY DATE(cap_in), emp_id
        //         ORDER BY DATE(cap_in)";
    }

    elseif ($type == "Contractor-Trader") {

        $sql = "SELECT ma.*, ml.* 
                FROM m_attend ma
                JOIN m_lab ml ON ma.emp_id = ml.id
                WHERE ma.pro_id = '$project'
                  AND ml.con_id = '$cont'
                  AND ml.desgination = '$trade'
                  AND DATE(ma.cap_in) BETWEEN '$sdate' AND '$edate'
                -- GROUP BY ma.emp_id 
                ORDER BY DATE(ma.cap_in)";
    }

    else { // ALL

        $sql = "SELECT *, COUNT(emp_id) AS count_emp 
                FROM m_attend 
                WHERE pro_id = '$project'
                  AND DATE(cap_in) BETWEEN '$sdate' AND '$edate'
                GROUP BY DATE(cap_in), emp_id
                ORDER BY DATE(cap_in)";
    }

    // ---- RUN QUERY ----

    $query = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_assoc($query)) {

        $emp_id = $row['emp_id'];

        $lab = lab_name($emp_id);
        $con = con_name($lab['con_id']);
        $trade_cat = des_name($lab['desgination']);

        // Hours Calculation
        $t1 = new DateTime($row['shift_in']);
        if($row['cap_out'] && $row['shift_out']){
            $t2 = new DateTime($row['shift_out']);
            $hrs = $t1->diff($t2)->h;
        } else {
            $hrs = 0;
        }

        // Amount
        $unit = is_numeric($lab['unit']) ? $lab['unit'] : 0;
        if($row['cap_out']){
            $amt = $hrs * $unit;
            $total_amount += $amt;
        }

        $response[] = [
            "sl_no"      => $i++,
            "date"       => date("d-m-Y", strtotime($row['cap_in'])),
            "contractor" => $con['name'],
            "trade"      => $trade_cat['title'],
            "labour"     => $lab['lab_name'],
            "hrs"        => $row['cap_out'] ? "$hrs Hrs" : "",
            "cap_in"     => date("h:i a", strtotime($row['shift_in'])),
            "cap_out"    => $row['shift_out'] ? date("h:i a", strtotime($row['shift_out'])) : null,
            "work_done"  => $row['work_out'] ?? null,
            "remarks"    => 'https://onstru.s3.ap-south-1.amazonaws.com/docs/'.$row['remark_out'] ?? '',
            "unit_rate"  => $unit,
            "amount"     => $row['cap_out'] ? $amt : 0,
        ];
    }

    echo json_encode([
        "status"        => "success",
        "total_amount"  => $total_amount,
        "row_count"     => count($response),
        "data"          => $response
    ]);

}

if (isset($_POST['btn']) && $_POST['btn'] == "report_type_fetch") {

    $pro_id = $_POST['pro_id'];
    $con_id = isset($_POST['con_id']) ? $_POST['con_id'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';

    $response = [];

    // Handle multiple types
    $types = explode('-', $type); // e.g., "Contractor-Trader" -> ['Contractor','Trader']

    // Contractor options
    if (in_array('Contractor', $types) || in_array('All', $types) || $type === '') {
        $s_pro = "SELECT DISTINCT(con_id) AS con FROM `m_lab` WHERE `pro_id`='$pro_id'";
        $q_pro = mysqli_query($link,$s_pro);
        $contractors = [];
        while ($d_pro = mysqli_fetch_assoc($q_pro)) {
            $con_n = con_name($d_pro['con']);
            $contractors[] = [
                'id' => $d_pro['con'],
                'name' => $con_n['name']
            ];
        }
        $response['contractors'] = $contractors;
    }

    // Trader options
    if (in_array('Trader', $types) || in_array('All', $types) || $con_id) {
        $con_filter = $con_id ? " AND `con_id`='$con_id'" : '';
        $s_des = "SELECT DISTINCT(desgination) AS des FROM `m_lab` WHERE `pro_id`='$pro_id' $con_filter";
        $q_des = mysqli_query($link,$s_des);
        $traders = [];
        while ($d_des = mysqli_fetch_assoc($q_des)) {
            $s_cat = "SELECT * FROM `m_cat` WHERE `id`='{$d_des['des']}' AND `cat`='Trade' AND `status`='Active'";
            $q_cat = mysqli_query($link, $s_cat);
            $d_cat = mysqli_fetch_assoc($q_cat);
            if ($d_cat) {
                $traders[] = [
                    'id' => $d_des['des'],
                    'title' => $d_cat['title']
                ];
            }
        }
        if ($con_id) {
            $response['trade_opt'] = $traders;
        } else {
            $response['traders'] = $traders;
        }
    }

    // Labour options
    if (in_array('Labour', $types)) {
        $s_lab = "SELECT DISTINCT(id) AS lab_id, lab_name FROM `m_lab` WHERE `pro_id`='$pro_id'";
        $q_lab = mysqli_query($link, $s_lab);
        $labours = [];
        while ($d_lab = mysqli_fetch_assoc($q_lab)) {
            $labours[] = [
                'id' => $d_lab['lab_id'],
                'name' => $d_lab['lab_name']
            ];
        }
        $response['labours'] = $labours;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}




if (isset($_POST['btn']) && $_POST['btn'] == "workdone_contractor") {

    extract($_POST);

    $contractors = [];
    $cont = [];

    $cr = date("Y-m-d");

    $empty = '';

    $lab = [];

    $select_attd = "SELECT * FROM `m_attend` where DATE(`c_on`)='$cr' and `shift_out`='$empty'";
    $q_attd = mysqli_query($link, $select_attd);
    while($d_attd = mysqli_fetch_assoc($q_attd)){

        $lab[] = $d_attd['emp_id'];
    }

   

    // error_log(print_r($d_attd, true));


    if (empty($lab)) {
        $select_pro = "SELECT DISTINCT(`con_id`) FROM `m_lab` WHERE `pro_id`='$pro_id'";
    }else{
         $lab_list = implode(",", $lab);
    
        $select_pro = "SELECT DISTINCT(`con_id`) FROM `m_lab` WHERE `pro_id`='$pro_id' AND `id` IN ($lab_list)";
    }

    // Get all lab rows for project
   
    $q_pro = mysqli_query($link, $select_pro);

    while ($d_pro = mysqli_fetch_assoc($q_pro)) {

        //  error_log(print_r($d_pro, true));

        $data_cont = $d_pro['con_id'];
        $cont[] = $data_cont; // store all contractor IDs

        // check docs for today's date
        $select_docs = "SELECT * FROM `cont_docs`
                        WHERE `cont_id`='$data_cont'
                        AND DATE(`created_at`)='$cr'";
        $q_docs = mysqli_query($link, $select_docs);
        $d_docs = mysqli_num_rows($q_docs);

        if ($d_docs == 0) {

            // get contractor details
            $select_cont = "SELECT * FROM `m_con` WHERE `id`='$data_cont'";
            $q_cont = mysqli_query($link, $select_cont);
            $d_cont = mysqli_fetch_assoc($q_cont);

           $contractors[] = [
                "cont_id" => $d_cont['id'],
                "cont_name" => $d_cont['name']
            ];
        }
    }

   if (count($contractors) > 0) {
        echo json_encode([
            "data" => $contractors,
            "cont" => $cont,
            "message" => "contractors"
        ]);
    } else {
        echo json_encode([
            "data" => $contractors,
            "cont" => $cont,
            "message" => "No contractors"
        ]);
    }
}

if ($_POST['btn'] == "contractor_report") {

    extract($_POST);

    $contractors = [];

     

    $s_docs = "select * from `cont_docs` where `pro_id`='$pro_id'
            AND DATE(`created_at`) BETWEEN '$sdate' AND '$edate'
            ORDER BY `created_at` DESC";
  
    $q_docs = mysqli_query($link,$s_docs);
    $i=1;
    while($d_docs = mysqli_fetch_assoc($q_docs)){
    //    print_r($_POST);
        extract($d_docs);

        $con_de = con_name($cont_id);

        if($remarks!='NULL'){
                $a = $buck_link.$remarks;
        }else{
                $a = 'NULL';
        }

         $contractors[] = [
                "date" => date("d-m-Y",strtotime($created_at)),
                "cont_name" => $con_de['name'],
                "work_done"=>$work_done,
                "remarks"=>$a
                
            ];

    }

    if (count($contractors) > 0) {
        echo json_encode([
            "data" => $contractors,
            "message" => "contractors"
        ]);
    } 
    else {
        echo json_encode([
            "data" => $contractors,
            "message" => "No contractors"
        ]);
    }

}
