@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="section">
            <h5 class="center"><i class="fas fa-chess-king"></i>VOTES</h5>
        </div>
        <div class="divider"></div>
        <div class="divider"></div>
        <table class="highlight responsive-table bordered centered">
            <thead>
            <tr>
              <th>PHOTO ID</th>
              <th>VOTES</th>
            </tr>
            </thead>
        <tbody>
        @foreach($votes as $index => $vote)
        <tr>
            <td>{{$index}}</td>
            <td>{{$vote->count()}}</td>
        </tr>
         @endforeach            
        </tbody>
        </table>
    </div>
</div>


@endsection