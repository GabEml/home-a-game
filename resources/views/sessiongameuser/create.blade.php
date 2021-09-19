@extends('layouts.main')

@section('title', "S'inscrire à une session")

@section('titlePage',"S'inscrire à une session")

@section ('content')

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('sessiongameusers.store') }}" method="post" class="">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>
        @if ($sessiongames->isEmpty())
        <div class="flex justify-content-center flex-column">
            <div><p class="price text-center">Vous êtes déjà inscrit à toutes les prochaines sessions !</p></div>
        </div>
        @else
        <div class="flex justify-content-center flex-column ">
            <p class="sessions text-center">A quelle(s) session(s) voulez-vous participer ?</p>
        </div>
        <br/>
        <div class=" col-12 table-responsive">
            <table class="table-bordered table-striped table-hover align-middle table tableGoodie">
                <thead>
                    <tr>
                        <th class="lead font-weight-bold" scope="col">
                            Sessions
                        </th>
                        <th scope="col" class="h5 font-weight-bold text-center">
                            Prix (€)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sessiongames as $sessiongame)
                        
                            <tr>
                                <td>
                                    <input class="form-check-input" type="checkbox" value="{{$sessiongame->id}}" name="sessiongames[]" class=@error('session') is-invalid @enderror>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    {{$sessiongame->name}} du {{$sessiongame->start_date}} au {{$sessiongame->end_date}}
                                    </label>
                                </td>
                                <td class="text-center">
                                    {{$sessiongame->price}} €
                                </td>
                            </tr>
                        
                    @endforeach
                </tbody>
            </table>
        </div>
        
       </fieldset>
       @error('session')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
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
       <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info ">Ajouter</button>
            </div>
       </div>
       @endif
        

       </div>
    </form>
</div>

@if ($message = Session::get('success'))
<div class=" modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" >
  <div class=" modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modalSuccess">
      <div class="modal-header">
        <h5 class="modal-title alert-heading" id="exampleModalLongTitle">Paiement réussi !</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{$message}}
        <br/><br/>
        <p>Vous allez recevoir un mail de confirmation.</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('sessiongames.index') }}" type="button" class="btn btn-info">Accéder à l'espace de jeu</a>
      </div>
    </div>
  </div>
</div>
@endif

@if ($message = Session::get('error'))
<div class=" modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class=" modalDanger modal-content">
        <div class="modal-header">
          <h5 class="modal-title alert-heading" id="exampleModalLongTitle">Erreur !</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{$message}}
          <br/><br/>
          <p>Veuillez réessayer.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>
@endif

  @if ($message = Session::get('errorStripe'))
  <div class=" modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class=" modalDanger modal-content">
        <div class="modal-header">
          <h5 class="modal-title alert-heading" id="exampleModalLongTitle">Erreur paiement !</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{$message}}
          <br/><br/>
          <p>Veuillez réessayer.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>

@endif



<script>
    $(window).on('load',function(){
  $('#exampleModalCenter').modal('show');
});
</script>

@endsection