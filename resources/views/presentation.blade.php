@extends('layouts.main')

@section('title', 'Presentation')

@section('description', "Présentation du nouveau concept @ Home a Game un jeu d'aventure hors du commun pour vivre l'expérience On The Road a Game près de chez soi ! Votre mission: relever un max de défis. Votre objectif: battre les autres et tenter de gagner un voyage.")

@section('titlePage'," @ Home a Game : un jeu d'aventure hors du commun pour vivre l'expérience OTR près de chez soi")

@section ('content')


<div class="row">
    <div class="col-12 containerPresentation">
        <div class="flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/sablier.png" alt="sablier">
            <h2 class="align-self-center titlePresentation">Plusieurs sessions par an, limitées dans le temps</h2>
        </div>
        <br/>
            <p>A la différence de On The Road A Game, une session dure de 8 à 12 semaines pour seulement 40€. Chaque joueur est maître de son aventure et ce, durant toute la durée du jeu.</p>
           <br/>
            <p>Vous pouvez évidemment participer à plusieurs sessions si vous le souhaitez et si vous vous sentez prêt à relever les défis !</p>
    </div>

    <div class="col-12 containerPresentation">
        <div class="flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/defis.png" alt="cible">
            <h2 class="align-self-center titlePresentation">Des défis à relever seul ou en équipe</h2>
        </div>
        <br/>
            <p>Au départ du jeu, nous proposons aux joueurs une série de défis. Le nombre de points attribués dépend de la difficulté du défi. A vous, donc, de trouver le juste équilibre entre le nombre et le degré de difficulté des défis que vous pensez pouvoir relever.</p>
            <br/>
            <p>Pour réussir ces défis, il faudra fournir une preuve (photo ou vidéo selon les défis!) en la postant sur le défi correspondant. Il sera ensuite évalué par nos administrateurs des déifs et nous vous mettrons un nombre de points et un commentaire</p>
            <br/>
            <p>Vous n'avez pas tous les points ? Pas de panique ! Vous pouvez toujours poster à nouveau au risque de faire moins bien !</p>
        </div>

    <div class="col-12 containerPresentation">
        <div class="flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/cadeau.png" alt="cadeau">
            <h2 class="align-self-center titlePresentation">Des cadeaux à gagner à chaque session</h2>
        </div>
        <br/>
            <p>A la fin de chaque session, le vainqueur de chaque session se qualifie pour un tirage au sort qui permet de gagner 1 voyage On The Road a Game ! Pas d'inquiétude, une dotation en goodies récompense les participants les mieux classés de chaque session </p>
            <br/>
            <p>Comme dit précédemment vous pouvez participer à plusieurs sessions, mais si vous êtes le grand vainqueur de plusieurs sessions, vous ne pouvez participer qu'une fois au tirage au sort</p>
    </div>

    <div class="col-12 containerPresentation">
        <div class="flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/ville.png" alt="ville">
            <h2 class="align-self-center titlePresentation">Un moyen original de (re)découvrir sa région</h2>
        </div>
        <br/>
            <p>L’objectif de On The Road a Game, c’est de vous faire revenir aux origines du voyage: la découverte. Mais avec la crise sanitaire actuelle, le but de Home A Game est de vous permettre de goûter à l’esprit des voyages On The Road a Game sans devoir voyager, en restant chez soi ! </p>
            <br/>
            <p>Cela vous permettra également la découverte de vous-même et de votre ville que peut-être vous ne connaissez pas vraiment ! De votre imagination, de votre humour et de votre capacité à relever les challenges hors du commun.</p>
    </div>
    
</div>

@endsection