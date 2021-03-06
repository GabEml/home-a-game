<!-- Stored in resources/views/layouts/app.blade.php -->

<html>
    <head>
        <title>@yield('title') - @ Home a Game</title>

        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="Home a Game, @Home a Game, OTR, On The Road a Game, jeu, défis, cadeaux, voyage">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Acme&family=Poppins:wght@100&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="icon" href="/images/logo.svg" />


        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">


        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        @livewireStyles

        <!-- Styles -->
        <style>
           .is-invalid {border:1px solid red}

        </style>

        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse align-items-center " id="navbarTogglerDemo03">
                <ul class=" menu navbar-nav mx-auto text-md-center text-left">
                    @if(config('app.app_domain') != 'otr')
                        <li class="nav-item">
                            <x-jet-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                                <h2 class="linkMenu">{{ __('Accueil @HOME') }}</h2>
                            </x-jet-nav-link>
                        </li>
                        <li class="nav-item">
                            <x-jet-nav-link href="{{ route('presentation') }}" :active="request()->routeIs('presentation')">
                                <h2 class="linkMenu">{{ __('Présentation du jeu') }}</h2>
                            </x-jet-nav-link>
                        </li>
                    @endif
                    <li class="nav-item">
                        <x-jet-nav-link href="{{ route('ranking') }}" :active="request()->routeIs('ranking')">
                            <h2 class="linkMenu">{{ __('Classement') }}</h2>
                        </x-jet-nav-link>
                    </li>
                    @auth
                    @if (Auth::check())
                    <li class="nav-item">
                        <x-jet-nav-link href="{{ route('sessiongames.index') }}" :active="request()->routeIs('sessiongames.index')">
                            <h2 class="linkMenu">{{ __('Soumettre un défi') }}</h2>
                        </x-jet-nav-link>
                    </li>
                    @endif
                    @if (Auth::user()->role->role==="User" && config('app.app_domain') != 'otr')
                    <li class="nav-item">
                        <x-jet-nav-link href="{{ route('sessiongameusers.create') }}" :active="request()->routeIs('sessiongameusers.create')">
                            <h2 class="linkMenu">{{ __("S'inscrire à une session") }}</h2>
                        </x-jet-nav-link>
                    </li>
                    @endif
                    @if (Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin")
                    <li class="nav-item">
                        <x-jet-nav-link href="{{ route('posts.indexPending') }}" :active="request()->routeIs('posts.indexPending')">
                            <h2 class="linkMenu">{{ __('Validation défis') }}</h2>
                        </x-jet-nav-link>
                    </li>
                    @endif
                    @if (Auth::user()->role->role==="Super Admin")
                    <li class="nav-item">
                        <x-jet-nav-link href="{{ route('users.indexUsers') }}" :active="request()->routeIs('users.indexUsers')">
                            <h2 class="linkMenu">{{ __('Utilisateurs') }}</h2>
                        </x-jet-nav-link>
                    </li>
                    @endif
                    @endif
                    @if (config('app.app_domain') != 'otr')
                        <li class="nav-item">
                            <x-jet-nav-link href="{{ route('goodies.index') }}" :active="request()->routeIs('goodies.index')">
                                <h2 class="linkMenu">{{ __('Goodies') }}</h2>
                            </x-jet-nav-link>
                        </li>
                    @endif
                    @if(config('app.app_domain') != 'otr')
                        <li class="nav-item">
                            <x-jet-nav-link href="https://www.ontheroadagame.fr/">
                                <h2 class="linkMenu">{{ __('On The Road') }}</h2>
                            </x-jet-nav-link>
                        </li>
                    @endif
                </ul>

            <div class="nav navbar-nav hiddenNavComputer">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="linkMenu">{{ Auth::user()->firstname }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('profile') }}">Mon Profil</a>
                      {{-- <a class="dropdown-item" href="{{ route('api-tokens.index')}}">API Token</a> --}}
                      <a class="dropdown-item" href="/deconnexion">Se déconnecter</a>
                    </div>
                  </li>
                @else
                    <div>
                        <x-jet-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                            <h2 class="link-auth">{{ __('Se connecter') }}</h2>
                        </x-jet-nav-link>
                    </div>
                    <div>
                        <x-jet-nav-link href="{{ route('registered') }}" :active="request()->routeIs('registered')">
                            <h2 class="link-auth"> {{ __("S'inscrire") }}</h2>
                        </x-jet-nav-link>
                    </div>
                @endif

            </div>
        </div>
        <div class="hiddenNavPhone">
            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="linkMenu">{{ Auth::user()->firstname }}</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('profile') }}">Mon Profil</a>
                      {{-- <a class="dropdown-item" href="{{ route('api-tokens.index')}}">API Token</a> --}}
                      <a class="dropdown-item" href="/deconnexion">Se déconnecter</a>

                    </div>
                  </li>
                @else
                    <div>
                        <x-jet-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                            <h2 class="link-auth linkMenuNotConnected">{{ __('Se connecter') }}</h2>
                        </x-jet-nav-link>
                    </div>
                    <div>
                        <x-jet-nav-link href="{{ route('registered') }}" :active="request()->routeIs('registered')">
                            <h2 class="link-auth linkMenuNotConnected linkRegister"> {{ __("S'inscrire") }}</h2>
                        </x-jet-nav-link>
                    </div>
                @endif
        </div>

      </nav>
      @if(Route::currentRouteName() === "home")
        <div class="logoImage flex flex-col">
            <div class="logo-image-banner">
                <div class="relative">
                    <a class="background"><img class="backgroundLogo" src="/images/otr-header.jpg"  alt="fond logo"></a>
                    <a class="logo" href="{{ route('home') }}"><img class="logo" src="/images/logo.svg"  alt="logo"></a>
                </div>
            </div>
            <div class="banner-text-box">
                {{-- <div class="banner-text-box-background"></div> --}}
                <div class="container">
                    <h1 class="h1 title">Découvrez @ Home a Game</h1>
                    <div class="discover">
                        @if(Auth::user())
                            <a href="{{ route('sessiongames.index') }}" target="_self" class="link-discover btn-play" style="border-radius:5px;">
                            <span>Jouer</span>
                            <i class="icon-angle-right"></i></a>

                            @if(config('app.app_domain') != 'otr')
                                <a href="{{ route('sessiongameusers.create') }}" target="_self" class="link-discover btn-join" style="border-radius:5px;">
                                    <span>Rejoindre une session</span>
                                    <i class="icon-angle-right"></i>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" target="_self" class="link-discover" style="border-radius:5px;">
                            <span>Participer</span>
                            <i class="icon-angle-right"></i></a>
                        @endif
                    </div>
                    <h2 style="font-size: 35px:">Voyagez chez vous !</h2>
                </div>
            </div>
        </div>
        @else
        <div class="little-banner flex flex-col">
                <a href="https://at-home.ontheroadagame.fr"><img class="backgroundLogo" src="/images/fond.png" alt="fond logo"></a>
                <a class="logo" href="https://at-home.ontheroadagame.fr"><img class="logo" src="/images/logo.svg" alt="logo"></a>
        </div>
        @endif
        <div class="homepage-title">
            <h1 class="h1 title"> @yield('titlePage') </h1>
        </div>
        <div class="container">

            @yield('content')
        </div>

        @stack('modals')

        @livewireScripts
        <br/>
        <div class="spacer"></div>
        <footer class="bg-dark text-light footer">
            <div class="container-fluid">
                 <div class="flex justify-content-center">
                     <div class="logoNetworks text-center flex align-self-center">
                        <a target="_blank" href="https://www.facebook.com/otragame/"> <img src="/images/facebook.png" alt="Facebook" class="logoNetworkImage"> </a>
                        <a target="_blank" href="https://www.instagram.com/otragame/"> <img src="/images/instagram.png" alt="Instagram" class="logoNetworkImage"> </a>
                        <a target="_blank" href="mailto:organisation@ontheroadagame.fr"><img src="/images/mail.png" alt="Mail" class="logoNetworkImage"></a>
                         <a target="_blank" href="https://www.youtube.com/channel/UCJeonm8g5Ms75PpBPPpZJLw"> <img src="/images/youtube.png" alt="Youtube" class=" logoNetworkImage"> </a>
                     </div>
                 </div>
                     <div class="col-12 d-flex justify-content-center small">
                        <p class="textFooter mb-0 text-center">
                            Copyright 2021 &copy; OTR | Tous droits réservés |
                            <a class="linkFooter" href="https://www.ontheroadagame.fr/mentions-legales-et-politique-de-confidentialite/">
                                Mentions légales & politique de confidentialité</a> |
                            <a class="linkFooter" href="https://www.ontheroadagame.fr/conditions-generales-vente/">Conditions Générales et
                                Particulières de Vente</a>
                            <br />
                            <a class="linkFooter" href="https://www.ontheroadagame.fr/wp-content/uploads/2021/11/2021-11-02-Reglement-On-The-Road-a-Game-At-Home-Edition.pdf"
                                target=_blank>Règlement du jeu On The Road a Game @ Home Edition</a>
                        </p>
                     </div>
             </div><!--End container-fluid in footer-->
        </footer><!--end of main Footer-->
    </body>
</html>
