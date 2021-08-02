@extends('layouts.main')

@section('title', 'Validations Défis - Défis validés')

@section('titlePage',"Validations Défis")

@section ('content')

<div class="row">
    <div class=" menuValidation col-12 justify-content-center flex">
        <a href ="{{ route('posts.indexPending') }}" class=" menuValidation buttonPending "> En attente </a>
        <a href ="{{ route('posts.indexValidated') }}" class=" menuValidation buttonValidated buttonActive" >Validés </a>
    </div>
</div>

<br/><br/>

<div class="row containerArticles">
    @if ($postsValidated    ->isEmpty())
        <div><p class="message">Aucuns défis validés !</p></div>
    @else
        @foreach ($postsValidated as $postValidated)
                <div class=" positionButton marginArticles col-lg-3 col-md-6 col-sm-12 containerPresentation">
                    <div class="flex justify-content-end buttonDelete">
                        <form action="{{route('posts.destroy',$postValidated->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn buttonCross btn-danger" type="submit"> X </button>
                        </form>
                    </div>
                    <div class="flex flex-col justify-content-center">
                        @if ($postValidated->challenge->type_of_file=="picture")
                        <img width="280px" height="auto" class="align-self-center imagePresentation" src="{{$postValidated->file_path}}" alt="{{$postValidated->challenge->title}}">
                            @else
                                <video class="videoChallengePost" controls>

                                    <source src="{{$postValidated->file_path}}"
                                            type="video/mp4">
                                </video>
                            @endif
                        <h2 class="align-self-center titleArticleHome">{{$postValidated->challenge->title}}</h2>
                    </div>
                    <br/>
                    <div>
                        <div class="">
                            <div> <p>De : {{$postValidated->user->firstname}}</p></div>
                            <div> <p> Nombres de points : {{$postValidated->challenge->points}}</p></div>
                        </div>
                        <br/>
                        <form action="{{route('posts.update',$postValidated->id)}}" method="post">
                            <!-- Add CSRF Token -->
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="state" >Statut :</label>
                                <select class="form-control" name='state' class=@error('state') is-invalid @enderror>
                                    @if($postValidated->state =="validated")
                                    <option value="validated" selected> Validé </option>
                                    <option value="partly_validated"> Partiellement validé </option>
                                    <option value="not_validated"> Non validé </option>
                                    @elseif($postValidated->state =="partly_validated")
                                    <option value="validated" > Validé </option>
                                    <option value="partly_validated" selected> Partiellement validé </option>
                                    <option value="not_validated"> Non validé </option>
                                    @else
                                    <option value="validated" > Validé </option>
                                    <option value="partly_validated"> Partiellement validé </option>
                                    <option value="not_validated" selected> Non validé </option>
                                    @endif
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="user_point">Nombres de points :</label>
                                <input type="number" min=0 max="{{$postValidated->challenge->points}}"  value="{{$postValidated->user_point}}" required name="user_point" id="user_point" class="form-control"class=@error('user_point') is-invalid @enderror ></input>
                            </div>
                            
                            <div class="form-group">
                                <label for="comment">Commentaire :</label>
                                <textarea required name="comment" id="comment" class="form-control"class=@error('comment') is-invalid @enderror > {{$postValidated->comment}}</textarea>
                            </div>
                
                            
                    </fieldset>
                    <div class="flex justify-content-center">
                            <button type="submit" class="btn btn-info ">Modifier</button>
                    </div>
                    @error('state')
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