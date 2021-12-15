@extends('layouts.main')

@section('title', 'Validations Défis - Défis validés')

@section('titlePage', 'Validations Défis')

@section('content')

    <div class="row">
        <div class=" menuValidation col-12 justify-content-center flex">
            <a href="{{ route('posts.indexPending') }}" class=" menuValidation buttonPending "> En attente </a>
            <a href="{{ route('posts.indexValidated') }}" class=" menuValidation buttonValidated buttonActive">Validés </a>
        </div>
    </div>

    <br /><br />

    <div class="row containerArticles">
        @if ($postsValidated->isEmpty())
            <div>
                <p class="message">Aucuns défis validés !</p>
            </div>
        @else
            @foreach ($postsValidated as $postValidated)
                <div class=" positionButton marginArticles col-lg-3 col-md-6 col-sm-12 containerPresentation">
                    <div class="flex justify-content-end buttonDelete">
                        <form action="{{ route('posts.destroy', $postValidated->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn buttonCross btn-danger" type="submit"> X </button>
                        </form>
                    </div>
                    <div class="flex flex-col justify-content-center">
                        @if (false !== mb_strpos($postValidated->file_path, '/images'))
                            <a href="{{ $postValidated->file_path }}"><img width="280px" height="auto"
                                    class="align-self-center imagePresentation" src="{{ $postValidated->file_path }}"
                                    alt="{{ $postValidated->challenge->title }}"></a>
                        @else
                            <video class="videoChallengePost" controls>

                                <source src="{{ $postValidated->file_path }}" type="video/webm">
                                <source src="{{ $postValidated->file_path }}" type="video/mp4">
                                <source src="{{ $postValidated->file_path }}" type="video/ogg">
                            </video>
                        @endif
                        <h2 class="align-self-center titleArticleHome">{{ $postValidated->challenge->title }}</h2>
                    </div>
                    <br />
                    <div>
                        <div class="">
                            <div>
                                <p>De : {{ $postValidated->user->firstname }}</p>
                            </div>
                            @if ($postValidated->challenge->bonus == 1)
                                <div>
                                    <p> Nombres de points : Illimités</p>
                                </div>
                            @else
                                <div>
                                    <p> Nombres de points : {{ $postValidated->challenge->points }}</p>
                                </div>
                            @endif
                            @if ($postValidated->posted_at !== null)
                                <div>
                                    <p>Posté le : <?php $postedAt = explode(' ', $postValidated->posted_at); ?><?= $postedAt[0] ?> à <?= $postedAt[1] ?></p>
                                </div>
                            @endif
                        </div>
                        <br />
                        <form action="{{ route('posts.update', $postValidated->id) }}" method="post">
                            <!-- Add CSRF Token -->
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="state">Statut :</label>
                                <select class="form-control" name='state' class=@error('state') is-invalid @enderror>
                                    @if ($postValidated->state == 'validated')
                                        <option value="validated" selected> Validé </option>
                                        <option value="partly_validated"> Partiellement validé </option>
                                        <option value="not_validated"> Non validé </option>
                                    @elseif($postValidated->state =="partly_validated")
                                        <option value="validated"> Validé </option>
                                        <option value="partly_validated" selected> Partiellement validé </option>
                                        <option value="not_validated"> Non validé </option>
                                    @else
                                        <option value="validated"> Validé </option>
                                        <option value="partly_validated"> Partiellement validé </option>
                                        <option value="not_validated" selected> Non validé </option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="user_point">Nombres de points :</label>
                                <input type="number" min=0 value="{{ $postValidated->user_point }}" name="user_point"
                                    id="user_point" class="form-control" class=@error('user_point') is-invalid @enderror>
                            </div>

                            <div class="form-check form-check-inline flex justify-content-center ">
                                @if ($postValidated->bonus == 0)
                                    <input class="form-check-input" type="checkbox" value="1" name="bonus"
                                        class=@error('bonus') is-invalid @enderror>
                                @else
                                    <input class="form-check-input" type="checkbox" checked value="1" name="bonus"
                                        class=@error('bonus') is-invalid @enderror>
                                @endif

                                <label class="form-check-label" for="flexCheckDefault">
                                    Bonus
                                </label>
                            </div>

                            <br />

                            <div class="form-group">
                                <label for="comment">Commentaire :</label>
                                <textarea name="comment" id="comment" class="form-control" class=@error('comment')
                                    is-invalid @enderror> {{ $postValidated->comment }}</textarea>
                            </div>

                            <div class="flex justify-content-center">
                                <small><a href="{{ $postValidated->file_path }}" download>(Télécharger)</a></small>
                            </div>
                            <br />

                            </fieldset>
                            <div class="flex justify-content-center">
                                <button type="submit" class="btn btn-info ">Modifier</button>
                            </div>
                            @error('state')
                                <div class="alert alert-danger"> {{ $message }} </div>
                            @enderror
                            @error('bonus')
                                <div class="alert alert-danger"> {{ $message }} </div>
                            @enderror
                            @error('user_point')
                                <div class="alert alert-danger"> {{ $message }} </div>
                            @enderror
                            @error('comment')
                                <div class="alert alert-danger"> {{ $message }} </div>
                            @enderror
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if ($postsValidated->lastPage() > 1)
            <ul class="pagination">
                <li class="{{ ($postsValidated->currentPage() == 1) ? ' isDisabled' : '' }}">
                    <a href="{{ $postsValidated->url($postsValidated->currentPage()-1) }}">Précédent</a>
                </li>
                @for ($i = 1; $i <= $postsValidated->lastPage(); $i++)
                    <li class="{{ ($postsValidated->currentPage() == $i) ? ' active' : '' }}">
                        <a href="{{ $postsValidated->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="{{ ($postsValidated->currentPage() == $postsValidated->lastPage()) ? ' isDisabled' : '' }}">
                    <a href="{{ $postsValidated->url($postsValidated->currentPage()+1) }}" >Suivant</a>
                </li>
            </ul>
        @endif

    <br /><br />

@endsection
