@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col s12">
        <p class="flow-text">{{ $users_count }} results <i class="fa fa-users"></i></p>                
        @if($users->count() == 0)
            <h5><i class="fa fa-check-circle"></i> Nothing to show!</h5>            
        @else
            <table>
                <thead>
                    <tr>
                        <th>
                            Fiesta ID
                        </th>
                        <th>
                            Full Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Department
                        </th>
                        <th>
                            Year
                        </th>
                        <th>
                            Section
                        </th>
                        <th>
                            Gender
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->F18Id() }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->department->name }}</td>
                            <td>{{ $user->year->name }}</td>
                            <td>{{ $user->section->name }}</td>
                            <td>{{ $user->gender }}</td>                              
           
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
<div class="row">
    <div class="col s12">
        {{ $users->appends(Request::capture()->except('page'))->render() }}        
    </div>
</div>

@endsection