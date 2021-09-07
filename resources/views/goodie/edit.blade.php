@extends('layouts.main')

@section('title', 'Modifier un goodie')

@section('titlePage',"Modifier un goodie")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{route('goodies.update',$goodie->id)}}" method="post" enctype="multipart/form-data">
        <!-- Add CSRF Token -->
        @csrf
        @method('PUT')
       <fieldset>
           
            <div class="form-group">
                <label for="name" >Nom</label>
                <input type="text" value="{{$goodie->name}}" required class="form-control" name="name" id="name" class=@error('name') is-invalid @enderror placeholder="Titre" />
            </div>
            
            <div class="form-group">
                <label for="image_path" >Image (max 100Mo)</label>
                <br/>
                <input type="file" class="form-control-file" name="image_path" class=@error('image_path') is-invalid @enderror>
                <br/>
                <small>Si vous ne choissisez pas d'image, il garde celle déjà existante</small>
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
        <button type="submit" class="btn btn-info ">Modifier</button>
        

       </div>
    </form>
</div>

@endsection
