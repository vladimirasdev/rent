@extends('base')

@section('content')
    <div class="row justify-content-left">
        <h2 class="lead text-muted"><i class="fas fa-qrcode"></i> QR Scanner</h2>
    </div>

    <div class="row justify-content-center mb-1">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-dark">
                <input type="radio" name="options" value="1" autocomplete="off" ><i class="fas fa-mobile"></i> Back cam
            </label>
            <label class="btn btn-outline-danger active">
                <input type="radio" name="options" value="3" autocomplete="off" checked><i class="fas fa-stop"></i> Stop
            </label>
            <label class="btn btn-outline-dark">
                <input type="radio" name="options" value="2" autocomplete="off"><i class="fas fa-mobile-alt"></i> Front cam
            </label>
        </div>
    </div>
    <div class="row justify-content-center">
        <video class="alert-secondary" id="preview" autoplay="autoplay" width="320px" height="240px" style="border-radius: 5px; object-fit:cover; border: 1px solid rgba(0, 0, 0, 0.1);"></video>
    </div>
    <div class="row justify-content-center">
        <div class="card" style="width: 320px; max-height: 300px; overflow-y: auto; overflow-x: hidden;">
            
            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                <h5><span class="badge badge-info text-white" id="numList">0</span></h5>
                <button type="button" class="btn btn-sm btn-light border-secondary" onclick="copyToClipboard('#result_list')">Copy</button>
            </li>
            <ul class="list-group" style="width: 320px; min-height: 42px;" id="result_list"></ul>
        </div>
    </div>
    <script type="text/javascript">
        let opts = {
                    // Whether to scan continuously for QR codes. If false, use scanner.scan() to manually scan.
                    // If true, the scanner emits the "scan" event when a QR code is scanned. Default true.
                    continuous: true,
                    
                    // The HTML element to use for the camera's video preview. Must be a <video> element.
                    // When the camera is active, this element will have the "active" CSS class, otherwise,
                    // it will have the "inactive" class. By default, an invisible element will be created to
                    // host the video.
                    video: document.getElementById('preview'),
                    
                    // Whether to horizontally mirror the video preview. This is helpful when trying to
                    // scan a QR code with a user-facing camera. Default true.
                    mirror: false,
                    
                    // Whether to include the scanned image data as part of the scan result. See the "scan" event
                    // for image format details. Default false.
                    captureImage: false,
                    
                    // Only applies to continuous mode. Whether to actively scan when the tab is not active.
                    // When false, this reduces CPU usage when the tab is not active. Default true.
                    backgroundScan: true,
                    
                    // Only applies to continuous mode. The period, in milliseconds, before the same QR code
                    // will be recognized in succession. Default 5000 (5 seconds).
                    refractoryPeriod: 5000,
                    
                    // Only applies to continuous mode. The period, in rendered frames, between scans. A lower scan period
                    // increases CPU usage but makes scan response faster. Default 1 (i.e. analyze every frame).
                    scanPeriod: 5
            };

            var scanner = new Instascan.Scanner(opts);
            var i = 1;
            scanner.addListener('scan', function(content) {
                $("#result_list").prepend('<li class="list-group-item d-flex justify-content-between align-items-center py-2" id="'+ i +'">'+ content +'<span class="badge badge-dark" onclick="$(`#'+ i +'`).remove();"><i class="fas fa-times"></i></span></li>');
                $("#numList").text(i);
                i++;
                // enable vibration support
                navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;

                if (navigator.vibrate) {
                    // vibration API supported
                    window.navigator.vibrate(50);
                }
            });
            Instascan.Camera.getCameras().then(function (cameras) {
                if(cameras.length > 0) {
                    scanner.stop();
                    $('[name="options"]').on('change', function() {
                        if ($(this).val() == 1) {
                            if (cameras[0] != "") {
                                scanner.start(cameras[1]);
                            }
                            else {
                                console.log('No Front camera found!');
                            }
                        }
                        else if ($(this).val() == 2) {
                            if (cameras[1] != "") {
                                scanner.start(cameras[0]);
                            }
                            else {
                                console.log('No Back camera found!');
                            }
                        }
                        else if ($(this).val() == 3) {
                            scanner.stop();
                        }
                    });
                }
                else {
                    console.log('No cameras found.');
                }
            }).catch(function(e) {
                console.log(e);
            });
    </script>
@stop