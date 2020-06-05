@extends('base')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row justify-content-between mb-3">
        <h2 class="lead text-muted"><i class="fas fa-route"></i> Add transfer</h2>
        <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target="#collapseQrScanner" aria-expanded="false" aria-controls="collapseQrScanner">
            <i class="fas fa-qrcode"></i> QR Scanner
        </button>
    </div>

    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger mx-auto" style="max-width: 540px;">{{ $error }}</div>
        @endforeach
    @endif

    <div class="collapse" id="collapseQrScanner">
        <div class="row justify-content-center">
            <div class="btn-group btn-group-toggle mb-1" data-toggle="buttons">
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
        <div class="row justify-content-center mb-3">
            <div class="card" style="width: 320px; max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                <div class="card-header py-1">
                    <div class="row justify-content-between">
                        <h5><span class="badge badge-secondary text-white" id="numList">0</span></h5>
                        <div class="custom-control custom-switch text-center">
                            <input type="checkbox" class="custom-control-input" value="1" id="autoSave" checked>
                            <label class="custom-control-label" for="autoSave">Auto save.</label>
                        </div>
                    </div>
                </div>
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
            
            var i = 1;
            $(document).ready(function() {
                $("input[name='in_out']").click(function () {
                    $("#numList").text("0");
                    $("#result_list").empty();
                    i = 1;
                });
            });

            var scanner = new Instascan.Scanner(opts);
            scanner.addListener('scan', function(content) {
                if ($('input:checked[id="autoSave"]').length == 0) {
                    $("#item_code").prepend(content+"\n");
                } 
                else {
                    $("#item_code").empty();
                    $("#result_list").prepend('<li class="list-group-item d-flex justify-content-between align-items-center py-2" id="'+ i +'">'+ content +'</li>');
                }
                
                $("#numList").text(i);
                i++;
                // enable vibration support
                navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;

                if (navigator.vibrate) {
                    // vibration API supported
                    window.navigator.vibrate(80);
                }
                if ($('input:checked[id="autoSave"]').length == 1) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type:'POST',
                        url:'/routing',
                        data: {
                            user_id: {{ Auth::user()->id }},
                            item_code: content,
                            in_out: $('input:checked[name="in_out"]').val(),
                            quantity: $("#quantity").val(),
                            description: $("#description").val()
                        },
                        success: function(data) {
                            console.log(data.success);
                            $("#item_code").empty();
                        },
                        error: function (data) {
                            console.log(data.error);
                        }
                    });
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
        
    </div>

    <div class="row justify-content-center">
        {!! Form::open(array('url' => 'routing')) !!}
        {{ csrf_field() }}
            <div class="form-group">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                
                <div class="row">
                    <div class="col-6">
                        {!! Form::label('item_code', 'Item code:') !!}
                        {!! Form::textarea('item_code', old('item_code'), array('id' => 'item_code', 'class' => 'form-control', 'rows' => '7', 'autofocus')) !!}
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::label('in_out', 'Status:') !!}
                            <br/>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons" id="status">
                                <label class="btn btn-outline-info">
                                  <input type="radio" name="in_out" id="in" value="in"> <i class="fas fa-arrow-left"></i>
                                </label>
                                <label class="btn btn-outline-secondary active">
                                  <input type="radio" name="in_out" id="hold" value="hold" checked> <i class="fas fa-arrow-left"></i><i class="fas fa-arrow-right"></i>
                                </label>
                                <label class="btn btn-outline-warning">
                                  <input type="radio" name="in_out" id="out" value="out"> <i class="fas fa-arrow-right"></i>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('quantity', 'Quantity') !!}
                            {!! Form::number('quantity', '1', array('id' => 'quantity', 'class' => 'form-control', 'min' => '0')) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {!! Form::textarea('description', old('description'), array('id' => 'description', 'class' => 'form-control', 'rows' => '2')) !!}
                </div>
            </div>
            {!! Form::submit('Save', array('class' => 'btn btn-block btn-sm btn-primary hov-slide float-right')) !!}
        {!! Form::close() !!}
    </div>
@stop