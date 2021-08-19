@extends('layouts.main')

@section('title', 'Ajouter un utilisateur')

@section('titlePage',"Ajouter un utilisateur")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('users.storeNewUser') }}" method="post">
        <!-- Add CSRF Token -->
        @csrf
        <p class="description ">Entrez les informations personnelles</p>
        <br/>
       <fieldset class="flex registrationForm">
           <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="firstname" > Prénom </label>
                    <input value="{{ old('firstname') }}" type="text" class="form-control" name="firstname" class=@error('firstname') is-invalid @enderror />
                </div>
                
                <div class="form-group">
                    <label for="lastname"> Nom </label>
                    <input value="{{ old('lastname') }}" type="text" required name="lastname" id="lastname" class="form-control"class=@error('lastname') is-invalid @enderror >
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input value="{{ old('email') }}" type="email" required name="email" id="email" class="form-control"class=@error('email') is-invalid @enderror >
                </div>

                <div class="form-group">
                    <label for="date_of_birth"> Date de naissance </label>
                    <br/>
                    <input type="date" value="{{ old('date_of_birth') }}" class="form-control" name='date_of_birth' id='date_of_birth' class="form-control"class=@error('date_of_birth') is-invalid @enderror>
                </div>

                <div class="form-group">
                    <label for="phone" >Numéro de téléphone </label>
                    <input value="{{ old('phone') }}" type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" class="form-control" name="phone" class=@error('phone') is-invalid @enderror />
                </div>
            </div>

            <div class="col-12 col-md-6">
            
                <div class="form-group">
                    <label for="address"> Adresse </label>
                    <input value="{{ old('address') }}" type="text" required name="address" id="address" class="form-control"class=@error('address') is-invalid @enderror >
                </div>
                
                <div class="form-group">
                    <label for="city"> Ville</label>
                    <input value="{{ old('city') }}" type="text" required name="city" id="city" class="form-control"class=@error('city') is-invalid @enderror >
                </div>

                <div class="form-group">
                    <label for="country" > Pays </label>
                    <input value="{{ old('country') }}" type="text" class="form-control" name="country" class=@error('country') is-invalid @enderror />
                </div>
                
                <div class="form-group">
                    <label for="postal_code"> Code postal </label>
                    <input value="{{ old('postal_code') }}" type="text" pattern="[0-9]{5}" required name="postal_code" id="postal_code" class="form-control"class=@error('postal_code') is-invalid @enderror >
                </div>
                
                <div class="form-group">
                    <label for="role_id"> Rôle </label>
                    <select value="{{ old('role_id') }}" class="form-control" name='role_id' id='role_id' class="form-control"class=@error('role_id') is-invalid @enderror>
                        @foreach ($roles as $role)
                            <option value={{$role->id}}> {{$role->role}}</option>
                        @endforeach
                    </select>
                </div>

            </div> 
        </fieldset>
        <br/>
        <fieldset class="registrationForm registrationSessiongame">
            <div class="form-group">
                <label for="sessiongame">Sessions </label>
                @foreach ($sessiongames as $sessiongame)
                    <div class="form-check form-check-inline flex">
                        <input class="form-check-input" type="checkbox" value="{{$sessiongame->id}}" name="sessiongames[]" class=@error('session') is-invalid @enderror>
                        @if($sessiongame->type=="On The Road a Game")
                            <label class="form-check-label" for="flexCheckDefault">
                            {{$sessiongame->name}} du {{$sessiongame->start_date}} au {{$sessiongame->end_date}} (OTR)
                            </label>
                        @else 
                            <label class="form-check-label" for="flexCheckDefault">
                            {{$sessiongame->name}} du {{$sessiongame->start_date}} au {{$sessiongame->end_date}} (@Home)
                            </label>
                        @endif
                    </div>
                @endforeach
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
        <a class="btn btn-primary" href="{{route('users.indexUsers')}}"> Retour </a>
        <button type="submit" class="btn btn-info ">Ajouter</button>
        

       </div>
    </form>
</div>

@endsection