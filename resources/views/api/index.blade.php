@extends('layouts.main')

@section('title', 'API Token')

@section('titlePage', 'API Token')

@section ('content')
 
    <div>
        <div class=" containerAPI max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('api.api-token-manager')
        </div>
    </div>


@endsection
