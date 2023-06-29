@extends('layout')
@section('content')
@include('partials._hero')
@include('partials._search')
<h1 class="text-center text-4xl">Listings</h1>
@if(count($listings)==0)
    <p>No Listings</p>
@endif

    <div
                class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4"
            >@foreach ($listings as $listing)
                <x-listing-card :listing="$listing"/>
                @endforeach
            </div>
            <div class="mt-6 p-4">
                {{$listings->links()}}
            </div>
@endsection
