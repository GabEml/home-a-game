@extends('layouts.main')

@section('title', 'Classement')

@section('description', "Classement de la session en cours pour @ Home a Game Votre mission: relever un max de défis. Votre objectif: battre les autres et tenter de gagner un voyage.")

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
    <h2 class="titleProfile title"> {{$session->name}} du {{$session->start_date}} au {{$session->end_date}}</h2>
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
              <div>
                <h2 class="titleProfile title">Voir le classement des sessions précédentes</h2>
                <br/>
                <div class=" col-12 table-responsive">
                  <table class="table-bordered table-hover align-middle table tableGoodie">
                      @foreach ($sessiongames as $sessiongame)
                          <tbody>
                            @if($sessiongame->id != $session->id and $sessiongame->id !=$sessionCurrent->id)
                              <tr>
                                  <td>
                                    {{$sessiongame->name}} du {{$sessiongame->start_date}} au {{$sessiongame->end_date}}
                                  </td>
                                  <td class="text-center"> 
                                      <a class="btn btn-info" href="{{route('rankingOTR.previous',$sessiongame->id)}}"> Voir </a>
                                  </td>
                              </tr>
                            @endif
                      @endforeach
                      @if($sessionCurrent->id != $session->id)
                        <td>
                          <strong>Session actuelle :</strong> {{$sessionCurrent->name}} du {{$sessionCurrent->start_date}} au {{$sessionCurrent->end_date}}
                        </td>
                        <td class="text-center"> 
                            <a class="btn btn-info" href="{{route('rankingOTR')}}"> Voir </a>
                        </td>
                      @endif
                    </tbody>
                  </table>
              </div>
              </div>
  </div>
</div>

<br/>
@endsection