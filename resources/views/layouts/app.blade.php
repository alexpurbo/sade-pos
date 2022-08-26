<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
      

        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <!-- JQUERY -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

        <!-- Bootstrap Icon -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

                        
            <footer class="bg-white shadow">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                        <ul class="adress">         
                            <li>
                                <p>Sade pos Aplikasi Terintergrasi</p>
                            </li>
                    </div>

                    

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <ul class="social">
                            <span>Kontak</span>    
                            <li style="margin-top: 40px;">
                            <p>Alamat </p>
                            </li>
                            
                            <li>
                            <P>email@sade.id</P>
                            </li>
                            
                            <li>
                                <p>+62 808080808</p>
                            </li>
                            
                            <li>
                            <a href="https://www.instagram.com" target="_blank"><img class="socmed" src="" alt="instagram"></a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
            </footer>
        </div>
    </body>
</html>
