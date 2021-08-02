@extends('layouts.main')

@section('title', 'Goodies')

@section('titlePage',"Goodies")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3 table-responsive">
    <table class="table table-bordered table-hover tableGoodies">
        <thead>
            <th>Nom</th>
            <th colspan="2">Actions</th>
        </thead>
    @foreach($goodies as $goodie)
    <tbody>
     <td class="goodies cellGoodies">{{$goodie->name}}</td>
    <td class="cellGoodies"> <form action="{{route('goodies.update', $goodie)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <input value={{$goodie->name}} class="form-control" type="text" id="goodie" name="name" class=@error('goodie')  is-invalid @enderror>
        </div>
        @error('goodie')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-success" type="submit">Modifier</button>
    </form>
    </td>
   
    <td class="cellGoodies"> <form action="{{route('goodies.destroy',$goodie->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit"> X </button> 
    </form>
    </td>
   
    </tbody>
    @endforeach
</table>

<br/>

<form action="{{route('goodies.store', $goodie->id)}}" method="POST">
    @csrf
    <div class="form-group">
        <label for='text'> Goodie </label>
        <input type="text" class="form-control" id="goodie" name="name" class=@error('goodie') is-invalid @enderror>
    </div>
    @error('goodie')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="col-12 text-center">
        <button class="btn btn-info" type="submit">Ajouter</button>
    </div>
</form>
</div>

<br/><br/>

@endsection