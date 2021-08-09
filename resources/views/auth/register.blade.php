<x-guest-layout>
    <x-jet-authentication-card>
        
        <x-slot name="logo">
            <div class="logoRegister flex flex-col">
            <x-jet-authentication-card-logo />
            <h1 class="h1 title"> Créer son compte </h1>
            <p class="description ">Entrez vos informations personnelles</p>
        </div>
        </x-slot>
        

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="flex registrationForm">
                <div class="fields">
                    <div>
                        <x-jet-label for="firstname" value="{{ __('Prénom') }}" />
                        <x-jet-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="lastname" value="{{ __('Nom') }}" />
                        <x-jet-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="date_of_birth" value="{{ __('Date de naissance') }}" />
                        <x-jet-input id="date_of_birth" :value="old('date_of_birth')" class="block mt-1 w-full" type="date" name="date_of_birth" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Mot de passe') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirmation du mot de passe') }}" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>
                </div>
                <div class="fields">
                    <div>
                        <x-jet-label for="phone" value="{{ __('Numéro de téléphone') }}" />
                        <x-jet-input pattern="0[1-9][0-9]{8}" id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="address" value="{{ __('Adresse') }}" />
                        <x-jet-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="postal_code" value="{{ __('Code Postal') }}" />
                        <x-jet-input pattern="[0-9]{5}" id="postal_code" class="block mt-1 w-full" :value="old('postal_code')" type="text" name="postal_code" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="city" value="{{ __('Ville') }}" />
                        <x-jet-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="country" value="{{ __('Pays') }}" />
                        <x-jet-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')" required />
                    </div>
                </div>

            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Déjà enregistré ?') }}
                </a>

                <x-jet-button class="ml-4 buttonValidate">
                    {{ __('Valider') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
<br/><br/>
