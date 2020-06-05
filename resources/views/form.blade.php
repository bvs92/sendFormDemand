<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        ul {
            margin: 20px 0px;
        }

        ul > li {
            font-size:20px;
            font-weight:bold;
            margin-top:50px;
        }
    </style>

    </head>
    <body>
        <div class="container-fluid" style="background-image:url(img/bkd.jpg); background-repeat:no-repeat;background-size:cover;background-attachment: fixed;">
            <div class="container p-4">
                <div class="row my-4">
                    <div class="col-lg-12" style="margin: 30px 0px;">
                        <h1 class="text-center my-2" style="font-size:34px;color:white;">Trimiteti-ne cererea folosind formularul de mai jos.</h1>
                    </div>
                </div>
    
                <div class="row my-4">
                    <div class="col-lg-6 p-4">
                        <h2 style="font-size:30px;margin: 20px 0px;color:white;">Gasiti un profesionist in zona dumneavoastra.</h2>
                        <ul style="color:white;">
                            <li>Retea de profesionisti verificati.</li>
                            <li>Obtineti pana la 5 oferte de la 5 profesionisti.</li>
                            <li>Comanda dumneavoastra este tratata imediat ce este inregistrata in platforma.</li>
                            <li>Serviciu gratuit si fara angajament.</li>
                            <li>Preturi competitive.</li>
                        </ul>
                    </div><!-- end left side -->
                    <div class="col-lg-6 shadow-sm rounded" style="background:white;padding:10px 20px;">
                        <div id="app">
                            <form-component></form-component>
                        </div>
                    </div><!-- end right side -->
                </div>
            </div><!-- end container -->
        </div><!-- end container-fluid -->
        <!-- Optional JavaScript -->

        <!-- VueJs -->
        <script src="/js/app.js"></script>

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
