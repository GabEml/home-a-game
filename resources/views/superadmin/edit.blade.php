@extends('layouts.main')

@section('title', 'Modifier un utilisateur')

@section('titlePage',"Modifier un utilisateur")

@section ('content')

<div class="row">
    <div class="col-md-4 col-12 informationsProfil">
        <h2 class="titleEditProfile">Informations personnelles</h2>
        <p>Modifier les informations personnelles et son adresse mail.</p>
    </div>

    <div class=" ProfileForm col-12 col-md-8">
        <form action="{{route('users.update',$user->id)}}" method="post" >
            @method('PUT')
            <!-- Add CSRF Token -->
            @csrf
        <fieldset class="">
            
                    <div class="form-group">
                        <label for="firstname" > Prénom </label>
                        <input value="{{$user->firstname }}" type="text" class="form-control" name="firstname" class=@error('firstname') is-invalid @enderror />
                    </div>
                    
                    <div class="form-group">
                        <label for="lastname"> Nom </label>
                        <input value="{{$user->lastname}}" type="text" required name="lastname" id="lastname" class="form-control"class=@error('lastname') is-invalid @enderror >
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="{{$user->email }}" type="email" required name="email" id="email" class="form-control"class=@error('email') is-invalid @enderror >
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth"> Date de naissance </label>
                        <br/>
                        <input type="date" value="{{$user->date_of_birth }}" class="form-control" name='date_of_birth' id='date_of_birth' class="form-control"class=@error('date_of_birth') is-invalid @enderror>
                    </div>

                    <div class="form-group">
                        <label for="phone" >Numéro de téléphone </label>
                        <input value="{{$user->phone }}" type="tel" pattern="0[1-9][0-9]{8}" class="form-control" name="phone" class=@error('phone') is-invalid @enderror />
                    </div>
            
                
                    <div class="form-group">
                        <label for="address"> Adresse </label>
                        <input value="{{$user->address }}" type="text" required name="address" id="address" class="form-control"class=@error('address') is-invalid @enderror >
                    </div>
                    
                    <div class="form-group">
                        <label for="city"> Ville</label>
                        <input value="{{$user->city}}" type="text" required name="city" id="city" class="form-control"class=@error('city') is-invalid @enderror >
                    </div>

                    <div class="form-group">
                        <label for="country" > Pays </label>
                        <input value="{{$user->country}}" type="text" class="form-control" name="country" class=@error('country') is-invalid @enderror />
                    </div>
                    
                    <div class="form-group">
                        <label for="postal_code"> Code postal </label>
                        <input value="{{$user->postal_code }}" type="text" pattern="[0-9]{5}" required name="postal_code" id="postal_code" class="form-control"class=@error('postal_code') is-invalid @enderror >
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

        <div class="flex justify-content-end">
            <button type="submit" class="btn btn-info ">Modifier</button>
        </div>

        </form>
    </div>

    <div class="col-md-4 col-12 informationsProfil">
        <h2 class="titleEditProfile">Modifier son rôle</h2>
        <p>Assurez-vous de données les bons droits.</p>
    </div>

    <div class="ProfileForm col-12 col-md-8">
        <form action="{{ route('users.updateRole',$user->id) }}" method="post">
            @method('PUT')
            <!-- Add CSRF Token -->
            @csrf
        <fieldset class="">
            
                    <div class="form-group">
                        <label for="role" > Rôle </label>
                        <select value="{{ $user->role->role }}" class="form-control" name='role_id' class=@error('role_id') is-invalid @enderror>
                            @if($user->role->role =="User")
                            <option value="1" selected> Utilisateurs </option>
                            <option value="2"> Admin Défis </option>
                            <option value="3"> Super Admin </option>
                            @elseif($user->role->role =="Admin Défis")
                            <option value="1"> Utilisateurs </option>
                            <option value="2" selected> Admin Défis </option>
                            <option value="3"> Super Admin </option>
                            @else 
                            <option value="1" > Utilisateurs </option>
                            <option value="2" > Admin Défis </option>
                            <option value="3" selected> Super Admin </option>
                            @endif
                        </select>
                    </div>
  
        </fieldset>
        @error('role_id')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 

        <br/>

        <div class="flex justify-content-end">
            <button type="submit" class="btn btn-info ">Modifier</button>
        </div>

        </form>
    </div>

<div class="col-md-4 col-12 informationsProfil">
    <h2 class="titleEditProfile">Supprimer le compte</h2>
    <p>Supprimez définitivement le compte.</p>
</div>

<div class="ProfileForm col-12 col-md-8">
    <form action="{{ route('users.destroy',$user->id) }}" method="post">
        @method('DELETE')
        <!-- Add CSRF Token -->
        @csrf
    <fieldset class="">
        
                <div class="form-group">
                    <label for="delete" > Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. </label>
                </div>

    </fieldset>

    <br/>

    <div class="flex justify-content-start">
        <button type="submit" class="btn btn-danger ">Supprimer</button>
    </div>

    </form>
</div>

</div>

<div class="row">
    <div class="col-12 text-center">
        
            <div>
                <a class="btn btn-info" href="{{route('users.indexUsers')}}"> Retour</a>
            </div>

    </div>
</div>
@endsection