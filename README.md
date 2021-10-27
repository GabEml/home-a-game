# Home A Game

## Concept 

### L'entreprise

Depuis plus de 7 ans, On The Road A Game organise des voyages qui mêlent mystères, jeux, aventures et surtout rencontres humaines et culturelles.
Le concept unique de On The Road A Game permet à ses participants de revenir aux origines du voyage : la découverte des autres.
Lorsqu’un voyageur se lance dans une session de On The Road a Game, il ne sait pas où il va.
Il s’agit donc d’un véritable voyage-mystère, couplé à un jeu entre équipes qui vient pimenter
cette expérience hors du commun.

### Principe 

On participe à On The Road a Game en équipe de 2 personnes, il n’y a pas d’élimination.
L’équipe gagnante est déterminée sur la base de défis à relever et d’un budget à (ne pas) dépenser.
Au départ du jeu, une série de défis est proposée aux équipes. Le nombre de points attribués dépend de la difficulté du défi. A elles, donc, de trouver le juste équilibre entre le nombre et le degré de difficulté des défis qu’elles pensent pouvoir relever.
A cela, s’ajoute une gestion budgétaire.
Chaque équipe démarre le jeu avec une enveloppe limitée. Et chaque Euro ramené à l’arrivée permet de décrocher des points bonus.
La somme excédentaire totale récoltée à l’issue du jeu est reversée à une association caritative, choisie par l’équipe gagnante


### Problématique 

La crise sanitaire a entraîné l’annulation des 4 voyages OTR prévus en 2020, entraînant une perte de chiffre d’affaire conséquente et un ralentissement du processus de développement de la marque.


### Solution 

Dès la mi-2021, sera lancé le concept Home a Game, qui permettra de goûter à l’esprit des voyages On The Road a Game sans devoir voyager, en restant chez soi !

- Chaque session Home a Game dure 8 à 12 semaines.
- 4 sessions de Home a Game sont prévues chaque année.
- Lors du lancement de la session, une dizaine de défis sont proposés aux participants.
- Les défis sont pensés dans l’esprit des challenges qui sont relevés par les voyageurs lors d’un voyage OTR et ont pour but de pousser à la rencontre, à la découverte, à la créativité…
- Chaque défi rapporte un nombre de points défini à l’avance.
- Les participants doivent valider chaque défi en soumettant une photo ou une vidéo qui prouve sa bonne réalisation.
- A la fin de chaque session, un classement général est établi.
- Une dotation en goodies récompense les participants les mieux classés de chaque session.
- Le vainqueur de chaque session se qualifie pour un tirage au sort qui permet de gagner 1 voyage On The Road a Game.


## Lancer le projet

### Création d'une base de données, 

Vous aurez à créer une base de données dans MySQL : 
`sudo mysql`
Une fois dans mysql 

```sql 
CREATE DATABASE homeagame;
 -- CREATE USER  laravel@localhost IDENTIFIED BY 'L4R4V3l' ; --  À faire si vous n'avez pas déjà un utilisateur autre que root
 -- On donne les droit à l'utilisateur
 GRANT ALL ON homeagame.* TO laravel@localhost; 
```

Copier le fichier `.env.example` en `.env` : 

Et remplissez les informations propres à la BDD. 


Installer le projet à l'aide de composer : 
```sh
composer install
```

Créer une clé pour le .env
```sh
php artisan key:generate
```

Lancer les migrations : 
```sh
php artisan migrate
```

Si problème de migration il y'a, passer la variable d'environnement "NEW_PROJECT_PROBLEM" à true : 

Puis remplissez la base
```sh
php artisan db:seed
```



Puis lancer le projet : 
```sh
php artisan serve
```

Vous y accéderez sur : http://127.0.0.1:8000/

Vous pourrez ensuite créer un compte, vous serez un simple utilisateur, vous pourrez sous inscrire à une session, y participer.

Si vous voulez tester en tant qu'administrateur des défis : 
- Mail : admin@defis.com 
- Mot de passe : admindefis

Si vous voulez tester en tant que super Administrateur : 
- Mail : super@admin.com 
- Mot de passe : superadmin



