@extends('layouts.main')

@section('title', 'Goodies')

@section('titlePage',"Goodies")

@section ('content')

<div class="row containerArticles">
    @auth
    @if ($goodies->isEmpty())
        <div class="flex justify-content-center flex-column">
            <div><p class="price text-center">Aucuns goodies pour le moment !!</p></div>
        </div>
    @else

    @foreach ($goodies as $goodie)
        <div class=" flex flex-col marginArticles col-lg-3 col-md-6 col-sm-12 containerPresentation justify-content-between">
            <div class="flex flex-col">
                <img width="280px" class="align-self-center imagePresentation" src="{{$goodie->image_path}}" alt="{{$goodie->title}}">
            </div>
            <div>
                <div class="flex flex-col">
                    <h2 class="align-self-center titleSession">{{$goodie->name}}</h2>
                    <br/>
                    <div>
                        @if (Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin")
                            <div class="flex justify-content-around">
                                <form action="{{route('goodies.destroy',$goodie->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="buttonAdmin btn btn-danger" type="submit"> Supprimer </button>
                                </form>
                                <a class="btn buttonAdmin btn-success " href="{{route('goodies.edit',$goodie->id)}}"> Modifier</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endif
</div>

    <div class="row">
        <div class="col-12 text-center">
                @if (Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin")
                <div>
                    <a class="btn btn-info" href="{{route('goodies.create')}}"> Ajouter un goodie</a>
                </div>
                @endif
        </div>
    </div>
@endif

<br/><br/>

@endsection
