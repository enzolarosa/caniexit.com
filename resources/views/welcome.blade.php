<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129313629-4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-129313629-4');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="can I exit from home? ">
    <meta name="keywords"
          content="can i exit, can exit, i exit, i can exit, coronavirus, exit, corona, virus, can i get out, can i out, i get out, get out">

    <title>Can I Get Out?</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            No, you can not exit!
        </div>
    </div>
    @if(isset($data) && isset($keys))
        <table class="table-auto">
            <thead>
            <tr>
                @foreach($keys as $key)
                    <th class="px-4 py-2">{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($data as $k=>$d)
                <tr>
                    @foreach($keys as $key)
                        <td class="border px-4 py-2">{{$d[$key]}}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>
