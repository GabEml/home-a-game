@extends('layouts.main')

@section('title', 'Mon Profil')

@section('titlePage', 'Mon Profil')

@section ('content')

    <div>
        <div class="profile max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border />
            @endif
           
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.generate-stats-code-influenceur')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.delete-user-form')
            </div>
        </div>
    </div>
@endsection
