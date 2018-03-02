@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col offset-m2 m8 s12">
        @include('partials.errors')
        <div class="card z-depth-4 rounded-box">
            <div class="card-content">
                <div class="card-title center-align">
                    PIXIE VOTE
                </div>
                {!! Form::open(['url' => route('admin::votes')]) !!}
                    <div class="input-field">
                        {!! Form::label('roll_no') !!}
                        {!! Form::text('roll_no') !!}                        
                    </div>
                    <div class="input-field">
                        {!! Form::label('photo_id') !!}
                        {!! Form::text('photo_id') !!}                        
                    </div>
                    <div class="input-field">
                        {!! Form::submit('VOTE', ['class' => 'btn waves-effect waves-light green pulse']) !!}                        
                    </div>
                {!! Form::close() !!}
              
            </div>
        </div>
    </div>
</div>
<div class="fixed-action-btn vertical centereds click-to-toggle">
    <a class="btn-floating btn-large red">
      <i class="material-icons">menu</i>
    </a>
    <ul>
      <li><a class="btn-floating red"  href="{{ route('admin::vote_result') }}" ><i class="material-icons">insert_chart</i></a></li>
    </ul>
</div>
@endsection