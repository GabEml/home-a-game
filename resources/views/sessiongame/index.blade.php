@extends('layouts.main')

@section('title', 'Espace Jeu')

@section('titlePage',"Espace Jeu")

@section ('content')

<div class="row containerArticles">
    @if (Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin")
        @foreach ($sessiongames as $sessiongame)
                <div class=" flex flex-col marginArticles col-lg-3 col-md-6 col-sm-12 containerPresentation justify-content-between">
                    <div class="flex flex-col">
                        <img width="280px" class="align-self-center imagePresentation" src="{{$sessiongame->image_path}}" alt="{{$sessiongame->title}}">
                    </div>
                    <div>
                        <div class="flex flex-col">
                            <h2 class="align-self-center titleSession">{{$sessiongame->name}}</h2>
                            <br/>
                            <p class="align-self-center" >{{$sessiongame->start_date}} au {{$sessiongame->end_date}}</p>
                        </div>
                    <br/>
                        <div class="flex justify-content-around">
                                <form action="{{route('sessiongames.destroy',$sessiongame->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="buttonAdmin btn btn-danger" type="submit"> Supprimer </button>
                                </form>
                                <a class="btn buttonAdmin btn-success " href="{{route('sessiongames.edit',$sessiongame->id)}}"> Modifier</a>
                                <a class="btn buttonAdmin seeAdmin" href="{{route('sessiongames.show',$sessiongame->id)}}"> Voir</a>
                        </div>
                    </div>
                </div>
        @endforeach

    @else 
    <div class='col-12'>
        <p class="text-center">Voici la liste des sessions où vous êtes inscrit, vous ne pouvez accéder qu'à la session en cours</p>
    </div>
    <br/><br/><br/>
    {{-- Session en cours --}}
    @foreach ($sessiongamesUserNow as $sessiongame)
        <div class=" flex flex-col marginArticles col-lg-3 col-md-6 col-sm-12 containerPresentation justify-content-between">
            <div class="flex flex-col">
                <img width="280px" class="align-self-center imagePresentation" src="{{$sessiongame->image_path}}" alt="{{$sessiongame->title}}">
            </div>
        <div>
        <div class="flex flex-col">
            <h2 class="align-self-center titleSession">{{$sessiongame->name}}</h2>
            <br/>
            <p class="align-self-center" >{{$sessiongame->start_date}} au {{$sessiongame->end_date}}</p>
            <br/>
            @php
            $challengeCompleted=0
            @endphp
            @foreach ($sessiongame->challenges as $challenge)
                @foreach ($challenge->posts as $post)
                    @if($post->user->id == Auth::user()->id)
                        @php
                            $challengeCompleted =$challengeCompleted+1
                        @endphp
                    @endif
                @endforeach
            @endforeach
            <p class="align-self-center" >Défis réalisés : {{$challengeCompleted}} sur {{$sessiongame->challenges->count()}}</p>
            <br/>
            @if($sessiongame->end_date<$dateNow)
                <p class="statusSessiongame align-self-center text-danger "> Terminée</p>
            @elseif($sessiongame->start_date<=$dateNow and $sessiongame->end_date>=$dateNow)
                <p class="statusSessiongame align-self-center text-success"> En cours</p>
            @else
                <p class="statusSessiongame align-self-center text-info "> Prochainement..</p>
            @endif
        </div>
                <br/>
                    <div>
                        @if($sessiongame->start_date<=$dateNow and $sessiongame->end_date>=$dateNow or $sessiongame->end_date<=$dateNow)
                        <a class="btn seeMore" href="{{route('sessiongames.show',$sessiongame->id)}}"> Voir</a>
                        @else
                        <a class="btn seeMore disabled" href="{{route('sessiongames.show',$sessiongame->id)}}"> Voir</a>

                        @endif
                    </div>
            </div>
        </div>
    @endforeach

    {{-- Sessions futures et passées --}}
        @foreach ($sessiongamesUser as $sessiongame)
        <div class=" flex flex-col marginArticles col-lg-3 col-md-6 col-sm-12 containerPresentation justify-content-between">
            <div class="flex flex-col">
                <img width="280px" class="align-self-center imagePresentation" src="{{$sessiongame->image_path}}" alt="{{$sessiongame->title}}">
            </div>
            <div>
            <div class="flex flex-col">
                <h2 class="align-self-center titleSession">{{$sessiongame->name}}</h2>
                <br/>
                <p class="align-self-center" >{{$sessiongame->start_date}} au {{$sessiongame->end_date}}</p>
                <br/>
                @php
                $challengeCompleted=0
                @endphp
                @foreach ($sessiongame->challenges as $challenge)
                    @foreach ($challenge->posts as $post)
                        @if($post->user->id == Auth::user()->id)
                            @php
                                $challengeCompleted =$challengeCompleted+1
                            @endphp
                        @endif
                    @endforeach
                @endforeach
                <p class="align-self-center" >Défis réalisés : {{$challengeCompleted}} sur {{$sessiongame->challenges->count()}}</p>
                <br/>
                @if($sessiongame->end_date<$dateNow)
                    <p class="statusSessiongame align-self-center text-danger "> Terminée</p>
                @elseif($sessiongame->start_date<=$dateNow and $sessiongame->end_date>=$dateNow)
                    <p class="statusSessiongame align-self-center text-success"> En cours</p>
                @else
                    <p class="statusSessiongame align-self-center text-info "> Prochainement..</p>
                @endif
            </div>
                    <br/>
                        <div>
                            @if($sessiongame->start_date<=$dateNow and $sessiongame->end_date>=$dateNow or $sessiongame->end_date<=$dateNow)
                            <a class="btn seeMore" href="{{route('sessiongames.show',$sessiongame->id)}}"> Voir</a>
                            @else
                            <a class="btn seeMore disabled" href="{{route('sessiongames.show',$sessiongame->id)}}"> Voir</a>

                            @endif
                        </div>
                </div>
            </div>
        @endforeach
    @endif

</div>
    <div class="row">
        <div class="col-12 text-center">
            @auth
                @if (Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin")
                <div>
                    <a class="btn btn-info" href="{{route('sessiongames.create')}}"> Ajouter une session</a>
                </div>
                @endif
            @endif
        </div>
    </div>



<br/><br/>

@endsection