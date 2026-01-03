<?php
session_start();

if (!empty($_SESSION['photo_updated'])) {
    echo "<script>alert('Attendance Updated Successfully');</script>";
    unset($_SESSION['photo_updated']);  // show only once
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onstru | DLR</title>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Font / Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- Lightbox -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

    <!-- Stylesheet -->
     <link rel="stylesheet" href="{{ asset('asset/camera.css') }}">

    <!-- Face API -->
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

</head>
<style>
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99;
    }

    .popup-content {
        background: #fff;
        padding: 20px 30px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }
</style>

<body>

    <div class="main d-block">
        <div class="camera-div mb-3 cameraIcon" data-target="#in_img1">
            <!-- <i class="fas fa-camera camera-icon"></i> -->

            <!-- Preview Image -->
            <div class="preview-container" style="position: relative; display: inline-block;">
                <img class="imagePreview" src="" alt="Image Preview" style="display:none; width:100%;">
                <i class="fas fa-times removeImage" style="display:none;"></i>
            </div>

            <!-- Camera Function -->
            <div class="camerafnctn">
                <video class="video camera-video" id="video" autoplay></video>
                <input class="submitbtn capture" type="button" value="Capture">
                <canvas id="overlay" class="canvas"></canvas>
            </div>
        </div>

        <!-- Empty State -->
        <div class="attd-content my-3" id="notdetected">
            <div class="attd-div">
                <div class="col-sm-12 d-block text-center">
                    <h6 class="text-muted" id="matchStatus"></h6>
                </div>
            </div>
        </div>

        <input type="file" id="in_img1" name="image" style="display:none;">

        <?php
        $action = ($type == 'In') ? 'Mobile_insert.php' : 'Mobile_update.php';
        ?>
        <div class="attd-content" id="detected">
            <form id="faceForm" method="POST" action="<?php echo $action; ?>" enctype="multipart/form-data">
                <input type="hidden" name="latitude" id="" value="{{ $latitude ?? '' }}">
                <input type="hidden" name="longitude" id="" value="{{ $longitude ?? '' }}">
                <input type="hidden" name="database" id="" value="{{ $db_base ?? '' }}">
                <input type="hidden" name="c_by" id="" value="{{ $c_by ?? '' }}">
                <input type="hidden" name="pro_id" value="{{ $pro_id ?? '' }}">
                <input type="hidden" name="btn" value="attendance_in">
                <input type="hidden" name="type" value="{{ $type ?? '' }}">
                <div class="attd-main-div">
                    <div class="attd-div">
                        <div class="col-sm-12 mb-3">
                            <h6 class="text-muted">Latitude</h6>
                            <h6 class="text-dark">:</h6>
                            <h6 class="text-dark">{{ $latitude ?? '' }}</h6>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <h6 class="text-muted">Longitude</h6>
                            <h6 class="text-dark">:</h6>
                            <h6 class="text-dark">{{ $longitude ?? '' }}</h6>
                        </div>
                    </div>
                    <div class="attd-div">
                        <div class="col-sm-12 mb-3">
                            <h6 class="text-muted">In-Time</h6>
                            <h6 class="text-dark">:</h6>
                            <?php
                            date_default_timezone_set('Asia/Kolkata'); // set your timezone
                            
                            $currentTime = time(); // current timestamp
                            $startTime = $currentTime - (15 * 60); // 15 minutes before
                            $endTime = $currentTime + (15 * 60); // 15 minutes after
                            ?>
                            <select class="form-select" name="shift_in" id="">
                                <?php

                                for ($t = $startTime; $t <= $endTime; $t += 60) { // loop every 1 minute    
                                    $timeLabel = date("h:i A", $t); // or "h:i A" for 12-hour format
                                    $selected = ($t === $currentTime) ? 'selected' : '';

                                    ?>


                                    <option value="<?php echo $timeLabel; ?>" <?php echo $selected; ?>>
                                        <?php echo $timeLabel; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="body-head mb-3">
                    <h4>Labour List</h4>
                </div>
                <div class="listtable mb-3">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Employee Name</th>

                                </tr>
                            </thead>
                            <tbody id="faceTableBody">
                                <!-- <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="./images/afternoon.png" data-fancybox="product">
                                            <img src="./images/afternoon.png" alt="">
                                        </a>
                                    </td>
                                    <td>Sheik</td>
                                    <td>
                                        <select class="form-select" name="intime" id="intime">
                                            <option value="" selected disabled>Select Time</option>
                                            <option value=""></option>
                                        </select>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php
            if($type=='Out'){
            ?>

                <!-- <div class="attd-sub-div d-sm-block d-md-grid">
                    <div class="attd-div">
                        <div class="col-sm-12 mb-3">
                            <label class="text-muted">Work Done</label>
                            <h6 class="text-dark">:</h6>
                            <textarea class="form-control" name="work_in" id="" rows="1"></textarea>
                        </div>
                    </div>
                    <div class="attd-div">
                        <div class="col-sm-12 mb-3">
                            <label class="text-muted">Remarks</label>
                            <h6 class="text-dark">:</h6>
                            <input type="file" class="form-control" name="file_added" accept="image/*" id="">
                        </div>
                    </div>
                </div> -->
            <?php
            }
            ?>

                <div class="col-sm-12 d-flex align-items-center justify-content-center mt-3">
                    <button type="submit" class="submitbtn" id="attd_submit">Submit</button>
                </div>
            </form>
        </div>

        <!-- Popup Modal -->
        <div id="matchPopup" class="popup-overlay" style="display: none;">
            <div class="popup-content">
                <h3 class="mb-3">Face Match Found</h3>
                <a id="popup_img" href="" data-fancybox="face">
                    <img id="popup_img1" src="" alt="" class="mb-3">
                </a>
                <h6 id="popupEmpCode" class="mb-2"></h6>
                <h6 id="popupEmpname" class="mb-2"></h6>
                <h6 class="text-dark text-capitalize mb-3" id="attd_sts"></h6>
                <div class="popup-actions d-flex align-items-center justify-content-between gap-2">
                    <button id="addBtn" class="w-50">Add</button>
                    <button id="rejectBtn" class="w-50">Reject</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Lightbox -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

    <script>
        $('#faceForm').on('submit', function () {
            $('#attd_submit').prop('disabled', true).text('Submitting...');
        });
    </script>

    <script defer>

        var type = '<?php echo isset($_GET['type']) ? $_GET['type'] : ''; ?>';
        var lat = '<?php echo isset($_GET['latitude']) ? $_GET['latitude'] : ''; ?>';
        var long = '<?php echo isset($_GET['longitude']) ? $_GET['longitude'] : ''; ?>';
        var pro_id = '<?php echo isset($_GET['pro_id']) ? $_GET['pro_id'] : ''; ?>';
        var db_base = '<?php echo isset($_GET['db_base']) ? $_GET['db_base'] : ''; ?>';

        // ✅ Check for missing values
        // if (!type || !lat || !long || !pro_id || !db_base) {
        //     // alert("❌ Some required data is missing. Please check and try again.");
        //     // console.error({
        //     //     type, lat, long, pro_id, db_base
        //     // });
        //     // stop script execution
        //     // throw new Error("Missing required GET parameters.");

        //      // Redirect to your 404 page (adjust the path as needed)
        //     //  window.location.href = "/404.php"; // or "/404.html"
        // }

        let audioContext = null;

        function initAudioContext() {
            // alert("init called");
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }

            if (audioContext.state === "suspended") {
                audioContext.resume();
            }
        }

        function playAlertSound() {
            //  alert("alert success called");
                initAudioContext();

                // First beep
                const osc1 = audioContext.createOscillator();
                const gain1 = audioContext.createGain();
                osc1.connect(gain1);
                gain1.connect(audioContext.destination);

                osc1.type = "sine";
                osc1.frequency.setValueAtTime(700, audioContext.currentTime);
                gain1.gain.setValueAtTime(0.2, audioContext.currentTime);
                gain1.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.15);

                osc1.start(audioContext.currentTime);
                osc1.stop(audioContext.currentTime + 0.15);

                // Second beep (slightly higher)
                const osc2 = audioContext.createOscillator();
                const gain2 = audioContext.createGain();
                osc2.connect(gain2);
                gain2.connect(audioContext.destination);

                osc2.type = "sine";
                osc2.frequency.setValueAtTime(900, audioContext.currentTime + 0.2);
                gain2.gain.setValueAtTime(0.2, audioContext.currentTime + 0.2);
                gain2.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.35);

                osc2.start(audioContext.currentTime + 0.2);
                osc2.stop(audioContext.currentTime + 0.35);
            }


        function playErrorSound() {
            // alert("alert error called");
            initAudioContext();

            const osc = audioContext.createOscillator();
            const gain = audioContext.createGain();

            osc.connect(gain);
            gain.connect(audioContext.destination);

            osc.type = "square";  // harsh error tone
            osc.frequency.setValueAtTime(600, audioContext.currentTime);      // start high
            osc.frequency.linearRampToValueAtTime(200, audioContext.currentTime + 0.25); // drop

            gain.gain.setValueAtTime(0.3, audioContext.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.25);

            osc.start();
            osc.stop(audioContext.currentTime + 0.25);
        }




        // ✅ Check for missing or empty values
        if (!type || !lat || !long || !pro_id || !db_base) {
            alert("❌ Some required data is missing. Redirecting to 404 page...");
            // console.log(type, lar, long, pro_id, db_base)

            //  console.error({
            //          type, lat, long, pro_id, db_base
            //      });
            window.location.href = "/404.php"; // adjust path if needed
        }

        const video = document.getElementById('video');
        const overlay = document.getElementById('overlay');
        const ctx = overlay.getContext('2d');
        const statusEl = document.getElementById('matchStatus');
        // const scanBtn = document.getElementsByClassName('capture');

        const scanBtn = document.querySelector(".submitbtn.capture");
        const faceForm = document.getElementById("empForm");

        // --- popup references ---
        const popup = document.getElementById("matchPopup");
        const popupEmpCode = document.getElementById("popupEmpCode");
        const popupEmpname = document.getElementById("popupEmpname");
        const popup_img = document.getElementById("popup_img");
        const popup_img1 = document.getElementById("popup_img1");
        const addBtn = document.getElementById("addBtn");
        const rejectBtn = document.getElementById("rejectBtn");

        // camera stop
        let stream = null; // store camera stream globally
        let groups = [];
        let lastX = null;
        let blinked = false;
        let headMoved = false;
        let lastLeft = 0;
        let modelsLoaded = false; // track model load
        let livePassed = false;
        let result = null;
        let detectLoop = null;

        // --- START VIDEO ---
        async function startVideo() {
            // let stream;
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: {
                            exact: "environment"
                        }
                    }
                });
            } catch {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
            }
            video.srcObject = stream;
            console.log("📷 Camera started");
            monitorFace();
            // Wait until video metadata (size) is ready
            video.addEventListener('loadedmetadata', () => {
                overlay.width = video.videoWidth;
                overlay.height = video.videoHeight;
                drawBox();
            });
        }

        function stopVideo() {
            if (stream) {
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
                stream = null;
                console.log("🛑 Camera stopped");
            }
        }

        // drawing the lines around the video
        function drawBox() {
            const { width, height } = overlay;
            ctx.clearRect(0, 0, width, height);
            // Define square dimensions
            const boxSize = Math.min(width, height) * 0.8; // 80% of smallest side
            const x = (width - boxSize) / 2;
            const y = (height - boxSize) / 2;
            // Draw a visible rectangle
            ctx.lineWidth = 4;
            ctx.strokeStyle = "lime";
            ctx.setLineDash([10, 6]); // optional dashed border
            ctx.strokeRect(x, y, boxSize, boxSize);
            // Optional: draw “Align your face” text
            ctx.font = "20px Arial";
            ctx.fillStyle = "white";
            ctx.textAlign = "center";
            ctx.fillText("Align your face inside the box", width / 2, y - 10);
        }

        async function loadModels() {
            const url = '{{ asset("asset/face_api_lib") }}';
            statusEl.innerText = "Loading face models...";
            // console.log("⏳ Loading Face API models (with cache)...");
            // Cache files (first time only)
            // await cacheModelFiles(url);
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri(url),
                faceapi.nets.faceLandmark68Net.loadFromUri(url),
                faceapi.nets.faceRecognitionNet.loadFromUri(url),
                faceapi.nets.faceExpressionNet.loadFromUri(url)
            ]);
            modelsLoaded = true;
            console.log("✅ All Face API models ready (cache supported)!");
            // monitorFace();
        }

        // --- Monitor face (detect once then send) ---
        async function monitorFace() {
            if (!modelsLoaded) {
                statusEl.innerText = "Models not loaded yet...";
                return;
            }
            const detectLoop = setInterval(async () => {
                if (!video || video.readyState !== 4) return;
                const detections = await faceapi
                    .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceDescriptors();
                if (!detections.length) {
                    statusEl.innerText = "No face detected. Please come into frame.";
                    scanBtn.style.display = "none";
                    result = null;
                    return;
                }
                statusEl.innerText = "✅ Face detected! Tap Scan to continue.";
                scanBtn.style.display = "inline-block";
                result = detections[0].descriptor;
            }, 3000);
        }

        // --- Scan button click ---
        scanBtn.addEventListener("click", () => {
             initAudioContext(); // 🔈 required
            if (!result) {
                statusEl.innerText = "No face data found. Try again.";
                return;
            }
            clearInterval(detectLoop); // stop face monitoring
            stopVideo(); // stop camera
            scanBtn.style.display = "none";
            statusEl.innerText = "⏳ Checking face on server...";
            sendToServer(result);
        });

        async function sendToServer(descriptor) {
            try {
                // --- If your PHP expects $_POST variables, use FormData ---
                const formData = new FormData();
                formData.append("descriptor", JSON.stringify(descriptor));
                formData.append("btn", "face_check");
                formData.append("type", type);
                formData.append("pro_id", pro_id);
                formData.append("db_base", db_base);
                const response = await fetch("Mobile_update.php", {
                    method: "POST",
                    headers: {
                        'DB': db_base // 👈 custom header (OK)
                    },
                    body: formData
                });
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json(); // use .json() if PHP returns JSON
                // console.log("Raw response:", data);
                // console.log("✅ Response from mobile_update.php:", data);
                //  // ✅ Handle server response
                // if (data.status === "no_match") {
                // statusEl.innerText = "❌ No match found. Please try again.";
                // stopVideo();

                // // restart after small delay
                // setTimeout(() => {
                //     startVideo();
                // }, 2000);
                // } else {
                // statusEl.innerText = "✅ Face matched. Please submit the form.";
                // statusEl.innerText = data.emp_code || data.status;
                // stopVideo();
                // document.getElementById("empForm").style.display = "block";
                // }
                if (data.status === "no_match") {
                    playErrorSound();
                    
                    statusEl.innerText = "❌ No match found. Please try again...";
                    setTimeout(() => {
                        startVideo(); // 🔁 Restart video & detection
                    }, 2000);
                } else {
                  playAlertSound();
                    statusEl.innerText = "✅ Match found!";
                    // alert("Employee Code: " + data.emp_code);
                    // alert("Emp_name : " + data.emp_name)
                    onFaceMatch(data);
                    // document.getElementById("emp_code").value = data.emp_code || "";
                    faceForm.style.display = "block"; // show form
                }
            } catch (error) {
                console.error("❌ Error sending face data:", error);
                //  setTimeout(() => startVideo(), 5000);
            }
        }

        function onFaceMatch(data) {
            statusEl.innerText = "✅ Match found!";
            popupEmpCode.innerText = "Employee Code : " + data.emp_code;
            popupEmpname.innerText = "Employee Name : " + data.emp_name;
            popup_img.href = 'https://onstru.s3.ap-south-1.amazonaws.com/docs/' + data.file;
            popup_img1.src = 'https://onstru.s3.ap-south-1.amazonaws.com/docs/' + data.file;
            popup.style.display = "flex"; // show popup

            addBtn.style.display = data.status ? 'block' : 'none';

            

            $('#attd_sts').text(data.message);

            // Add button click
            addBtn.onclick = () => {
                addRow(data.file, data.emp_code, data.emp_name, data.emp_id,data.cont_name);
                popup.style.display = "none";
                statusEl.innerText = "✅ Added successfully!";
                startVideo(); // restart camera feed
            };

            // Reject button click
            rejectBtn.onclick = () => {
                popup.style.display = "none";
                statusEl.innerText = "🔁 Restarting camera...";
                startVideo(); // restart camera feed
            };
        }

        function addRow(imagePath, empCode, Empname, empId,contName) {
            const tbody = document.getElementById("faceTableBody");
            // 🔍 Check if empCode already exists in any 3rd <td>
            const existingIds = Array.from(tbody.querySelectorAll('input[name="empData[]"]'))
        .map(input => input.value);

            if (existingIds.includes(empId.toString())) {
                console.warn(`⚠️ Employee ${Empname} already exists in table`);
                alert(`Employee ${Empname} already added!`);
                return; // 🚫 Stop duplicate addition
            }

            const aws_url = 'https://onstru.s3.ap-south-1.amazonaws.com/docs/' + imagePath;
            const row = `
                <tr>
                    <td><input checked type="checkbox" name="empData[]" value="${empId}"></td>
                    
                    <td>
                        <a href="${aws_url}" data-fancybox="product">
                        <img src="${aws_url}" alt="">
                        </a>
                    </td>
                    <td> ${empCode} <br> Labour -  ${Empname} <br> Contractor -  ${contName}
                    </td>
                   
                </tr>
            `;
            tbody.insertAdjacentHTML("afterbegin", row);
        }

        window.addEventListener("DOMContentLoaded", async () => {
            try {
                await loadModels(); // ⏳ first load (then cached)
                // await loadEmbeddings(); // faces from backend
                await startVideo(); // start camera
                // await monitorFace(); // initial face check
                statusEl.innerText = "Ready — show your face & blink!";
            } catch (err) {
                console.error("❌ Initialization error:", err);
                statusEl.innerText = "Error initializing system";
            }

        });
    </script>

</body>

</html>