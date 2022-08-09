<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>Image List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Image Lists ismakinesi.com">

    <!-- Favicon -->
    <link href="{{asset('theme/assets/images/favicon.png')}}" rel="icon" type="image/png">

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
                        <img src="https://ismakinesi.com/assets/ismakinesi.svg" class="logo_inverse" alt="">
                        <img src="https://ismakinesi.com/assets/ismakinesi.svg" class="logo_mobile" alt=""
                    </a>
                </div>

                <!-- icon menu for mobile -->
                <div class="triger" uk-toggle="target: #wrapper ; cls: is-active">
                </div>

            </div>
            <div class="right-side">
                <a href="{{ route('image.create') }}">
                    <button type="button" class="button">
                        <span class="icon-material-outline-add-a-photo">
                            Image Upload
                                     </span>
                    </button>
                </a>


            </div>
        </div>
    </header>

    <!-- Main Contents -->
    <div class="main_content">
        <div class="container_fluid" style="margin-right:100px;">

            <h1 class="text-2xl font-bold text-gray-900 leading-0 my-3"> Images </h1>

            <div class="md:flex md:space-x-14" >
                <div class="md:w-full">

                        <div class="grid md:grid-cols-8 gap-4" id="imageDiv" uk-sortable="cls-custom: transform -rotate-6 shadow-2xl">

                        @foreach($records as $record)
                            <div class="bg-white rounded-lg shadow-md p-1 flex" id="{{$record->id}}" style="text-align: center">
                                <div class="flex-1">
                                    <div style="text-align: center;">
                                        <img src="{{ asset('images/' . $record->image) }}" style="max-width: 100px; max-height: 100px;">
                                    </div>
                                    <div class="flex items-center space-x-1 text-blue-500 text-xs mt-2" style="display: inline">
                                        <i class="icon-feather-calendar pr-1"></i>
                                        {{ date('d-m-Y', strtotime($record->created_at)) }}
                                    </div>
                                    <div class="flex pl-8 text-red-400" style="display: inline; text-align: right">
                                        <a href="image/{{$record->id}}" onclick="
                                                var result = confirm('Are you sure you want to delete this record?');
                                                if(result){
                                                    event.preventDefault();
                                                    document.getElementById('delete-image-{{$record->id}}').submit();
                                                }"><i class="icon-feather-trash text-xl"></i>
                                        </a>
                                    </div>
                                </div>

                                <form method="POST" id="delete-image-{{$record->id}}"
                                      action="{{route('image.destroy', [$record->id])}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>

                            </div>
                        @endforeach

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
@include('sweetalert::alert')


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

        satir = parseInt((y-100)/150);
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
                window.location.reload();
            }
         });
        UIkit.notification(`Image is moved`, 'success');
    });
</script>

</body>

</html>


