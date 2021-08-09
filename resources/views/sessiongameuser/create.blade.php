@extends('layouts.main')

@section('title', "S'inscrire à une session")

@section('titlePage',"S'inscrire à une session")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('sessiongameusers.store') }}" method="post" class="">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>
        @if ($sessiongames->isEmpty())
        <div class="flex justify-content-center flex-column">
            <div><p class="price text-center">Vous êtes déjà inscrit à toutes les prochaines sessions !</p></div>
        </div>
        @else
        <div class="flex justify-content-center flex-column ">
            <p class="sessions text-center">A quelle(s) session(s) voulez-vous participer ?</p>
            <p class="price text-center" >Chaque session coûte 40€</p>
        </div>
        <br/>
        @foreach ($sessiongames as $sessiongame)
            <div class="form-check form-check-inline flex justify-content-center ">
                <input class="form-check-input" type="checkbox" value="{{$sessiongame->id}}" name="sessiongames[]" class=@error('session') is-invalid @enderror>
                <label class="form-check-label" for="flexCheckDefault">
                Session du {{$sessiongame->start_date}} au {{$sessiongame->end_date}}
                </label>
            </div>
        @endforeach
        
       </fieldset>
       @error('session')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
       <br/>
       <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info ">Ajouter</button>
            </div>
       </div>
       @endif
        

       </div>
    </form>
</div>

@endsection