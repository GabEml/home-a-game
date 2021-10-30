@extends('layouts.main')

@section('title', 'Liste de vos défis')

@section('titlePage', 'Liste de vos défis')

@section('content')



    <div class="col-12">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('sessiongames.index') }}">Espace Jeu</a></li>
                <li class="breadcrumb-item active">{{ $sessiongame->name }}</li>

            </ol>
        </nav>
    </div>

    <br />

    <div class='col-12'>
        <p class="text-center">{{ $sessiongame->description }}</p>
        <p class="text-center">Pour cette session, vous pouvez avoir la chance de gagner :
            {{ $sessiongame->goodie->name }} !</p>
        <br />
        @foreach ($users as $user)
            @php
                $position = $position + 1;
            @endphp
            @if ($user->id == Auth::user()->id)
                <p class="text-center resultRanking">Vous avez
                    @if ($user->points == null)
                        0 point,
                    @else
                        {{ $user->points }} points,
                    @endif

                    @if ($sessiongame->see_ranking == 1)
                        @if ($position == 1)
                            vous êtes {{ $position }}<sup>er</sup> du classement !
                </p>
            @else
                <sup>ème</sup> du classement !</p>
            @endif
        @else
            le classement n'est pas encore dévoilé ! </p>
        @endif
        @break
        @endif
        @endforeach
    </div>
    <br />

    <!--End Breadcrumb-->
    <div class="row containerArticles">
        @php
            $states = [
                'pending' => 'En attente',
                'not_validated' => 'Non validé',
                'partly_validated' => 'Partiellement validé',
                'validated' => 'Validé',
            ];
            $btn_label = [
                'pending' => 'Modifier',
                'not_validated' => 'Voir',
                'partly_validated' => 'Voir',
                'validated' => 'Voir',
                'empty' => 'Soumettre une preuve',
            ];
            
            $btn_class = [
                'not_validated' => 'NotValidated',
                'partly_validated' => 'PartlyValidated',
                'validated' => 'Validated',
            ];
        @endphp
        @foreach ($sessiongame->challenges as $challenge)
            @php
                $post = $challenge->posts
                    ->filter(function ($post) {
                        return $post->user_id == Auth::user()->id;
                    })
                    ->first();
                $state = $post ? $post->state : 'empty';
            @endphp
            <div
                class="flex flex-col positionButton marginArticles col-lg-3 col-md-6 col-sm-12 containerChallenge containerPresentation justify-content-between">
                <div class="flex flex-col">
                    <div class="containerTitleChallenge">
                        <h2 class="align-self-center text-center">{{ $challenge->title }}</h2>
                    </div>
                    {{-- <div class="roundTop"> </div> --}}
                    <img width="220px" height=auto class="align-self-center imagePresentation"
                        src="{{ $challenge->images[0]->image_path }}" alt="{{ $challenge->title }}">
                    @if ($challenge->unlimited_points == 1)
                        <h2 class="align-self-center text-center titleArticleHome">Points illimités</h2>
                    @else
                        <h2 class="align-self-center text-center titleArticleHome">{{ $challenge->points }} points</h2>
                    @endif

                </div>
                <div>
                    <div class="result">
                        @if ($state == 'empty')
                        @elseif($state == "pending")
                            <p class="status text-center"> Statut : {{ $states[$state] }} </p>
                        @else
                            <p class="status text-center state{{ $btn_class[$state] }}"> Statut : {{ $states[$state] }}
                            </p>
                            <p class="status text-center"> Score obtenu : {{ $post->user_point }} points </p>
                        @endif
                    </div>
                    <br />
                    <div>
                        @if (Auth::user()->role->role === 'Admin Défis' or Auth::user()->role->role === 'Super Admin')
                            <div class="flex justify-content-around">
                                <form action="{{ route('challenges.destroy', $challenge->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="buttonAdmin btn btn-danger" type="submit"> Supprimer </button>
                                </form>
                                <a class="btn buttonAdmin btn-success "
                                    href="{{ route('challenges.edit', $challenge->id) }}"> Modifier</a>

                            </div>
                        @else
                            <div>
                                @if ($challenge->editable === 1)
                                    <a class="btn seeMore seeMoreChallenge"
                                        href="{{ route('challenges.show', $challenge->id) }}">
                                        Modifier
                                    </a>
                                @else
                                    <a class="btn seeMore seeMoreChallenge"
                                        href="{{ route('challenges.show', $challenge->id) }}">
                                        {{ $btn_label[$state] }}
                                    </a>
                                @endif

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @auth
        @if (Auth::user()->role->role === 'Admin Défis' or Auth::user()->role->role === 'Super Admin')

            <div class="flex col-12 justify-content-between  btnChallengeAdmin">
                <div class="flex ">
                    <a class="btn btn-primary" href="{{ route('sessiongames.index') }}"> Retour</a>
                </div>
                <div>
                    <a class="btn btn-info" href="{{ route('sessiongames.challenges.create', $sessiongame->id) }}"> Ajouter un
                        défi</a>
                </div>
            </div>


        @elseif (Auth::user()->role->role==="User")
            <div class="row">
                <div class="col-12 text-center">
                    <div>
                        <a class="btn btn-info" href="{{ route('sessiongames.index') }}"> Retour</a>
                    </div>
                </div>
            </div>
        @endif
        @endif
        <br />


    @endsection
