@extends('layouts.main')

@section('title', 'Utilisateurs - Liste')

@section('titlePage',"Liste des utilisateurs")

@section ('content')

<div class="row">
    <div class=" menuValidation col-12 justify-content-center flex">
        <a href ="{{ route('users.indexUsers') }}" class=" menuValidation buttonPending "> Utilisateurs </a>
        <a href ="{{ route('users.indexAdminChallenge') }}" class=" menuValidation buttonValidated" > Admins défis</a>
        <a href ="{{ route('users.indexSuperAdmin') }}" class=" menuValidation buttonValidated" > Super admins</a>
        <a href ="{{ route('users.indexListUsers') }}" class=" menuValidation buttonValidated buttonActive" > Liste</a>
    </div>
</div>

<br/><br/>

<div class="contourForm col-12 col-md-6 offset-md-3 form_container_filered_users">
    <div>
        <div class="flex justify-content-center flex-column">
            <p class="sessions text-center">Liste des utilisateurs</p>
        </div>
        <form id="form_user_csv" action="{{ route('users.usersCsv') }}" method="GET">
            <div class="flex justify-content-between align-items-center m-3 mb-5 ">
                <h2>
                    <strong>{{ count($allUsers) }}</strong> utilisateurs inscrits.
                </h2>
                <input type="hidden" name="role" value="{{ isset($currentValues['role']) ? $currentValues['role'] : 'Any Role' }}"/>
                <button class="btn btn-info ">
                    Télécharger la liste
                </button>
            </div>
        </form>
    </div>
    <div>
        <form id="form_filter_users" class="form_filter_users" action="{{ route('users.indexListUsers') }}" method="GET">
            <div class="mb-3">
                <div class="flex justify-content-between">
                    <div class="flex justify-content-between align-items-center">
                        @if(@isset($currentValues['role'])) 
                            @php $currentValues['role']; @endphp
                        @else 
                            @php $currentValues['role'] = 'Tous' @endphp
                        @endif 
                        <label for="role">Role: {{$currentValues['role']}} </label> 
                        <select name="role" class="form-control w-50">
                            <option value="Any Role">Tous</option>
                            @foreach($userRoles as $userRole)  
                                <option value="{{$userRole}}">{{$userRole}}</option>
                            @endforeach
                        </select>
                    </div>    
                    <div class="flex justify-content-between align-items-center">
                        <label for="paginate">Nombre par pages: </label> 
                        <input type="number" name="paginate"  class="form-control w-20" value="{{ isset($currentValues['paginate']) ? $currentValues['paginate'] : '100' }}" oninput="this.value = 
                        !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null"/>
                    </div>                
                </div>
            </div>
            <button class="btn btn-info ">
                Rechercher
            </button>
            <table class="mt-5 w-100 table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filteredUsers as $user)
                            <tr>
                                <td>
                                    {{ $user->id }}
                                </td>
                                <td>
                                    {{ $user->lastname }}
                                </td>
                                <td>
                                    {{ $user->firstname }}
                                </td>
                                <td>
                                    {{ $user->email}}
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
            @if(count($filteredUsers) == 0)
                {{ 'Aucun résultat' }}
            @endif 
        </form>
        <div class="laravel-pagination">
            {!! $filteredUsers->appends(Request::all())->links() !!}
        </div>
    </div>
</div>

<br/>

@endsection