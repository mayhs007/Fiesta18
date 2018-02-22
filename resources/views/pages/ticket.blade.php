<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiesta18 Registration Form</title>
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
.page-break {
    page-break-after: always;
}
</style>
    </style>    
</head>
<body>

@foreach($events as $event)
<center><h1>MEPCO SCHLENK ENGINEERING COLLEGE, SIVAKASI</h1></center>
<center><h3>(An Autonomous Institution)</h3></center>
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
                <th>RollNo</th>
                <td>{{ $user->roll_no}}</td>
               
            </tr>
			  <tr>
                <th>SIGNATURE OF THE STUDENT</th>
                <td></td>
               
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
@foreach($user->TeamEvents() as $event)
	<center><h1>MEPCO SCHLENK ENGINEERING COLLEGE, SIVAKASI</h1></center>
	<center><h3>(An Autonomous Institution)</h3></center>
	<center><h4>Fiesta 18</h4></center>
		
			<p class="header text-uppercase">{{ $event->title }}</p>
			<ul class="browser-default">
				@foreach($event->getRulesList() as $rule)
					<li>{!! $rule !!}</li>
				@endforeach  
			</ul>
			@foreach($event->teams->where('user_id',$user->id) as $team)			
			<p class="text-uppercase header">Team Details
			TEAM NAME:{{ $team->name }}</p>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>S.No</th>
						<th>RollNo</th>
						<th>Name</th>
						<th>Email</th>
						<th>Gender</th>
						<th>Signature</th>
                    
					</tr>
				</thead>
				<tbody>
						<tr>
							<td>0</td>
							<td>{{$user->roll_no}}</td>
							<td>{{$user->full_name}}</td>
							<td>{{$user->email}}</td>
							<td>{{$user->gender}}</td>
							<td></td>
						
						</tr>
					@foreach($team->teamMembers as $index => $teamMember)
						<tr>
							<td>{{ $index + 1 }}</td>
							<td>{{ $teamMember->user->roll_no }}</td>
							<td>{{ $teamMember->user->full_name }}</td>
							<td>{{ $teamMember->user->email }}</td>
							<td>{{ $teamMember->user->gender }}</td>
							<td></td>
                        
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
                Signature of {{$event->staff_incharge}}
            </p>
        </div>
    </div>
	  <div class="page-break"></div>
	@endforeach
    @endif
</body>
</html>