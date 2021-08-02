@extends('layouts.main')

@section('title', 'Liste de vos défis')

@section('titlePage', 'Liste de vos défis') 

@section ('content')



    <div class="col-12">
       <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('sessiongames.index') }}">Espace Jeu</a></li>
                <li class="breadcrumb-item active">Session du {{$sessiongame->start_date}} au {{$sessiongame->end_date}}</li>
                
            </ol>
       </nav>
    </div>
       <!--End Breadcrumb-->
       <div class="row containerArticles">
          @foreach ($sessiongame->challenges as $challenge)
              <div class="positionButton marginArticles col-lg-3 col-md-6 col-sm-12 containerPresentation">
                  <div class="flex flex-col justify-content-center">
                      <img width="220px" height=auto class="align-self-center imagePresentation" src="{{$challenge->images[0]->image_path}}" alt="{{$challenge->title}}">
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
                    </div>
                <br/>
                  
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
          @endforeach
      </div>

@auth
    @if (Auth::user()->role->role==="Admin Défis")
        <div class="flex justify-content-between">
            <div class="">
                        <a class="btn btn-primary" href="{{route('sessiongames.index')}}"> Retour</a>
            </div>
            <div class="text-center">
                
                    <div>
                        <a class="btn btn-info" href="{{route('sessiongames.challenges.create',$sessiongame->id)}}"> Ajouter un défi</a>
                    </div>
            </div>
            <div class="">
                <a class="btnHidden btn btn-primary"> Retour</a>
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