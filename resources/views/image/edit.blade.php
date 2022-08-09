<!DOCTYPE html>
<html lang="en">
<head>
    <title>Image List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Image Lists ismakinesi.com">

    <!-- Favicon -->
    <link href="{{ asset('theme/assets/images/favicon.png') }}" rel="icon" type="image/png">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('theme/assets/css/icons.css') }}">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('theme/assets/css/uikit.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/assets/css/style.css') }}">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@4/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('dist/cropper.css') }}">
    <style>
        .label {
            cursor: pointer;
        }

        .progress {
            display: none;
            margin-bottom: 1rem;
        }

        .alert {
            display: none;
        }

        .img-container img {
            max-width: 100%;
        }
    </style>
</head>
<body>
<div id="wrapper" class="is-verticle">

    <!--  Header  -->
    <header uk-sticky>
        <div class="header_inner">
            <div class="left-side">

                <!-- Logo -->
                <div id="logo">
                    <a href="{{ route('home') }}">
                        <img src="https://ismakinesi.com/assets/ismakinesi.svg" alt="">
                        <img src="https://ismakinesi.com/assets/ismakinesi.svg" class="logo_inverse" alt="">
                        <img src="https://ismakinesi.com/assets/ismakinesi.svg" class="logo_mobile" alt="">
                    </a>
                </div>

                <!-- icon menu for mobile -->
                <div class="triger" uk-toggle="target: #wrapper ; cls: is-active">
                </div>

            </div>
        </div>
    </header>
    <div class="main_content">
        <div class="container_fluid" style="padding:200px;">


            <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    @csrf
                    <div class="col-lg-12" style="text-align: center">
                        <label style="font-size: 15px;">Select Image and Upload</label>
                        <hr>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group" style="text-align: center">
                            <input type="file" class="image" onclick="clearImageData()" accept=".jpg,.jpeg,.png">
                            <input type="hidden" name="image" value="{{$record->image}}" id="upload-image">
                        </div>
                    </div>
                    <div class="col-6" style="text-align: center">
                        <button type="submit" class="button">
                            <span class="icon-material-outline-add-a-photo" style="text-align: center">
                                UPLOAD
                                         </span>
                        </button>
                    </div>
                </div>
            </form>

            <div class="col-lg-12 small" style="text-align: center; margin-left: 20%">
                <img src="{{ asset('images/'.$record->image) }}" style="max-height: 500px;"
                     alt="..." class="img-thumbnail">
            </div>


        </div>
    </div>

    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0"
             aria-valuemin="0" aria-valuemax="100">0%
        </div>
    </div>
    <div class="alert" role="alert"></div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">

                        <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('theme/assets/js/uikit.js') }}"></script>
<script src="{{ asset('theme/assets/js/tippy.all.min.js') }}"></script>
<script src="{{ asset('theme/assets/js/simplebar.js') }}"></script>
<script src="{{ asset('theme/assets/js/custom.js') }}"></script>
<script src="{{ asset('theme/assets/js/bootstrap-select.min.js') }}"></script>
<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
<script src="https://unpkg.com/jquery@3/dist/jquery.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap@4/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{asset('dist/cropper.js')}}"></script>
<script>
    var $modal = $('#modal');
    var image = document.getElementById('image');
    var cropper;

    $("body").on("change", ".image", function (e) {
        var files = e.target.files;
        var done = function (url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: 16 / 16,
            viewMode: 1,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function () {
        canvas = cropper.getCroppedCanvas({
            width: 500,
            height: 500,
        });

        canvas.toBlob(function (blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64data = reader.result;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{route('image.savePicture')}}",
                    data: {'_token': '{!! csrf_token() !!}', 'image': base64data},
                    success: function (response) {
                        console.info(response);
                        if (response.success === 1) {
                            $modal.modal('hide');
                            $('.img-thumbnail').attr('src', response.thumbnail_image);
                            $('#upload-image').val(response.image_path);
                            UIkit.notification({message: 'Image Uploaded'});
                        } else {
                            UIkit.notification({message: 'Image Uploaded'})
                        }
                    }
                });
            }
        });
    })

    function clearImageData() {
        $('.image').val("");
    }
</script>
</body>
</html>
