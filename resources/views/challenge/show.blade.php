@extends('layouts.main')

@section('title', $challenge->title)

@section('titlePage', $challenge->title) 

@section ('content')



    <div class="col-12">
       <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('sessiongames.index') }}">Espace Jeu</a></li>
                <li class="breadcrumb-item "><a href="{{ route('sessiongames.show', $sessiongame->id) }}">Session {{$sessiongame->name}} </a></li>
                <li class="breadcrumb-item active">{{$challenge->title}}</li>
                
            </ol>
       </nav>
    </div>
       <!--End Breadcrumb-->

    <div class="row justify-content-between">

        <div class="col-lg-7 col-md-12 contourChallenge">
            <div id="competences" class="carousel slide" data-ride="carousel"> 
                <ol class="carousel-indicators">
                    @for ($i = 0; $i < $numberImages; $i++)
                        <li data-target="#imageChallenge" data-slide-to="{{$i}}"></li>
                    @endfor
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{$challenge->images[0]->image_path}}" alt="{{$challenge->title}}" class="d-block imageChallengePost" />
                    </div>
                    @for ($i = 1; $i < $numberImages; $i++)
                    <div class="carousel-item">
                        <img src="{{$challenge->images[$i]->image_path}}" alt="{{$challenge->title}}" class="d-block imageChallengePost" />
                    </div>
                    @endfor
                </div>

                <a href="#competences" class="carousel-control-prev" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a href="#competences" class="carousel-control-next" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>

            <div class="infoChallenge">
                <p class="titleChallenge">{{$challenge->title}}</p>
                @if ($challenge->type_of_file=="picture")
                    <p> Vous devez fournir une photo</p>
                @elseif ($challenge->type_of_file=="video")
                    <p> Vous devez fournir une vidéo</p>
                @else 
                <p> Vous devez fournir une photo ou bien une vidéo</p>
                @endif
                @if ($challenge->unlimited_points==1)
                <p>Nombres de points : Illimités</p>
                @else
                    <p>Nombres de points : {{$challenge->points}}</p>
                @endif
                
            </div>
            <br/><br/>
            <div>
                <p class="titleChallenge">Votre post</p>

                    @if($post==NULL)
                        <br/>
                        <form action="{{ route('challenges.posts.store',$challenge->id) }}" method="post" enctype="multipart/form-data">
                            <!-- Add CSRF Token -->
                            @csrf
                        <fieldset>
                                
                                <div class="form-group">
                                    @if ($challenge->type_of_file=="picture")
                                        <label for="file_path" >Choississez votre photo (max 100Mo)</label>
                                    @elseif ($challenge->type_of_file=="video")
                                        <label for="file_path" >Choississez votre vidéo (Accepté : mp4 | max 100Mo)</label>
                                    @else
                                    <label for="file_path" >Choississez votre photo ou vidéo (Accepté : mp4 et toutes images | max 100Mo)</label>
                                    @endif
                                    <br/>
                                    <input type="file" class="form-control-file" name="file_path" required class=@error('file_path') is-invalid @enderror>
                                </div>
                                
                        </fieldset> 
                        @if($challenge->editable ==0)
                            <p class="align-self-center text-center list-group-item list-group-item-danger"> <span class="warning">ATTENTION </span>, vous n'avez qu'une chance pour ce défi, une fois validée par l'administrateur vous ne pourrez pas le refaire !</p>
                        @else
                        <p class="align-self-center text-center list-group-item list-group-item-info">Vous avez plusieurs chance pour réaliser ce défi</p>
                        @endif
                        <br/>
                            @error('file_path')
                            <div class="alert alert-danger"> {{$message}} </div>
                            @enderror 
                        <br/>
                        <div class="infoChallenge">
                            <button type="submit" class="btn btn-info ">Ajouter</button>
                        </div>
                        </form>

                    @else

                        @if ($challenge->type_of_file=="picture")
                            <img src="{{$post->file_path}}" alt="{{$challenge->title}}" class="d-block imageChallengePost" />
                        @else
                            <video class="videoChallengePost" controls width="250">

                                <source src="{{$post->file_path}}"
                                        type="video/mp4">
                            </video>
                        @endif
                            @if($challenge->editable==1 or $post->state=="pending")
                                <div class="infoChallenge">
                                    <form action="{{route('posts.destroy',$post->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger buttonDeletePost" type="submit"> Supprimer </button>
                                    </form>

                                    <div>
                                        @if($post->state=="pending")
                                        <p class="align-self-center text-center list-group-item list-group-item-info">Tant que le défi est en attente, vous pouvez toujours le supprimer et poster à nouveau</p>
                                        @else
                                            <p class="list-group-item list-group-item-info"> <span class="warning">ATTENTION </span>, si vous supprimez votre post, vous perdrez vos points pour ce défi, quitte à en gagner moins avec un autre post !</p>
                                        @endif
                                        </div>
                                </div>


                            @endif
                    @endif
            </div>
        </div>
        <div class="offset-lg-1 col-lg-4 col-md-12 contourChallenge validationPost backgroundValidation">
            <div class="infoChallenge">
                <p class="titleChallenge">Validation</p>
            </div>
            <br/>
            <table class="tableValidation">
                @if($post==NULL)
                <div class="infoChallenge">
                <p>Lorsque vous aurez posté, vous pourrez suivre en temps réel la validation des défis par
                    les administrateurs</p>
                </div>
                @else
                    <tr>
                        <td class="infoValidation">Statut :</td>
                        @if($post->state =="pending")
                            <td class="resultValidation">En attente </td>
                        @elseif($post->state =="not_validated")
                            <td class="resultValidation">Non validé </td>
                        @elseif($post->state =="partly_validated")
                            <td class="resultValidation">Partiellement validé </td>
                        @else
                        <td class="resultValidation">Validé </td>
                        @endif

                    </tr>
                    <tr>
                        <td class="infoValidation">Commentaire : </td>
                        @if ($post->comment==NULL)
                        <td class="resultValidation">Aucun commentaire</td>
                        @else
                            <td class="resultValidation">{{$post->comment}}</td>
                        @endif
                            
                    </tr>
                    <tr>
                        <td class="infoValidation">Nombres de points :</td>
                        @if ($challenge->unlimited_points==1)
                            <td class="resultValidation">{{$post->user_point}}</td>
                        @else 
                            <td class="resultValidation">{{$post->user_point}}/{{$challenge->points}}</td>
                        @endif
                    </tr>
                @endif
            </table>
            
        </div>

    </div>
  <br/>
<div class="row">
    <div class="col-12 text-center">
                <a class="btn btn-primary" href="{{ route('sessiongames.show', $sessiongame->id) }}"> Retour</a>
    </div>
</div>


<br/>


@endsection