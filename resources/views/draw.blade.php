@extends('layouts.main')

@section('title', 'Tirage au sort')

@section('titlePage',"Tirage au sort")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('ranking.store') }}" method="post" class="">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>
        @if ($sessiongames->isEmpty())
        <div class="flex justify-content-center flex-column">
            <div><p class="price text-center">Aucunes sessions terminée pour le moment</p></div>
        </div>
        @else
        <div class="flex justify-content-center flex-column ">
            <p class="sessions text-center">Choissisez les sessions à selectionner pour le tirage au sort</p>
        </div>
        @foreach ($sessiongames as $sessiongame)
            <div class="form-check form-check-inline flex justify-content-center ">
                <input class="form-check-input" type="checkbox" value="{{$sessiongame->id}}" name="sessiongames[]" class=@error('session') is-invalid @enderror>
                <label class="form-check-label" for="flexCheckDefault">
                    {{$sessiongame->name}} du {{$sessiongame->start_date}} au {{$sessiongame->end_date}}
                </label>
            </div>
        @endforeach
        
       </fieldset>
       @error('session')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
       <br/>
       <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info ">Tirer au sort</button>
            </div>
       </div>
       @endif
        

       </div>
    </form>
</div>

<div class="row">
    <div class="col-12 text-center">
        @if ($winner!=="") 
            <div class="flex justify-content-center flex-column">
                <div><p class="price text-center"> Le/La grand(e) gagnant(e) est {{$winner}}</p></div>
            </div>
        @endif
    </div>
  </div>

<br/>
@endsection