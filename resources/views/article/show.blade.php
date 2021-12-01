@extends('layouts.main')

@section('title', $article->title)

{{-- @section('titlePage', $article->title) --}}

@section('content')


    <section class="row">
        <div class="col-12">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active">{{ $article->title }}</li>
                </ol>
            </nav>
            <!--End Breadcrumb-->
            <article class="mb-3">
                <div class=" flex flex-col justify-content-center centerImageHome">
                    <img class="banniere_petite align-self-center img-fluid" src="{{ $article->image_path }}"
                        alt="trophee">
                </div>
                <br />
                {{-- <h2 class="titleArticle">{{$article->title}}</h2> --}}
                <br />
                <div class="containerForArticle">
                    <h2 class="titleArticle">{{ $article->title }}</h2>
                    <br />
                    <p class="nameDate">Par <span class="name">{{ $article->user->firstname }}</span>
                        écrit
                        le {{ $article->created_at }}</p>
                </div>
                <br />
                <div class="containerForArticle">
                    <p>{{ $article->description }}</p>
                </div>
                <br />
                <div class="containerForArticle">
                    <p class="nameDate"> Dernière modification : {{ $article->updated_at }}</p>
                </div>


            </article>
    </section>

    <div class="row">
        <div class="col-12 text-center">
            <a class="btn btn-info buttonReturn" href="{{ route('articles.index') }}"> Retour</a>
        </div>
    </div>

    <br />


@endsection
