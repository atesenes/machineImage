<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>Courseplus Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Image Upload ismakinesi.com">

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
                    </a>
                </div>
            </div>
            <div class="right-side">
            </div>
        </div>
    </header>

    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">

            <h1 class="text-2xl font-bold text-gray-900 leading-0 my-3"> Images </h1>

            <div class="md:flex md:space-x-14" >
                <div class="md:w-full">
                    @if(!isset($record))
                        <form action="{{ route('image.store') }}"  method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('image.update',$record->id) }}" method="POST">
                            @method('PATCH')
                    @endif
                        @csrf
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="form-control">
                            <label>Name</label>
                            <input name="name" type="text">
                        </div>
                        <div class="form-control">
                            <label class="control-label">Image</label>
                            <input type="file" name="image">
                        </div>
                        <div class="form-control">
                            <button type="submit">UPLOAD</button>
                        </div>

                    </div>
                        </form>
                </div>

            </div>

        </div>
    </div>

</div>


<!-- Javascript
================================================== -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('theme/assets/js/uikit.js') }}"></script>
<script src="{{ asset('theme/assets/js/tippy.all.min.js') }}"></script>
<script src="{{ asset('theme/assets/js/simplebar.js') }}"></script>
<script src="{{ asset('theme/assets/js/custom.js') }}"></script>
<script src="{{ asset('theme/assets/js/bootstrap-select.min.js') }}"></script>
<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
<script type="text/javascript">


    let sortable = UIkit.sortable("#imageDiv");

    UIkit.util.on('#imageDiv', 'moved', function (item) {
        let x = item.detail[0].pos.x;
        let y = item.detail[0].pos.y;
        let index = item.detail[0].origin.index;

        let satir = 0;
        let sutun = 0;

        satir = parseInt((y-100)/300);
        if (x<491)
            sutun = 1;
        else if(x < 672)
            sutun = 2;
        else if(x < 868)
            sutun = 3;
        else if(x < 1056)
            sutun = 4;
        else if(x < 1257)
            sutun = 5;
        else if(x < 1450)
            sutun = 6;
        else if(x < 1600)
            sutun = 7;
        else
            sutun = 8;
        let sira = satir * 8 + sutun;


        console.info(item.detail[0].pos);
        console.info(index+1);
        console.log(sira);
        //console.log(item.detail[0]);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "image/reOrder",
            data: {'_token': '{!! csrf_token() !!}', 'old': index+1,'new':sira},
            success: function (response) {
                console.info(response);
                //window.location.reload();
            }
        });
        UIkit.notification(`Move is ${item.detail[1].id}`, 'success');
    });
</script>

</body>

</html>


