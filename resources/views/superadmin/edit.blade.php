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
                        <input value="{{$user->phone }}" type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" class="form-control" name="phone" class=@error('phone') is-invalid @enderror />
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
        <h2 class="titleEditProfile">Gérer les sessions de l'utilisateur</h2>
        <p>Ajouter ou supprimer des sessions à l'utilisateur.</p>
    </div>

    <div class="ProfileForm col-12 col-md-8">

        <form action="{{ route('users.storeSessiongame',$user->id) }}" method="post">
            @method('POST')
            <!-- Add CSRF Token -->
            @csrf
        <fieldset>
            <h3 class="titleProfileSession"> Ajouter des sessions</h3>
            <br/>
            @if ($sessiongames->isEmpty())
            <div class="flex justify-content-center flex-column">
                <div><p class="price text-center">Il n'y a aucunes sessions à ajouter pour le moment !</p></div>
            </div>
            @else
            <br/>
            @foreach ($sessiongames as $sessiongame)
                <div class="form-check form-check-inline flex justify-content-center ">
                    <input class="form-check-input" type="checkbox" value="{{$sessiongame->id}}" name="sessiongame_id[]" class=@error('sessiongame_id') is-invalid @enderror>
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
            
        </fieldset>
        <br/>
        @error('sessiongame_id')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 

        <br/>

        <div class="flex justify-content-end">
            <button type="submit" class="btn btn-info ">Ajouter</button>
        </div>
        @endif
        </form>

        <br/>
            
       
        <h3 class="titleProfileSession"> Supprimer des sessions</h3>
        @if ($sessiongamesUser->isEmpty())
            <div class="flex justify-content-center flex-column">
                <div><p class="price text-center">Il n'a aucune session pour le moment !</p></div>
            </div> 
        
        @else
        <br/>
        <div class=" col-12 table-responsive">
            <table class="table-bordered table-hover align-middle table tableGoodie">
                @foreach ($sessiongamesUser as $sessiongameUser)
                
                    <tbody>
                        <td>
                            @if($sessiongameUser->type=="On The Road a Game")
                                 {{$sessiongameUser->name}} du {{$sessiongameUser->start_date}} au {{$sessiongameUser->end_date}} (OTR)
                            @else 
                                 {{$sessiongameUser->name}} du {{$sessiongameUser->start_date}} au {{$sessiongameUser->end_date}} (@Home)
                            @endif
                        </td>
                        <td class="text-center">
                            <form class =" formDelete" action="{{ route('users.destroySessiongameUser',$sessiongameUser->pivot) }}" method="post">
                                @method('DELETE')
                                <!-- Add CSRF Token -->
                                @csrf
                                <button class="btn btn-danger" type="submit"> Supprimer </button> 
                            </form>
                        </td>
                    </tbody>
                @endforeach
            </table>
        </div>
        @endif
        <br/>
    </div>

    <div class="col-md-4 col-12 informationsProfil">
        <h2 class="titleEditProfile">Modifier son rôle</h2>
        <p>Assurez-vous de donner les bons droits.</p>
    </div>

    <div class="ProfileForm col-12 col-md-8">
        <form action="{{ route('users.updateRole',$user->id) }}" method="post">
            @method('PUT')
            <!-- Add CSRF Token -->
            @csrf
        <fieldset>
            
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
                    <label for="delete" > Une fois le compte supprimé, toutes ses ressources et données seront définitivement supprimées. </label>
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

<br/>

@endsection