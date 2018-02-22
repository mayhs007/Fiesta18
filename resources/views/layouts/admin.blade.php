<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Fiesta|Admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{ HTML::Style("css/materialize.min.css") }}
        {{ HTML::Style("css/font-awesome.min.css") }} 
        {{ HTML::Style("css/app.css") }}                
        {{ HTML::Style("css/material-icons.css") }}                                              
        {{ HTML::Script("js/jquery.min.js") }}   
        {{ HTML::Script("js/materialize.min.js") }} 
        {{ HTML::Script("js/app.js") }}   
<style>
body{font-family: 'Raleway', sans-serif;
}
</style>		
    </head>
    <body>
        @include('layouts.partials.admin_nav')
        <div class="container">
            <div class="row">
                <div class="col s12">
                    @include('layouts.partials.flash')
                </div>                      
            </div>
            @yield('content')
        </div>
        <div class="footer">    
            <span class="white-text">
                &copy; MEPCO 2018
            </span>
            
        </div>
    </body>
</html>