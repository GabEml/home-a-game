@extends('layouts.main')

@section('title', 'Ajouter un article')

@section('titlePage',"Ajouter un article")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>
           
            <div class="form-group">
                <label for="title" >Titre</label>
                <input value="{{ old('title') }}" type="text" required class="form-control" name="title" id="title" class=@error('title') is-invalid @enderror placeholder="Titre" />
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea value="{{ old('description') }}" required name="description" id="description" rows="8" class="form-control"class=@error('description') is-invalid @enderror >{{ old('description') }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="image_path" >Image (max 100Mo)</label>
                <br/>
                <input type="file" name="image_path" required class=@error('image_path') is-invalid @enderror>
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
        <button type="submit" class="btn btn-info ">Ajouter</button>
        

       </div>
    </form>
</div>

@endsection