@extends('layouts.main')

@section('title', 'Modifier une session')

@section('titlePage',"Modifier une session")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{route('sessiongames.update',$sessiongame->id)}}" method="post" enctype="multipart/form-data">
        <!-- Add CSRF Token -->
        @csrf
        @method('PUT')
        {{-- <div class="form-group">
            <label for="price" >Prix (€)</label>
            <input type="number" value="{{$sessiongame->price}}" step="any" class="form-control" name="price" class=@error('price') is-invalid @enderror />
        <small>Si vous ne mettez pas de prix, il est fixé à 40€ par défault</small>
        </div> --}}
        <div class="form-group">
            <label for="name">Nom </label>
            <input value="{{$sessiongame->name}}" type="text" required name="name" id="name" class="form-control"class=@error('name') is-invalid @enderror >
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea required name="description" id="description" rows="8" class="form-control"class=@error('description') is-invalid @enderror > {{$sessiongame->description}} </textarea>
        </div>

        <div class="form-group">
            <label for="start_date">Date de début</label>
            <input type="date" value="{{$sessiongame->start_date}}" required name="start_date" id="start_date" class="form-control"class=@error('start_date') is-invalid @enderror ></input>
        </div>
        
        <div class="form-group">
            <label for="end_date">Date de fin</label>
            <input type="date" value="{{$sessiongame->end_date}}" required name="end_date" id="end_date" class="form-control"class=@error('end_date') is-invalid @enderror ></input>
        </div>

        <div class="form-group">
            <label for="image_path" >Image (max 100Mo)</label>
            <br/>
            <input type="file" class="form-control-file" name="image_path" class=@error('image_path') is-invalid @enderror>
            <br/>
            <small>Si vous ne choissisez pas d'image, il garde celle déjà existante</small>
        </div>

        <div class="form-group">
            <label for="goodie"> Goodie</label>
            <br/>
            <select class="form-control" name='goodie' id='goodie'>
                @foreach ($goodies as $goodie)
                    <option value={{$goodie->id}}> {{$goodie->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="type" >Type de session :</label>
            <select class="form-control" name='type' class=@error('type') is-invalid @enderror>
                @if ($sessiongame->type=="Home a Game")
                    <option value="Home a Game" selected>Home a Game </option>
                    <option value="On The Road a Game">On The Road a Game</option>
                @else
                    <option value="Home a Game">Home a Game </option>
                    <option value="On The Road a Game" selected>On The Road a Game</option>
                @endif
            </select>
        </div>

        <div class="form-check form-check-inline flex justify-content-center ">
            @if($sessiongame->see_ranking == 1)
                <input class="form-check-input" type="checkbox" value="0" name="see_ranking" class=@error('see_ranking') is-invalid @enderror>
            @else
                <input class="form-check-input" type="checkbox" value="0" name="see_ranking" checked class=@error('see_ranking')  is-invalid @enderror>
            @endif  
            
            <label class="form-check-label" for="flexCheckDefault">
                Cacher le classement
            </label>
        </div>
        
   </fieldset>
   {{-- @error('price')
    <div class="alert alert-danger"> {{$message}} </div>
    @enderror  --}}
    @error('name')
    <div class="alert alert-danger"> {{$message}} </div>
    @enderror 
    @error('description')
    <div class="alert alert-danger"> {{$message}} </div>
    @enderror 
    @error('start_date')
    <div class="alert alert-danger"> {{$message}} </div>
    @enderror 
   @error('end_date')
    <div class="alert alert-danger"> {{$message}} </div>
    @enderror 
    @error('image_path')
    <div class="alert alert-danger"> {{$message}} </div>
    @enderror 
   <br/>
   <div class="flex justify-content-between">
    <a class="btn btn-primary" href="{{route('sessiongames.index')}}"> Retour </a>
    <button type="submit" class="btn btn-info ">Modifier</button>
    

   </div>
</form>
</div>

@endsection
