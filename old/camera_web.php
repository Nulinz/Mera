<?php
session_start();

if (!empty($_SESSION['photo_updated'])) {
    echo "<script>alert('Profile Photo Updated Successfully');</script>";
    unset($_SESSION['photo_updated']);  // show only once
}
// else{
//             echo "<script>alert('Profile Photo no upodate');</script>";
//         }
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

    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="./camera_web.css">
    
    <!-- Face API -->
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

</head>

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
                <canvas class="canvas" id="overlay"></canvas>
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

       

        <div class="attd-content" id="detected">
            <form action="Mobile_update.php" method="post" enctype="multipart/form-data">
                <div class="col-sm-12 d-flex align-items-center justify-content-center mt-3">
                     <input type="file" id="in_img1" name="file_added" style="display:none;">
                     <input type="hidden" name="emp_id" value="<?php echo $_GET['emp_id']; ?>">
                      <input type="hidden" name="db_base" value="<?php echo $_GET['db_base']; ?>">
                      <input type="hidden" name="c_by" id="" value="<?php echo $_GET['c_by']; ?>">
                     <input type="hidden" name="btn" value="save_face_data">
                      <textarea name="face_descriptor" id="face_descriptor"  hidden></textarea>
                    <button type="submit" id="sub" class="submitbtn">Submit</button>

                     
                </div>
                 
            </form>
            <!-- <button id="back" class="submitbtn">Back</button> -->
                   
        </div>
    </div>

    <!-- Script -->
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

    <!-- Lightbox -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('.example').DataTable({
                "paging": false,
                "searching": false,
                "ordering": true,
                "bDestroy": true,
                "info": false,
                "responsive": true,
                "pageLength": 10,
                "dom": '<"top"f>rt<"bottom"lp><"clear">'
            });
        });
    </script>

    <script>
        // document.getElementById('back').addEventListener('click', function() {
        //     if (window.FlutterChannel) {
        //         console.log("📡 FlutterChannel found — sending 'go_back' message...");
        //         window.FlutterChannel.postMessage('go_back'); // 👈 send message to Flutter
        //         console.log("✅ Message sent to Flutter.");
        //     } else {
        //         // fallback for normal browser
        //         // window.history.back();
        //     }
        // });
</script>

    <script>

         
            let stream = null; // store camera stream globally
             const video = document.getElementById('video');
            const overlay = document.getElementById('overlay');
            const ctx = overlay.getContext('2d');
            const statusEl = document.getElementById('matchStatus');
            const scanBtn = document.getElementById('sub');
            // const backBtn = document.getElementById('back');
            const $video = $('.video');
            const $canvas = $('.canvas');
            const $cameraIcon = $('.cameraIcon i.camera-icon');
            const $cameraFn = $('.camerafnctn');
            const $imagePreview = $('.imagePreview');
            const $removeImage = $('.removeImage');
            const $input = $('#in_img1');
            let modelsLoaded = false;


       

        $(document).ready(async function () {

            scanBtn.disabled = true; // disable submit until face is captured
            scanBtn.style.display = "none"; // hide submit button initially
            // backBtn.style.display = "block"; // show back button
            // await startVideo();

            // Start camera automatically on page load
            // try {
            //     try {
            //     stream = await navigator.mediaDevices.getUserMedia({
            //                 video: {
            //                     facingMode: {
            //                         exact: "environment"
            //                     }
            //                 }
            //             });
            //         } catch {
            //             stream = await navigator.mediaDevices.getUserMedia({
            //                 video: true
            //             });
            //         }
            //     $video[0].srcObject = stream;
            //     $cameraIcon.hide();
            //     $cameraFn.show();


            //     video.addEventListener('loadedmetadata', () => {
            //         overlay.width = video.videoWidth;
            //         overlay.height = video.videoHeight;
            //         drawBox();
            //     });

            // } catch (err) {
            //     console.error('Error accessing camera:', err);
            //     alert('Unable to access camera. Please check permissions.');
            // }

            // Capture button click
            $('.capture').on('click', () => {
                const context = $canvas[0].getContext('2d',{ willReadFrequently: true });
                $canvas.attr('width', $video[0].videoWidth);
                $canvas.attr('height', $video[0].videoHeight);
                context.drawImage($video[0], 0, 0);

                $canvas[0].toBlob(async (blob) => {
                    if (blob) {
                        const file = new File([blob], 'captured-image.jpg', { type: 'image/jpeg' });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        $input[0].files = dataTransfer.files;

                        // Show preview
                        $imagePreview.attr('src', URL.createObjectURL(file)).show();
                        $removeImage.show();

                        // Stop camera
                        const stream = $video[0].srcObject;
                        if (stream) stream.getTracks().forEach(track => track.stop());
                        $video[0].srcObject = null;

                        // Hide video after capture
                        $cameraFn.hide();

                        var fileSizeKB = (file.size / 1024).toFixed(1);
                        // alert('Image captured successfully! File size: ' + fileSizeKB + ' KB');
                        await monitorFace($canvas[0]);

                        //  console.log('✅ Captured file:', file.name, (file.size / 1024).toFixed(1), 'KB');
                    }
                }, 'image/jpeg' ,1.0);


            });

            // Remove image & reset camera
            $removeImage.on('click', async () => {
                $imagePreview.hide().attr('src', '');
                $removeImage.hide();
                $input.val('');

                // Restart camera again
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
                    $video[0].srcObject = stream;
                    $cameraFn.show();
                } catch (err) {
                    console.error('Error accessing camera:', err);
                    alert('Unable to access camera again. Please refresh.');
                }

                
            });
        });

        async function loadModels() {
            const url = 'https://onstru.com/dlr/face_api_lib';
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
            // console.log("✅ All Face API models ready (cache supported)!");
            // monitorFace();
        }

         // --- Monitor face (detect once then send) ---
        async function monitorFace(canvasEl) {
            if (!modelsLoaded) {
                statusEl.innerText = "Models not loaded yet...";
                alert("Models not loaded yet.");
                return;
            }

            const faceInput = document.getElementById('face_descriptor');
            statusEl.innerText = "Analyzing captured image...";

            try {
                const detection = await faceapi
                        .detectSingleFace(canvasEl, new faceapi.TinyFaceDetectorOptions())
                        .withFaceLandmarks()
                        .withFaceDescriptor();

                if (!detection) {
                    statusEl.innerText = "⚠️ No face detected in captured image!";
                    alert("No face detected in the captured image!");
                    return;
                }

                statusEl.innerText = "✅ Face detected successfully!";
                 scanBtn.disabled = false;
                 scanBtn.style.display = "block";
                // backBtn.style.display = "none"; // show back button
                const descriptor = detection.descriptor;

                // Convert descriptor Float32Array → JSON string
                if (faceInput) {
                    faceInput.value = JSON.stringify(Array.from(descriptor));
                    // console.log("Descriptor saved to form:", faceInput.value.substring(0, 100) + "...");
                }

                // alert("✅ Face descriptor captured and saved to form!");

            } catch (err) {
                console.error("Error detecting face:", err);
                alert("Error detecting face. Check console for details.");
            }
        }


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
            $cameraIcon.hide();
            $cameraFn.show();
            console.log("📷 Camera started");
            // monitorFace();
             // Wait until video metadata (size) is ready
            video.addEventListener('loadedmetadata', () => {
                overlay.width = video.videoWidth;
                overlay.height = video.videoHeight;
                drawBox();
            });
        }

         // drawing the lines around the video
        function drawBox() {
            // alert("drawBox called");
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