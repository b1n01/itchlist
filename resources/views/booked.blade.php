@extends('layouts.app')

@section('head')
    <title>{{ config('app.name', 'Ithclist') }} | Booked items</title>
@endsection

@section('content')

    <section class="feed">
        @if(count($itches))
            <p id="feed-heading" class="feed-heading">
                Booked Itches
            </p>
            <div class="feed-items">
                @foreach ($itches as $itch)
                    <div class="feed-item {{ $itch->hidden ? 'hidden' : '' }}">
                        <img class="feed-pic" src="{{ $itch->pic ?: asset('images/loading-preview.svg')}}"alt="item preview">
                        <p class="feed-price">{{ $itch->price ?: ''}}</p>
                        <p class="feed-description">{{ $itch->description ?: $itch->url }}</p>
                        <div class="feed-booked-by">
                            <p>Added by {{ $itch->user->name }}</p>
                            <img src="{{ $itch->user->pic }}" class="feed-booked-by-pic" alt="user profile pic"/>
                        </div>
                        <div class="feed-overlay">
                            <div class=feed-actions>
                                <button class="feed-action feed-unbook" data-id="{{ $itch->id }}">Unbook</button>
                                <a class="feed-action" href="{{ $itch->url }}" target="_blank">Go to Amazon</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>   
        @else
            @if(Auth::check())
                <div class="feed-empty">
                    <p>Aw, Snap! You have no booked itches</p>
                </div>
            @endif
        @endif

    </section>

@endsection
