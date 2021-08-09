@extends('layouts.main')

@section('title', 'Liste de vos défis')

@section('titlePage', 'Liste de vos défis') 

@section ('content')



    <div class="col-12">
       <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('sessiongames.index') }}">Espace Jeu</a></li>
                <li class="breadcrumb-item active">Session {{$sessiongame->name}}</li>
                
            </ol>
       </nav>
    </div>

    <br/>

    <div class='col-12'>
        <p class="text-center">{{$sessiongame->description}}</p>
        <p class="text-center">Pour cette session, vous pouvez avoir la chance de gagner : {{$sessiongame->goodie->name}} !</p>
    </div>
    <br/>

       <!--End Breadcrumb-->
       <div class="row containerArticles">
          @foreach ($sessiongame->challenges as $challenge)
              <div class="flex flex-col positionButton marginArticles col-lg-3 col-md-6 col-sm-12 containerPresentation justify-content-between">
                  <div class="flex flex-col">
                      <img width="220px" height=auto class="align-self-center imagePresentation" src="{{$challenge->images[0]->image_path}}" alt="{{$challenge->title}}">
                  </div>
                  <div>
                      <h2 class="align-self-center text-center titleArticleHome">{{$challenge->title}}</h2>
                      @foreach ($challenge->posts as $post)
                            @if($post->user->id == Auth::user()->id)
                                @if($post->state =="pending")
                                    <p class="status align-self-center"> Statut : En attente </p>
                                @elseif($post->state =="not_validated")
                                    <p class="status align-self-center"> Statut :Non validé </p>
                                @elseif($post->state =="partly_validated")
                                    <p class="status align-self-center">Statut : Partiellement validé </p>
                                @else
                                    <p class="status align-self-center">Statut : Validé </p>
                                @endif
                            @endif

                        @endforeach
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
                            <a class="btn seeMore" href="{{route('challenges.show',$challenge->id)}}"> Voir</a>
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