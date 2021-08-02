@extends('layouts.main')

@section('title', 'Ajouter une session')

@section('titlePage',"Ajouter une session")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('sessiongames.store') }}" method="post"">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>
           
            {{-- <div class="form-group">
                <label for="price" >Prix (€)</label>
                <input value="{{ old('price') }}" type="number" step="any" class="form-control" name="price" class=@error('price') is-invalid @enderror />
            <small>Si vous ne mettez pas de prix, il est fixé à 40€ par défault</small>
            </div> --}}
            
            <div class="form-group">
                <label for="start_date">Date de début</label>
                <input value="{{ old('start_date') }}" type="date" required name="start_date" id="start_date" class="form-control"class=@error('start_date') is-invalid @enderror >
            </div>
            
            <div class="form-group">
                <label for="end_date">Date de fin</label>
                <input value="{{ old('end_date') }}" type="date" required name="end_date" id="end_date" class="form-control"class=@error('end_date') is-invalid @enderror >
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
        @error('goodie')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
       <br/>
       <div class="flex justify-content-between">
        <a class="btn btn-primary" href="{{route('sessiongames.index')}}"> Retour </a>
        <button type="submit" class="btn btn-info ">Ajouter</button>
        

       </div>
    </form>
</div>

@endsection