@extends('layouts.main')

@section('title', 'Ajouter une session')

@section('titlePage',"Ajouter une session")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('sessiongames.store') }}" method="post" enctype="multipart/form-data">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>

            <div class="form-group">
                <label for="price" >Prix (€)</label>
                <input value="{{ old('price') }}" required type="number" step="any" class="form-control" name="price" class=@error('price') is-invalid @enderror />
            {{-- <small>Si vous ne mettez pas de prix, il est fixé à 40€ par défault</small> --}}
            </div>

            <div class="form-group">
                <label for="name">Nom </label>
                <input value="{{ old('name') }}" type="text" required name="name" id="name" class="form-control"class=@error('name') is-invalid @enderror >
            </div>

           <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
           <div class="form-group">
               <label for="description">Description</label>
               <textarea required name="description" id="description" rows="8" class="form-control"class=@error('description') is-invalid @enderror ></textarea>
           </div>
           <script>
               CKEDITOR.replace( 'description' );
           </script>

            <div class="form-group">
                <label for="start_date">Date de début</label>
                <input value="{{ old('start_date') }}" type="date" required name="start_date" id="start_date" class="form-control"class=@error('start_date') is-invalid @enderror >
            </div>

            <div class="form-group">
                <label for="end_date">Date de fin</label>
                <input value="{{ old('end_date') }}" type="date" required name="end_date" id="end_date" class="form-control"class=@error('end_date') is-invalid @enderror >
            </div>

            <div class="form-group">
                <label for="image_path" >Image</label>
                <br/>
                <input type="file" class="form-control-file" class="form-control-file" name="image_path" required class=@error('image_path') is-invalid @enderror>
            </div>

            <div class="form-group">
                <label for="goodie"> Goodie</label>
                <br/>
                <select value="{{ old('goodie') }}" class="form-control" name='goodie' id='goodie' class="form-control"class=@error('goodie') is-invalid @enderror>
                    @foreach ($goodies as $goodie)
                        <option value={{$goodie->id}}> {{$goodie->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="type" >Type de session :</label>
                <select class="form-control" name='type' class=@error('type') is-invalid @enderror>
                    <option value="Home a Game" selected>Home a Game </option>
                    <option value="On The Road a Game">On The Road a Game</option>
                </select>
            </div>

<br/>

            <div class="form-check form-check-inline flex justify-content-center ">
                <input class="form-check-input" type="checkbox" value="0" name="see_ranking" class=@error('see_ranking') is-invalid @enderror>
                <label class="form-check-label" for="flexCheckDefault">
                    Cacher le classement
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
        <a class="btn btn-primary" href="{{route('sessiongames.index')}}"> Retour </a>
        <button type="submit" class="btn btn-info ">Ajouter</button>


       </div>
    </form>
</div>

@endsection
