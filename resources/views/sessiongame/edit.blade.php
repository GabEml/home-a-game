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
            <label for="start_date">Date de début</label>
            <input type="date" value="{{$sessiongame->start_date}}" required name="start_date" id="start_date" class="form-control"class=@error('start_date') is-invalid @enderror ></input>
        </div>
        
        <div class="form-group">
            <label for="end_date">Date de fin</label>
            <input type="date" value="{{$sessiongame->end_date}}" required name="end_date" id="end_date" class="form-control"class=@error('end_date') is-invalid @enderror ></input>
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
        
   </fieldset>
   @error('price')
    <div class="alert alert-danger"> {{$message}} </div>
    @enderror 
    @error('start_date')
    <div class="alert alert-danger"> {{$message}} </div>
    @enderror 
   @error('end_date')
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
