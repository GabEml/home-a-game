@extends('layouts.main')

@section('title', 'Accueil')

@section('titlePage'," Home A Game : un jeu d'aventure pour continuer de vivre le voyage près de chez soi !")

@section ('content')


<div class="row containerHome">
    <div class=" col-12 col-md-6 col-lg-3 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/sablier.png" alt="trophee">
            <h2 class="align-self-center titlePresentation">Plusieurs semaines de challenge</h2>
        </div>
    </div>

    <div class=" col-12 col-md-6 col-lg-3 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/defis.png" alt="trophee">
            <h2 class="align-self-center titlePresentation">Une dizaine de défis à relever à chaque session</h2>
        </div>
    </div>

    <div class=" col-12 col-md-6 col-lg-3 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/trophee.png" alt="trophee">
            <h2 class="align-self-center titlePresentation">Des points à gagner avec un classement</h2>
        </div>
    </div>
</div>
<div class="row containerHome">
    <div class=" col-12 col-md-6 col-lg-3 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/cadeau.png" alt="trophee">
            <h2 class="align-self-center titlePresentation">Goodies à gagner et tirage au sort</h2>
        </div>
    </div>

    <div class=" col-12 col-md-6 col-lg-3 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/ville.png" alt="trophee">
            <h2 class="align-self-center titlePresentation">Un retour aux sources : la découverte de sa ville</h2>
        </div>
    </div>

    <div class=" col-12 col-md-6 col-lg-3 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/rencontre.png" alt="trophee">
            <h2 class="align-self-center titlePresentation">Des rencontres sincères et spontanées</h2>
        </div>
    </div>
</div>



<div class="row containerArticleHome">
    <h2 class="titleLatestArticles col-12">Les derniers articles...</h2>
    @foreach ($articles as $article)
            <div class=" positionButton col-12 col-md-6 col-lg-3 containerPresentation containerTheArticle">
                <div class="flex flex-col justify-content-center">
                    <img width="180px" height=auto class="align-self-center imagePresentation" src="{{$article->image_path}}" alt="trophee">
                    <h2 class="align-self-center titleArticleHome">{{$article->title}}</h2>
                </div>
                <br/>
                <p>{{\Illuminate\Support\Str::limit($article->description, 100)}}</p>
                <br/>
                <div>
                    <a class="btn seeMore" href="{{route('articles.show',$article->id)}}"> En savoir plus</a>
                </div>
            </div>
    @endforeach
</div>
<br/>

<?php echo realpath('chemin.php'); ?> 

@endsection