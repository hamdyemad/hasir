<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ URL::asset('/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        body {
            padding: 0 200px;
            direction: rtl;
            font-family: "Myriad", sans-serif;
        }
        header {
            padding: 20px 0;
        }
        header img {
            display: block;
            width: 150px;
            margin: auto;
            height: 70px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        ul li:not(:last-of-type) {
            margin-bottom: 20px;
        }
        ul li span:first-child {
            background-color: #cc9d49;
            color: #fff;
            border-radius: 10px;
        }
        ul li span {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <header>
        @if (get_setting('logo'))
            <img src="{{ asset(get_setting('logo')) }}">
        @else
            <img src="{{ URL::asset('/images/default.png') }}">
        @endif
    </header>
    <div class="content">
        <div class="container">
            <ul>
                <li>
                    <span>الأسم</span>
                    <span>{{ $data['name'] }}</span>
                </li>
                <li>
                    <span>البريد الألكترونى</span>
                    <span>{{ $data['email'] }}</span>
                </li>
                <li>
                    <span>نوع الطلب</span>
                    <span>{{ $data['type'] }}</span>
                </li>
                <li>
                    <span>الجوال</span>
                    <span>{{ $data['phone'] }}</span>
                </li>
                @if($data['notes'])
                    <li>
                        <span>الملاحظات</span>
                        <span>{{ $data['notes'] }}</span>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</body>
</html>
