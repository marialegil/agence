<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Agence Interativa</title>

        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('htps://mariagil-agence.herokuapp.com/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('htps://mariagil-agence.herokuapp.com/font-awesome/css/font-awesome.min.css')}}" />
        <link rel="stylesheet" href="{{ asset('htps://mariagil-agence.herokuapp.com/css/bootstrap-multiselect.min.css')}}" />
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Barra de Navegación</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><i class="fa fa-home"></i> Agence</a>
                </div>

                
            </div>
        </nav>
        <div class="container">
            @yield('content')
            <a data-url="{{ url('/') }}" style="display:none;" id="raiz"></a>

        </div>

        <script src="{{ asset('htps://mariagil-agence.herokuapp.com/js/jquery-2.1.4.min.js')}}"></script>
        <script src="{{ asset('htps://mariagil-agence.herokuapp.com/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('htps://mariagil-agence.herokuapp.com/js/bootstrap-multiselect.min.js')}}"></script>
        <script src="{{ asset('htps://mariagil-agence.herokuapp.com/js/chart.min.js')}}"></script>
        <script src="{{ asset('htps://mariagil-agence.herokuapp.com/js/scripts.js')}}"></script>

    </body>
</html>
