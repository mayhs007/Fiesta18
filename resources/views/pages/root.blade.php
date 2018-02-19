@extends('layouts.root')

@section('content')

<div class="slider fullscreen">
    <ul class="slides" style="background: #d35400"> 
        <li>
            <img src="#">
            <div class="caption center-align">
                <h1>Fiesta 18</h1>
                <h3>MEPCO Schlenk Engineering College (Autonomous)</h3>
                <p class="flow-text"><i class="fa fa-calendar"></i> 3 March 2018</p>                
            </div>
        </li>
    </ul>
    <div class="center-align slider-fixed-item">
        <marquee scrollamount="6">
            <p class="flow-text white-text">
                 Last date for registrations is 27.2.2018, Send your shortfilms to the following email : mepcolegacy17@gmail.com
            </p>
        </marquee>
        {{ link_to_route('auth.login', 'Participate', null, ['class' => 'waves-effect waves-light btn blue']) }}  
        {{ link_to_route('auth.register', 'Register', null, ['class' => 'waves-effect waves-light btn green']) }}
    </div> 
</div>
    
@endsection