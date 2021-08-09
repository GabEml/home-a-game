@extends('layouts.main')

@section('title', 'Ajouter un goodie')

@section('titlePage',"Ajouter un goodie")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('goodies.store') }}" method="post" enctype="multipart/form-data">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>
           
            <div class="form-group">
                <label for="name" >Nom</label>
                <input value="{{ old('name') }}" type="text" required class="form-control" name="name" id="name" class=@error('name') is-invalid @enderror placeholder="Titre" />
            </div>
            
            <div class="form-group">
                <label for="image_path" >Image (max 100Mo)</label>
                <br/>
                <input type="file" name="image_path" required class=@error('image_path') is-invalid @enderror>
            </div>
            
       </fieldset>
       @error('name')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
       @error('image_path')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
       <br/>
       <div class="flex justify-content-between">
        <a class="btn btn-primary" href="{{route('goodies.index')}}"> Retour </a>
        <button type="submit" class="btn btn-info ">Ajouter</button>
        

       </div>
    </form>
</div>

@endsection