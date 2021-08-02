@extends('layouts.main')

@section('title', 'Modifier un article')

@section('titlePage',"Modifier un article")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{route('articles.update',$article->id)}}" method="post" enctype="multipart/form-data">
        <!-- Add CSRF Token -->
        @csrf
        @method('PUT')
       <fieldset>
           
            <div class="form-group">
                <label for="title" >Titre</label>
                <input type="text" value="{{$article->title}}" required class="form-control" name="title" id="title" class=@error('title') is-invalid @enderror placeholder="Titre" />
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea required name="description" id="description" rows="8" class="form-control"class=@error('description') is-invalid @enderror > {{$article->description}} </textarea>
            </div>
            
            <div class="form-group">
                <label for="image_path" >Image</label>
                <br/>
                <input type="file" name="image_path" class=@error('image_path') is-invalid @enderror>
                <br/>
                <small>Si vous ne choissisez pas d'image, il garde celle déjà existante</small>
            </div>
            
       </fieldset>
       @error('title')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
        @error('description')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
       @error('image_path')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
       <br/>
       <div class="flex justify-content-between">
        <a class="btn btn-primary" href="{{route('articles.index')}}"> Retour </a>
        <button type="submit" class="btn btn-info ">Modifier</button>
        

       </div>
    </form>
</div>

@endsection
