<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> @yield('title') </title>

    <!-- Material Design fonts 
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    -->
    
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">


    <!-- Bootstrap Material Design 
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-material-design.css">
    -->

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>

</head>


<body>

@include('shared.navbar')

@yield('content')


<!-- 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/material.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // This command is used to initialize some elements and make them work properly
            $.material.init();

            alert('javacsrip ok');
        });
    </script>
-->

</body>
</html>