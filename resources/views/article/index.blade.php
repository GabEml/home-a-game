@extends('layouts.main')

@section('title', 'Articles')

@section('titlePage',"Articles")

@section ('content')

<div class="row containerArticles">
    @if ($articles->isEmpty())
    <div class="flex justify-content-center flex-column">
        <div><p class="price text-center">Aucun article pour le moment !</p></div>
    </div>
    @else
    @foreach ($articles as $article)
            <div class="positionButton marginArticles col-lg-3 col-md-6 col-sm-12 containerPresentation">
                <div class="flex flex-col justify-content-center">
                    <img width="280px" height=auto class="align-self-center imagePresentation" src="{{$article->image_path}}" alt="{{$article->title}}">
                    <h2 class="align-self-center titleArticleHome">{{$article->title}}</h2>
                </div>
                <br/>
                <p>{{\Illuminate\Support\Str::limit($article->description, 100)}}</p>
                <br/>
                @auth
                    @if (Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin")
                        <div class="flex justify-content-around">
                            <form action="{{route('articles.destroy',$article->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="buttonAdmin btn btn-danger" type="submit"> Supprimer </button>
                            </form>
                            <a class="btn buttonAdmin btn-success " href="{{route('articles.edit',$article->id)}}"> Modifier</a>
                            <a class="btn buttonAdmin seeAdmin" href="{{route('articles.show',$article->id)}}"> Voir</a>
                        </div>
                    @else
                    <div>
                        <a class="btn seeMore" href="{{route('articles.show',$article->id)}}"> En savoir plus</a>
                    </div>
                    @endif
                @else 
                <div>
                    <a class="btn seeMore" href="{{route('articles.show',$article->id)}}"> En savoir plus</a>
                </div>
                @endif
            </div>
    @endforeach
    @endif
</div>
    <div class="row">
        <div class="col-12 text-center">
            @auth
                @if (Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin")
                <div>
                    <a class="btn btn-info" href="{{route('articles.create')}}"> Ajouter un article</a>
                </div>
                @endif
            @endif
        </div>
    </div>

<br/><br/>

@endsection