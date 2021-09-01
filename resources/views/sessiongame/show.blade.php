@extends('layouts.main')

@section('title', 'Liste de vos défis')

@section('titlePage', 'Liste de vos défis') 

@section ('content')



    <div class="col-12">
       <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('sessiongames.index') }}">Espace Jeu</a></li>
                <li class="breadcrumb-item active">{{$sessiongame->name}}</li>
                
            </ol>
       </nav>
    </div>

    <br/>

    <div class='col-12'>
        <p class="text-center">{{$sessiongame->description}}</p>
        <p class="text-center">Pour cette session, vous pouvez avoir la chance de gagner : {{$sessiongame->goodie->name}} !</p>
        @if ($users==null)
        <p class="text-center">Vous avez pour le moment 0 point, vous êtes dernier du classement !</p>
        @else
          @foreach ($users as $user)
            @php
                $position=$position+1
            @endphp
            @if($user->id == Auth::user()->id)
                <p class="text-center">Vous avez pour le moment {{$user->points}} points, vous êtes {{$position}} du classement !</p>
                @break
            @endif
            @endforeach
         @endif
    </div>
    <br/>

       <!--End Breadcrumb-->
       <div class="row containerArticles">
          @foreach ($sessiongame->challenges as $challenge)
              <div class="flex flex-col positionButton marginArticles col-lg-3 col-md-6 col-sm-12 containerChallenge containerPresentation justify-content-between">
                  <div class="flex flex-col">
                        <div class="containerTitleChallenge">
                            <h2 class="align-self-center text-center">{{$challenge->title}}</h2>
                        </div>
                        {{-- <div class="roundTop"> </div> --}}
                        <img width="220px" height=auto class="align-self-center imagePresentation" src="{{$challenge->images[0]->image_path}}" alt="{{$challenge->title}}">
                        @if ($challenge->unlimited_points ==1)
                        <h2 class="align-self-center text-center titleArticleHome">Points illimités</h2>
                        @else
                            <h2 class="align-self-center text-center titleArticleHome">{{$challenge->points}} points</h2>
                        @endif
                        
                    </div>
                  <div>
                    
                      <div class="result">
                      @foreach ($challenge->posts as $post)
                            @if($post->user->id == Auth::user()->id)
                                @if($post->state =="pending")
                                    <p class="status text-center"> Statut : En attente </p>
                                @elseif($post->state =="not_validated")
                                    <p class="status text-center"> Statut :Non validé </p>
                                    <p class="status text-center"> Score obtenu : {{$post->user_point}} points </p>
                                @elseif($post->state =="partly_validated")
                                    <p class="status text-center">Statut : Partiellement validé </p>
                                    <p class="status text-center"> Score obtenu : {{$post->user_point}} points</p>
                                @else
                                    <p class="status text-center">Statut : Validé </p>
                                    <p class="status text-center"> Score obtenu : {{$post->user_point}} points</p>
                                @endif
                            @endif

                        @endforeach
                    </div>
                <br/>
                    <div>
                        @if (Auth::user()->role->role==="Admin Défis")
                            <div class="flex justify-content-around">
                                <form action="{{route('challenges.destroy',$challenge->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="buttonAdmin btn btn-danger" type="submit"> Supprimer </button>
                                </form>
                                <a class="btn buttonAdmin btn-success " href="{{route('challenges.edit',$challenge->id)}}"> Modifier</a>

                            </div>
                        @else
                        <div>
                            <a class="btn seeMore seeMoreChallenge" href="{{route('challenges.show',$challenge->id)}}"> Voir</a>
                        </div>
                        @endif
                    </div>
                </div>
              </div>
          @endforeach
      </div>

@auth
    @if (Auth::user()->role->role==="Admin Défis")
        
        <div class="flex col-12 justify-content-between  btnChallengeAdmin">
            <div class="flex ">
                <a class="btn btn-primary" href="{{route('sessiongames.index')}}"> Retour</a>
            </div>
            <div>
                <a class="btn btn-info" href="{{route('sessiongames.challenges.create',$sessiongame->id)}}"> Ajouter un défi</a>
            </div>
        </div>


    @elseif (Auth::user()->role->role==="User")
    <div class="row">
        <div class="col-12 text-center">
                <div>
                    <a class="btn btn-info" href="{{route('sessiongames.index')}}"> Retour</a>
                </div>
        </div>
    </div>
    @endif
@endif
<br/>


@endsection