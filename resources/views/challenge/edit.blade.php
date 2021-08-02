@extends('layouts.main')

@section('title', 'Modifier un défi')

@section('titlePage',"Modifier un défi")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('challenges.update',$challenge->id) }}" method="post"  enctype="multipart/form-data">
        <!-- Add CSRF Token -->
        @csrf
        @method('PUT')
       <fieldset>
           
            <div class="form-group">
                <label for="title" >Titre</label>
                <input value="{{$challenge->title }}" autocomplete="title" required type="text" class="form-control" name="title" class=@error('title') is-invalid @enderror />
            </div>
            
            <div class="form-group">
                <label for="points">Nombres de points</label>
                <input value="{{ $challenge->points }}" type="number" required name="points" id="points" class="form-control" class=@error('points') is-invalid @enderror >
            </div>
            
            <div class="form-group">
                <label for='type_of_file'> Type de post accepté</label>
                <br/>
                    <select value="{{ $challenge->type_of_file }}" class="form-control" name='type_of_file' class=@error('type_of_file') is-invalid @enderror>
                        @if($challenge->type_of_file =="picture")
                        <option value="picture" selected> Photo </option>
                        <option value="video"> Vidéo </option>
                        @else 
                        <option value="picture" > Photo </option>
                        <option value="video" selected> Vidéo </option>
                        @endif
                    </select>
            </div>

            <br/>

            <label for='filenames'> Images</label>
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

            <br/>
            
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
        <a class="btn btn-primary" href="{{route('sessiongames.show',$challenge->sessiongame->id)}}"> Retour </a>
        <button type="submit" class="btn btn-info ">Modifier</button>
        

       </div>
    </form>
</div>

<div class="contourForm col-12 col-md-6 offset-md-3">
    <div class="flex justify-content-center flex-column ">
        <p class="titleImage text-center">Vous pouvez supprimer des images du défi</p>
    </div>
    <br/>
    <div class="flex justify-content-between flex-wrap">   
        @foreach($challenge->images as $image)
            <div class="positionButton">
                <div>
                    <img class="imageChallengeEdit align-self-center" src="{{$image->image_path}}" alt="{{$image->challenge->title}}">
                </div>
                @if ($numberImage >1)
                <div>
                    <form action="{{route('images.destroy',$image->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger align-self-center" type="submit"> Supprimer </button>
                    </form>
                </div>
                @endif
            </div>
        @endforeach
    </div>

</div>


@endsection

