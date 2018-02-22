@extends('layouts.default')

@section('content')

<div class="row">
    @foreach($events as $event)
        <div class="col m6 s12">
            @include('partials.event', ['event' => $event])
        </div>
    @endforeach
    @foreach($teamEvents as $event)
        <div class="col m6 s12">
            @include('partials.event', ['event' => $event])
        </div>
    @endforeach
</div>
@if($user->rejections()->count())
    <div class="row">
        <div class="col s12">
            <ul class="collection with-header z-depth-4">
                <li class="collection-header">
                    <strong>Your registrations for following events are rejected as maximum participants have already been confirmed</strong>
                </li>
                @foreach($user->rejections as $rejection)
                    <li class="collection-item">{{ $rejection->event->title }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div class="row">
    <ul class="stepper">
        <li class="step {{ $user->hasConfirmed()?'':'active' }}">
            <div class="step-title waves-effect waves-dark">Confirm Registration</div>
            <div class="step-content">
                <p>
                    <ul>
                        <li>
                            <p>
                                <i class="fa {{ $user->isParticipating()?'fa-check':'fa-times' }}"></i> Participate in atleast one single or team event
                            </p>
                            @if($user->hasOnlyTeamEvents())
                                <p>
                                    <i class="fa {{ $user->hasSureEvents()?'fa-check':'fa-times' }}"></i> Atleast one of your team leaders has confirmed your participation in their team
                                </p>
                            @endif
							<div class="card-panel red pulse white-text">
							<h5>ONCE CONFIRMED,YOU CAN'T ADD/MODIFY ANY EVENTS</h5></div>
                        </li>
                    </ul>
                </p>
                @if($user->isParticipating())
                    <p class="red-text">After clicking on confirm and generate ticket you wont be able to further add or remove any other events</p>
                @endif
                <a class="btn waves-effect waves-light green modal-trigger {{ ($user->hasConfirmed()|| !$user->canConfirm())?'disabled':'' }}" href="#modal-confirm">Confirm and generate ticket</a>
            </div>
        </li>
          
            <li class="step {{ ($user->hasConfirmed() && !$user->isConfirmed())?'active':'' }}">
                <div class="step-title waves-effect waves-dark">Registeration Form</div>
                <div class="step-content">
                <p>
                         <a class="btn waves-effect waves-light green {{ $user->hasConfirmed()?'':'disabled' }}" href="{{ route('pages.ticket.download') }}">Download Registration Form</a>
                    </p>
                </div>
            </li>
            
        
<div class="modal" id="modal-confirm">
    <div class="modal-content">
        <h4>Are you sure?</h4>
        <p>
            After confimration you wont be able to add or remove events from your wishlist!
        </p>
    </div>
    <div class="modal-footer">
        <a class="btn-flat waves-effect waves-red modal-action modal-close">No not now!</a>
        {{ link_to_route('pages.confirm', 'Got it!', null, ['class' => 'btn-flat waves-effect waves-green modal-action modal-close']) }}        
    </div>
</div>
<script>
    $('#btn-upload-ticket').on('click', function(){
        $('#file-ticket').trigger('click');
    });
    $('#file-ticket').on('change', function(){
        $('#form-upload-ticket').submit();
    });
</script>

@endsection