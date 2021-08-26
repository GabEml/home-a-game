@extends('layouts.main')

@section('title', 'Accueil')

@section('description',"Découvrez @ Home a Game un jeu d'aventure hors du commun pour vivre l'expérience On The Road a Game près de chez soi ! Votre mission: relever un max de défis. Votre objectif: battre les autres et tenter de gagner un voyage.")

@section('titlePage'," @ Home a Game : un jeu d'aventure hors du commun pour vivre l'expérience OTR près de chez soi")

@section ('content')


<div class="row containerHome">
    <div class=" col-12 col-md-6 col-lg-3 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="190px" height=auto class="align-self-center imagePresentation imagePresentationTimer" src="/images/sablier.png" alt="sablier">
            <h2 class="align-self-center titlePresentation">Plusieurs sessions par an, limitées dans le temps</h2>
        </div>
    </div>

    <div class=" col-12 col-md-6 col-lg-3 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation imagePresentationTarget" src="/images/defis.png" alt="cible">
            <h2 class="align-self-center titlePresentation">Des défis à relever seul ou en équipe</h2>
        </div>
    </div>

    <div class=" col-12 col-md-6 col-lg-3 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation imagePresentationGift" src="/images/cadeau.png" alt="cadeau">
            <h2 class="align-self-center titlePresentation">Des cadeaux à gagner à chaque session</h2>
        </div>
    </div>

    <div class=" col-12 col-md-6 col-lg-3 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation imagePresentationMap" src="/images/ville.png" alt="ville">
            <h2 class="align-self-center titlePresentation">Un moyen original de (re)découvrir sa région</h2>
        </div>
    </div>

</div>
<div class="row containerHome">
    
    <div class=" col-12 col-md-6 col-lg-4 d-flex containerPresentation">
        <div class="centerImageHome flex flex-col justify-content-center">
            <img width="350px" height=auto class="align-self-center imagePresentation" src="/images/ontheroadagame.png" alt="On The Road a Game">
            <h2 class="align-self-center titlePresentation">Un voyage On The Road a Game à gagner chaque année*</h2>
            <br/>
            <small class="italic">*Lot attribué par tirage au sort entre les vainqueurs de toutes les sessions</small>
        </div>
    </div>

</div>


{{-- <div class="row containerArticleHome">
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
</div> --}}
<br/>

<?php echo realpath('chemin.php'); ?> 

@endsection