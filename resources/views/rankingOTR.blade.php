@extends('layouts.main')

@section('title', 'Classement')

@section('titlePage',"Classement")

@section ('content')

<div class="row">
  <div class=" menuValidation col-12 justify-content-center flex">
      <a href ="{{ route('ranking') }}" class=" menuValidation buttonPending ">@Home a Game </a>
      <a href ="{{ route('rankingOTR') }}" class=" menuValidation buttonValidated buttonActive" >On The Road a Game</a>
  </div>
</div>

@if ($session==null)
@else
    <h2 class="titleProfile title">Session {{$session->name}} du {{$session->start_date}} au {{$session->end_date}}</h2>
@endif

<br/><br/>

<div class="row">
    <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Position</th>
            <th scope="col">Nom</th>
            <th scope="col">Points</th>
          </tr>
        </thead>
        <tbody>
          @if ($users==null)
          @else
            @if($session->see_ranking==1)
              @foreach ($users as $user)
                  <tr>
                      <th scope="row">{{$position=$position+1}}</th>
                      <td>{{$user->firstname}} {{$user->lastname}}</td>
                      <td>{{$user->points}}</td>
                  </tr>
              @endforeach
              @else 
                  <td colspan="3" class="text-center"> Le classement n'est pas encore dévoilé !</td>
              @endif
           @endif
        </tbody>
      </table>
</div>

<br/>

<div class="row">
  <div class="col-12 text-center">
      @auth
          @if (Auth::user()->role->role==="Admin Défis")
              <div>
                  <a class="btn btn-info" href="{{route('winner_draw')}}">Tirage au sort</a>
              </div>
              <br/>
              @if ($winner!=="") 
                <div class="flex justify-content-center flex-column">
                    <div><p class="price text-center"> Le/La grand(e) gagnant(e) est {{$winner}}</p></div>
                </div>
              @endif
          @endif
      @endif
  </div>
</div>

<br/>
@endsection