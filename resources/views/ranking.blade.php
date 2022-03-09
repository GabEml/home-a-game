@extends('layouts.main')

@section('title', 'Classement')

@section('titlePage',"Classement")

@section('description', "Classement de la session en cours pour @ Home a Game Votre mission: relever un max de défis. Votre objectif: battre les autres et tenter de gagner un voyage.")

@section ('content')

@if ($session==null)
@else
    <h2 class="titleProfile title">{{$session->name}} du {{$session->start_date}} au {{$session->end_date}}</h2>
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
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{$position=$position+1}}</th>
                    <td>{{$user->firstname}} {{$user->lastname}}</td>
                    @if ($user->points == NULL)
                      <td>0</td>
                    @else
                      <td>{{$user->points}}</td>
                    @endif
                </tr>
            @endforeach
           @endif
        </tbody>
      </table>
</div>

<br/>

<div class="row">
  <div class="col-12 text-center">
      @auth
          @if (Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin")
              <div>
                  <a class="btn btn-info" href="{{route('ranking.create')}}">Tirage au sort</a>
              </div>
          @endif
      @endif
  </div>
</div>

<div class="row">
  <div class="col-12 text-center">
    <div>
      <h2 class="titleProfile title">Voir le classement des sessions précédentes</h2>
      <br/>
      <div class="col-12 table-responsive">
        @if(!count($sessiongames))
          <p class="text-center">Il n'y a pas encore d'anciens classements !</p>
        @else
          <table class="table-bordered table-hover align-middle table tableGoodie">
            <tbody>
            @if($sessionCurrent->id != $session->id)
                <td>
                    <strong>Session actuelle :</strong> {{$sessionCurrent->name}} du {{$sessionCurrent->start_date}} au {{$sessionCurrent->end_date}}
                </td>
                <td class="text-center">
                    <a class="btn btn-info" href="{{route('ranking')}}"> Voir </a>
                </td>
            @endif
              @foreach ($sessiongames as $sessiongame)
                @if($sessiongame->id != $session->id and $sessiongame->id !=$sessionCurrent->id)
                  <tr>
                    <td>
                      {{$sessiongame->name}} du {{$sessiongame->start_date}} au {{$sessiongame->end_date}}
                    </td>
                    <td class="text-center">
                      <a class="btn btn-info" href="{{route('ranking.previous',$sessiongame->id)}}"> Voir </a>
                    </td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
</div>

<br/>
@endsection
