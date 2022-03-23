@extends('layouts.main')

@section('title', 'Utilisateurs - Admin défis')

@section('titlePage',"Gestion des utilisateurs")

@section ('content')

<div class="row">
    <div class=" menuValidation col-12 justify-content-center flex">
        <a href ="{{ route('users.indexUsers') }}" class=" menuValidation buttonPending "> Utilisateurs </a>
        <a href ="{{ route('users.indexAdminChallenge') }}" class=" menuValidation buttonValidated buttonActive" > Admins défis</a>
        <a href ="{{ route('users.indexSuperAdmin') }}" class=" menuValidation buttonValidated " > Super admins</a>
        <a href ="{{ route('users.indexListUsers') }}" class=" menuValidation buttonValidated" > Liste</a>
    </div>
</div>

<br/><br/>

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('users.store') }}" method="post" class="">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>
        @if ($users->isEmpty())
        <div class="flex justify-content-center flex-column">
            <div><p class="price text-center">Il n'y a aucun utilisateurs !</p></div>
        </div>
        @else
        <div class="flex justify-content-center flex-column ">
            <p class="sessions text-center">Choississez un utilisateur a modifier</p>
        </div>
        <br/>

        <div class="form-group">
                <br/>
                <select class="form-control" name='user' id='user' class="form-control"class=@error('user') is-invalid @enderror>
                    @foreach ($users as $user)
                        <option value={{$user->id}}> {{$user->firstname}} {{$user->lastname}}</option>
                    @endforeach
                </select>
        </div>
        
       </fieldset>
       @error('user')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
       <br/>
       <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info ">Modifier</button>
            </div>
       </div>
       @endif

       </div>
    </form>
</div>

<br/>

<div class="row">
    <div class="col-12 text-center">
            <div>
                <a class="btn btn-info" href="{{route('users.create')}}"> Ajouter un utilisateur</a>
            </div>
    </div>
</div>

<br/>

@endsection