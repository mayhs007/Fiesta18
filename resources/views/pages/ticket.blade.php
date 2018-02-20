<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Legacy17 Ticket</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .header{
            padding: 5px;
            text-align: center;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;                
        }
        body{
            border: 1px solid #000;
            padding: 5px;
    
        }
    </style>    
</head>
<body>

@foreach($events as $event)
<center><h1>MEPCO SCHLENK ENGG COLLEGE</h1></center>
<center><h4>Fiesta 18</h4></center>
    <p class="header text-uppercase">{{$event->title}}</p>
    <ul class="browser-default">
            @foreach($event->getRulesList() as $rule)
                <li>{!! $rule !!}</li>
            @endforeach  
        </ul> 
    <table class="table">
        <tbody>
            <tr>
                <th>Fiesta18 ID</th>
                <td>
                    {{$user->F18Id()}}
                </td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $user->full_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>{{ $user->gender }}</td>
            </tr>
            <tr>
                <th>Dep,Yr,Sec</th>
                <td>{{ $user->department->name }}{{ $user->year->name }}{{ $user->section->name }}</td>
               
            </tr>
        </tbody>
    </table>
    <div class="row" style="margin-top: 70px">
        <div class="col-xs-7">
            <p>Date:</p>  
        </div>  
        <div class="col-xs-3">
            <p class="text-center">
                Signature of {{$event->staff_incharge}}
            </p>
        </div>
    </div>
@endforeach
@if($user->hasTeams())
<center><h1>MEPCO SCHLENK ENGG COLLEGE</h1></center>
<center><h4>Fiesta 18</h4></center>

    @foreach($user->teams as $team)
    <p class="header text-uppercase">{{ $team->events->first()->title }}</p>
    @foreach($user->TeamEvents() as $event)
    <ul class="browser-default">
            @foreach($event->getRulesList() as $rule)
                <li>{!! $rule !!}</li>
            @endforeach  
        </ul> 
    
    @endforeach
    <p class="text-uppercase header">Team Details</p>
        <p>{{ $team->name }}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>F18ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($team->teamMembers as $index => $teamMember)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                  
                        <td>{{ $teamMember->user->full_name }}</td>
                        <td>{{ $teamMember->user->email }}</td>
                        <td>{{ $teamMember->user->gender }}</td>
                        
                    </tr>                 
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="row" style="margin-top: 70px">
        <div class="col-xs-7">
            <p>Date:</p>  
        </div>  
        <div class="col-xs-3">
            <p class="text-center">
                Signature of {{$team->events->first()->staff_incharge}}
            </p>
        </div>
    </div>
    @endif
</body>
</html>