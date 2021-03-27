<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- <script src="https://smartystreets.com/products/apis/us-street-api?auth-id=b05d38d1-7da7-d902-4581-5881f48f7d5c&auth-token=3lZxdrQbsPZapyrTzhCr&candidates=10&street=&city=&state=&zipcode=&match=invalid&method=get"></script> --}}
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/5.2/jquery.liveaddress.min.js"></script>
    {{-- <script src="https://us-extract.api.smartystreets.com?auth-id=46342cd0-7f9f-8f92-1eae-b52ef68be03b&auth-token=8GB3AQRtZjYLxIQCs2c5"></script> --}}
    {{-- <script src="https://us-zipcode.api.smartystreets.com/lookup?auth-id=b05d38d1-7da7-d902-4581-5881f48f7d5c&auth-token=3lZxdrQbsPZapyrTzhCr"></script> --}}
   <script src="https://us-zipcode.api.smartystreets.com/lookup?key=79856523622191784&city=&state=&zipcode="></script>

   <script>
        $.LiveAddress({
            key: "79856523622191784",
            debug: true,
            target: "US", //INTERNATIONAL,
            autocomplete: 5,
            autoVerify: false,
            addresses: [{
                address1: '#address',
                locality: '#city',
                administrative_area: '#state',
                postal_code: '#PropertyZip',
            }]
        });
    </script>

    {{-- <script src="https://us-street.api.smartystreets.com/street-address?auth-id=46342cd0-7f9f-8f92-1eae-b52ef68be03b&auth-token=8GB3AQRtZjYLxIQCs2c5"></script> --}}

    <script>
        $(document).ready(function(){
           
            $('#address').keyup(function(){
                event.preventDefault();
                console.log('clicked');
                var street = $("#address").val();
                console.log(street)
                CallAPI(street);
                function CallAPI(streetAddress) {
		
                    var request = new XMLHttpRequest();
                    request.open('POST', encodeURI('https://us-street.api.smartystreets.com/street-address?auth-id=46342cd0-7f9f-8f92-1eae-b52ef68be03b&auth-token=8GB3AQRtZjYLxIQCs2c5'), true);
                    request.setRequestHeader("Content-Type", "application/json;charset=utf-8");
                    var reqdata = JSON.stringify(
                        [{
                            "street":streetAddress
                        }]
                    );
                    request.onreadystatechange = function() {
                        if(this.readyState == 4 && this.status == 200) {
                            var data = JSON.parse(this.response);
                            $("#city").val(data[0].components.city_name);
                            $("#state").val(data[0].components.state_abbreviation);
                            $("#PropertyZip").val(data[0].components.zipcode);
                            $("#county").val(data[0].metadata.county_name);
                            console.log(data[0].components.state_abbreviation);
                            console.log(data[0].components.city_name);
                            console.log(data[0].components.zipcode);
                            console.log(data[0].metadata.county_name);
                        }
                    }
                    request.send(reqdata);
                }
            });


            //     $('#registrationForm').submit(function(e){
        //         e.preventDefault();
        //         // console.log('entered')
        //         // var county = '';
        //         var street = $("#address").val();
        //         var city = $("#city").val();
        //         var state = $("#state").val();
        //         var zipcode = $("#PropertyZip").val();
        //         // console.log(street)
        //         // console.log(city)
        //         // console.log(state)
        //         // console.log(zipcode)
        //         var county = CallAPI(street, city, state, zipcode);
        //         function CallAPI(street1, city1, state1, zip1) {
        //                 var request = new XMLHttpRequest();
        //                 request.open('POST', encodeURI('https://us-street.api.smartystreets.com/street-address?auth-id=46342cd0-7f9f-8f92-1eae-b52ef68be03b&auth-token=8GB3AQRtZjYLxIQCs2c5'), true);
        //                 request.setRequestHeader("Content-Type", "application/json; charset=utf-8");
        //                 var reqdata = JSON.stringify([{
        //                     "street":street1,
        //                     "city":city1,
        //                     "state":state1,
        //                     "zipcode":zip1
        //                 }]);
        //                 request.onreadystatechange = function() {
        //                     if(this.readyState == 4 && this.status == 200) {
        //                         var data = JSON.parse(this.response);
        //                         var value =  data[0].metadata.county_name;
        //                         var name = $('#name').val();
        //                         var email = $('#email').val();
        //                         var phone = $('#phone').val();
        //                         var password = $('#password').val();

        //                         $.ajaxSetup({
        //                             headers:
        //                                 {
        //                                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                                 },
        //                             type:'post',
        //                             url: "{{ route("registerUser") }}",
        //                             data: {
        //                                 name: name,
        //                                 email: email,
        //                                 phone: phone,
        //                                 street: street,
        //                                 state: state,
        //                                 city: city,
        //                                 zipcode: zipcode,
        //                                 password: password,
        //                                 county: value
        //                             } ,
        //                             // async: true,
        //                             // dataType: 'json',
                                    
        //                         });
        //                         $.post()
        //                         .done(function(response) {
        //                             console.log('success')
        //                            alert('User Registered');
        //                            window.location.reload();
        //                         })
        //                         .fail(function() {
        //                             console.log('failed');
        //                         })
        //                     }
        //                 }
        //                 request.send(reqdata);
        //         }
        //        var county = CallAPI(street, city, state, zipcode);
        //         console.log(county)
               
        //     });
        });

       
    </script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
