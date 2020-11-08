<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://js.stripe.com/v3/"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Styles -->
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html,
        body {
            background-color: #f9f9f9;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .td-header {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="app" class="container" style="text-align: center;">
        <h1>CHECKOUT</h1>
        @if(Request()->payment=='cancel')
        <div class="alert alert-danger" role="alert">
            Error!
        </div>
        @endif
        <cart-component p_stripe_api_key='{{env("STRIPE_API_KEY")}}' p_csrf_token='{{csrf_token()}}' p_base_url='{{url("/")}}'>
        </cart-component>
    </div>

</body>

</html>