<ul class="collection with-header">
    <li class="collection-header"><h5>Student Details</h5></li>
    <li class="collection-item">
        <table>
            <tbody>
                <tr>
                    <th>Fiesta18 ID</th>
                    <td>{{ $user->F18Id() }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->full_name }}</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>{{ $user->department->name }}</td>
                </tr>
                <tr>
                    <th>Year</th>
                    <td>{{ $user->year->name }}</td>
                </tr>

                <tr>
                    <th>Section</th>
                    <td>{{ $user->section->name }}</td>
                </tr>

                <tr>
                    <th>Registration Confimation</th>
                    <td>
                        @if($user->hasConfirmed())
                            <span class="green-text">Confirmed</span>
                        @else
                            <span class="red-text">Not Confimed</span>
                        @endif
                    </td>
                </tr>
                @if($user->confirmation)
                    <tr>
                        <th>Registration Request</th>
                        <td>
                            @if($user->confirmation->status == 'ack')
                                <span class="green-text">Accepted</span>
                            @elseif($user->confirmation->status == 'nack')
                                <span class="red-text">Rejected</span>    
                            @else
                                Yet to be acknowledged
                            @endif
                        </td>
                    </tr>
                @endif
                
            </tbody>
        </table>
    </li>
</ul>
@if($user->events()->count())
    <ul class="collection with-header">
        <li class="collection-header">
            <h5>Events Details</h5>                            
        </li>
        @foreach($user->events as $event)
            <li class="collection-item">
                {{ $event->title }}
            </li>
        @endforeach
    </ul>
@endif
@if($user->teams()->count() > 0 || $user->teamMembers()->count() > 0)
    <ul class="collection with-header">
        <li class="collection-header">
            <h5>Teams Details</h5>
        </li>
        @foreach($user->teams as $team)
            <li class="collection-item">
                <p>
                    <strong>{{ $team->events->first()->title }}</strong>                         
                </p>
                <p>
                    @include('partials.team_details', ['team' => $team])
                </p>
            </li>
        @endforeach
        @foreach($user->teamMembers as $teamMember)
            <li class="collection-item">
                <p>
                    <strong>{{ $teamMember->team->events->first()->title }}</strong>                         
                </p>
                <p>
                    @include('partials.team_details', ['team' => $teamMember->team])
                </p>
            </li>
        @endforeach
    </ul>
@endif