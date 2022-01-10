@extends('layouts.main')

@section('title', 'Presentation')

@section('description', "Présentation du nouveau concept @ Home a Game un jeu d'aventure hors du commun pour vivre l'expérience On The Road a Game près de chez soi ! Votre mission: relever un max de défis. Votre objectif: battre les autres et tenter de gagner un voyage.")

@section('titlePage'," Un jeu d'échanges et de découverte, pour vivre l'expérience On The Road a Game près de chez soi")

@section ('content')


<div class="row">
    <div class="col-12 containerPresentation" id="timer">
        <div class="flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/sablier.png" alt="sablier">
            <h2 class="align-self-center titlePresentation">Plusieurs sessions par an, limitées dans le temps</h2>
        </div>
        <br/>
            <p>Comme les voyages On The Road a Game, une session @ Home dure 10 jours. </p>
            <p>10 jours de challenges et de défis délirants, imaginés autour d'une thématique culturelle, sportive, d'actualité...</p>
            <br/>
            <p class="underline">Le coût de participation à une session s'élève à 10€.</p>
            <br/>
            <p>Vous pouvez évidemment participer à plusieurs sessions si vous le souhaitez et si vous vous sentez prêt à relever les défis !</p>
    </div>

    <div class="col-12 containerPresentation" id="challenge">
        <div class="flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/defis.png" alt="cible">
            <h2 class="align-self-center titlePresentation">Des défis à relever seul ou en équipe</h2>
        </div>
        <br/>
            <p>Au départ du jeu, nous proposons aux joueurs une série de défis. Le nombre de points attribués dépend de la difficulté du défi. A vous, donc, de trouver le juste équilibre entre le nombre et le degré de difficulté des défis que vous pensez pouvoir relever.</p>
            <p>Pour certains défis, des points bonus peuvent s'ajouter si vous êtes plus rapide, plus performant ou plus original que les autres...</p>
            <br/>
            <p>Pour réussir ces défis, il faudra fournir une preuve (photo ou vidéo selon les défis!) en la postant sur le défi correspondant. Votre preuve sera ensuite évaluée par nos administrateurs des défis qui vous attribueront des points.</p>
            <br/>
            <p>Vous n'avez pas remporté tous les points attribués au défi ? Pas de panique ! Vous pouvez toujours poster une nouvelle preuve. Mais attention : le risque existe aussi de faire moins bien ! &#128124 </p>
        </div>

    <div class="col-12 containerPresentation" id="gift">
        <div class="flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/cadeau.png" alt="cadeau">
            <h2 class="align-self-center titlePresentation">Des cadeaux à gagner à chaque session - Et un voyage à remporter chaque année !</h2>
        </div>
        <br/>
            <p>A la fin de chaque session, <span class="underline">le vainqueur remporté le lot mis en jeu.</span></p>
            <p>En cas d'ex-aequo, un tirage au sort est organisé pour déterminer le gagnant.</p>
            <p>Les 5 premiers du classement final de chaque session (ou, s'ils sont plus que 5, tous les participants ex-aequo à la première place du classement) se qualifient pour une session @Home Edition finale qui se déroulera à la fin de l'année 2022. </p>
            <br/>
            <p class="underline">Le gagnant de cette session finale remportera 1 voyage On The Road a Game ! </p>
            <br/>
            <p> <span class="underline">Bonus fidélité :</span> si vous participez à plusieurs sessions @ Home Edition durant l'année et que votre classement vous finissez plusieurs fois parmi les qualifiés, vous partirez avec un avantage lors de la session finale. &#128170 </p>
    </div>

    <div class="col-12 containerPresentation" id="city">
        <div class="flex flex-col justify-content-center">
            <img width="180px" height=auto class="align-self-center imagePresentation" src="/images/ville.png" alt="ville">
            <h2 class="align-self-center titlePresentation">Un moyen original de (re)découvrir sa région</h2>
        </div>
        <br/>
            <p>L’objectif de On The Road a Game est de vous faire revenir aux origines du voyage: la découverte, l'échange, la rencontre. </p>
            <p>Avec les sessions @ Home, nous vous proposons de goûter à l'esprit OTR... depuis chez vous !</p>
            <p>Les défis et challenges proposés vous invitent en effet à (re)découvrir votre région, votre voisinage, les artisans et commerçants locaux, des lieux insolites...</p>
            <p>Ludiques, participatifs, parfois déjantés, ces défis sont aussi parfaits pour créer des moments de rencontre, de partage et de fous-rires avec vos proches, vos amis, vos collègues... ou des parfaits inconnus ! </p>
            <p>Sans oublier que votre imagination, votre humour et votre capacité à relever ces challenges hors du commun peuvent vous permettre, au final, de remporter un voyage On The Road a Game ! &#128522</p>
    </div>
    
</div>

@endsection