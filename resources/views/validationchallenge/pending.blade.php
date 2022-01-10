@extends('layouts.main')

@section('title', 'Validations Défis - Défis validés')

@section('titlePage',"Validations Défis")

@section ('content')

<div class="row">
    <div class=" menuValidation col-12 justify-content-center flex">
        <a href ="{{ route('posts.indexPending') }}" class=" menuValidation buttonPending buttonActive"> En attente </a>
        <a href ="{{ route('posts.indexValidated') }}" class=" menuValidation buttonValidated" >Validés </a>
    </div>
</div>

<br/>

<div class=" col-12 col-md-6 offset-md-3">
    <form action="{{ route('posts.search') }}" method="get" role="search">
        <!-- Add CSRF Token -->
        @csrf
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Rechercher..." name="searchPost">
            <span class="input-group-btn">
        <button class="btn btn-info" type="submit">Rechercher</button>
      </span>
        </div>
    </form>
</div>

<br/>

<div class="row containerArticles">
    @if ($postsPending->isEmpty())
        <div><p class="message">Vous avez validé tous les défis en attente !</p></div>
    @else
        @foreach ($postsPending as $postPending)
                <div class=" positionButton marginArticles col-lg-3 col-md-6 col-sm-12 containerPresentation">
                    <div class="flex justify-content-end buttonDelete">
                        <form action="{{route('posts.destroy',$postPending->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn buttonCross btn-danger" type="submit"> X </button>
                        </form>
                    </div>
                    <div class="flex flex-col justify-content-center">
                        @if (false !==mb_strpos($postPending->file_path, "/images"))
                        <a href="{{$postPending->file_path}}"><img width="280px" height="auto" class="align-self-center imagePresentation" src="{{$postPending->file_path}}" alt="{{$postPending->challenge->title}}"></a>
                            @else
                                <video class="videoChallengePost" controls>

                                    <source src="{{$postPending->file_path}}" type="video/webm">
                                    <source src="{{$postPending->file_path}}" type="video/mp4">
                                    <source src="{{$postPending->file_path}}" type="video/ogg">
                                </video>
                            @endif
                        <h2 class="align-self-center titleArticleHome">{{$postPending->challenge->title}}</h2>
                    </div>
                    <br/>
                    <div>
                        <div class="">
                            <div> <p>De : {{$postPending->user->firstname}} {{$postPending->user->lastname}}</p></div>
                            @if ($postPending->challenge->unlimited_points ==1)
                            <div> <p> Nombres de points : Illimités</p></div>
                            @else
                                <div> <p> Nombres de points : {{$postPending->challenge->points}}</p></div>
                            @endif
                            @if ($postPending->posted_at !== null)
                            <div><p>Posté le : <?php $postedAt = explode(' ', $postPending->posted_at); ?><?=$postedAt[0];?> à <?=$postedAt[1]?></p></div>
                            @endif
                            
                        </div>
                        <br/>
                        <form action="{{route('posts.update',$postPending->id)}}" method="post">
                            <!-- Add CSRF Token -->
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="state" >Statut :</label>
                                <select class="form-control" name='state' class=@error('state') is-invalid @enderror>
                                    <option value="validated" selected> Validé </option>
                                    <option value="partly_validated"> Partiellement validé </option>
                                    <option value="not_validated"> Non validé </option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="user_point">Nombres de points :</label>
                                <input type="number" min=0  value="{{$postPending->user_point}}" name="user_point" id="user_point" class="form-control"class=@error('user_point') is-invalid @enderror >
                            </div>

                            <div class="form-check form-check-inline flex justify-content-center ">
                                <input class="form-check-input" type="checkbox" value="1" name="bonus" class=@error('bonus') is-invalid @enderror>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Bonus
                                </label>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label for="comment">Commentaire :</label>
                                <textarea name="comment" id="comment" class="form-control"class=@error('comment') is-invalid @enderror ></textarea>
                            </div>
                            <div class="flex justify-content-center">
                                <small><a href="{{$postPending->file_path}}" download>(Télécharger)</a></small>
                            </div>
                            <br/>
                    </fieldset>
                    
                    <div class="flex justify-content-center">
                            <button type="submit" class="btn btn-info ">Valider</button>
                    </div>
                    @error('state')
                    <div class="alert alert-danger"> {{$message}} </div>
                    @enderror 
                    @error('bonus')
                    <div class="alert alert-danger"> {{$message}} </div>
                    @enderror 
                    @error('user_point')
                    <div class="alert alert-danger"> {{$message}} </div>
                    @enderror 
                    @error('comment')
                    <div class="alert alert-danger"> {{$message}} </div>
                    @enderror 
                    </form>
                    </div>
                </div>
        @endforeach
    @endif
</div>

<br/><br/>

@endsection