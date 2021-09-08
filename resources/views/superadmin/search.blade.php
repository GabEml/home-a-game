@extends('layouts.main')

@section('title', 'Utilisateurs - Utilisateurs')

@section('titlePage',"Gestion des utilisateurs")

@section ('content')

<div class="row">
    <div class=" menuValidation col-12 justify-content-center flex">
        <a href ="{{ route('users.indexUsers') }}" class=" menuValidation buttonPending buttonActive "> Utilisateurs </a>
        <a href ="{{ route('users.indexAdminChallenge') }}" class=" menuValidation buttonValidated" > Admins défis</a>
        <a href ="{{ route('users.indexSuperAdmin') }}" class=" menuValidation buttonValidated" > Super admins</a>
    </div>
</div>

<br/><br/>

<div class=" contourForm col-12 col-md-6 offset-md-3">
    @if ($users->isEmpty())
        <div class="flex justify-content-center flex-column">
            <div><p class="price text-center">Il n'y a aucun utilisateurs !</p></div>
        </div>
        @else
        <div class="flex justify-content-center flex-column ">
            <p class="sessions text-center">Choississez un utilisateur a modifier</p>
        </div>
        <br/>

    <form action="{{ route('users.search') }}" method="get" role="search">
        <!-- Add CSRF Token -->
        @csrf
        <div class="input-group">
            <input value="{{request()->searchUser ?? ''}}" type="text" class="form-control" placeholder="Rechercher..." name="searchUser">
            <span class="input-group-btn">
        <button class="btn btn-info" type="submit">Rechercher</button>
      </span>
        </div>
    </form>

<br/><br/>
{{-- @if ( $usersSearch->isEmpty()) --}}
@if (false)
<div class="flex justify-content-center flex-column">
    <div><p class="price text-center">Aucun utilisateurs trouvés !</p></div>
</div>
@else
    <div class=" col-12 table-responsive">
        <table class="table-bordered table-hover align-middle table tableGoodie">
            @foreach ($usersSearch as $userSearch)
            
                <tbody>
                    <tr>
                        <td>
                            {{$userSearch}}
                            {{$userSearch->firstname}} {{$userSearch->lastname}}  ({{$userSearch->email}})
                        </td>
                        <td class="text-center"> 
                            <a class="btn btn-success" href="{{route('users.edit',$userSearch->id)}}"> Modifer</a>
                        </td>
                </tr>
                </tbody>
            @endforeach
        </table>
    </div>
@endif

    <br/><br/>

    <form action="{{ route('users.store') }}" method="post" class="">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>

        <div class="form-group">
                <br/>
                <select class="form-control" name='user' id='user' class="form-control"class=@error('user') is-invalid @enderror>
                    @foreach ($users as $user)
                        <option value={{$user->id}}> {{$user->firstname}} {{$user->lastname}}</option>
                    @endforeach
                </select>
        </div>
        
       </fieldset>
       @error('user')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
       <br/>
       <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info ">Modifier</button>
            </div>
       </div>
       @endif
    </form>

</div>

<br/>

<div class="row">
    <div class="col-12 text-center">
            <div>
                <a class="btn btn-info" href="{{route('users.create')}}"> Ajouter un utilisateur</a>
            </div>
    </div>
</div>

<br/>

@endsection