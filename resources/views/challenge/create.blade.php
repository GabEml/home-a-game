@extends('layouts.main')

@section('title', 'Ajouter un défi')

@section('titlePage',"Ajouter un défi")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('sessiongames.challenges.store',$sessiongame->id) }}" method="post"  enctype="multipart/form-data">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>
           
            <div class="form-group">
                <label for="title" >Titre</label>
                <input value="{{ old('title') }}" autocomplete="title" required type="text" class="form-control" name="title" class=@error('title') is-invalid @enderror />
            </div>
            
            <div class="form-group">
                <label for="points">Nombres de points</label>
                <input value="{{ old('points') }}" type="number" name="points" id="points" class="form-control" class=@error('points') is-invalid @enderror >
            </div>

            <div class="form-check form-check-inline flex justify-content-center ">
                <input class="form-check-input" type="checkbox" value="1" name="unlimited_points" class=@error('unlimited_points') is-invalid @enderror>
                <label class="form-check-label" for="flexCheckDefault">
                    Points illimités
                </label>
            </div>

            <br/>
            
            <div class="form-group">
                <label for='type_of_file'> Type de post accepté</label>
                <br/>
                    <select value="{{ old('type_of_file') }}" class="form-control" name='type_of_file' class=@error('type_of_file') is-invalid @enderror>
                        <option value="picture"> Photo </option>
                        <option value="video"> Vidéo </option>
                        <option value="both"> Les deux </option>
                    </select>
            </div>

            <label for='filenames'> Images (max 100Mo)</label>
            <div class="form-group input-group control-group increment flex justify-content-between">
                <input type="file" name="filenames[]" class=@error('filename') is-invalid @enderror>
                <div > 
                    <button class="btn btn-success addFile" type="button"> + Ajouter</button>
                </div>
            </div>
            <div class="clone hidden ">
                 <div class="control-group input-group flex justify-content-between" style="margin-top:10px">
                    <input type="file" name="filenames[]" >
                    <div class="input-group-btn"> 
                        <button class="btn btn-danger deleteFile" type="button"> X Supprimer</button>
                    </div>
                </div>
            </div>
            <small> Vous pouvez choisir autant d'images que vous le souhaitez</small>

            <br/><br/>
            
            <div class="form-check form-check-inline flex justify-content-center ">
                <input class="form-check-input" type="checkbox" value="1" name="editable" class=@error('editable') is-invalid @enderror>
                <label class="form-check-label" for="flexCheckDefault">
                    Ce défi peut être réalisé plusieurs fois
                </label>
            </div>
       </fieldset>
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
       <div class="flex justify-content-between">
        <a class="btn btn-primary" href="{{route('sessiongames.show',$sessiongame->id)}}"> Retour </a>
        <button type="submit" class="btn btn-info ">Ajouter</button>
        

       </div>
    </form>
</div>


@endsection

