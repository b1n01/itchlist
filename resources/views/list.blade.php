@extends('layouts.app')

@section('content')
    
    <section class="feed">

        <p class="feed-heading"><img class="heading-pic" src="{{ $user->pic }}">{{ $user->name }}'s itchlist</p>

        <div class="feed-items">
            @foreach ($itches as $itch)
            <div class="feed-item">
                    <img class="feed-pic" src="{{ $itch->pic ?: asset('images/loading-preview.svg')}}">
                    <p class="feed-price">{{ $itch->price ?: ''}}</p>
                    <p class="feed-description">{{ $itch->description ?: $itch->url }}</p>
                    @if($itch->booked_by)
                        <div class="feed-booked-by">
                            <p>Booked by {{ $itch->bookedBy->name }}</p>
                            <img src="{{ $itch->bookedBy->pic }}" class="feed-booked-by-pic" />
                        </div>
                    @endif
                    <div class="feed-overlay">
                        <div class=feed-actions>

                            @if($itch->booked_by == Auth::user()->id)
                                <button class="feed-action feed-unbook" data-id="{{ $itch->id }}">Unbook</button>
                            @elseif($itch->booked_by)
                                <span 
                                    class="feed-action feed-action-disabled"
                                    data-tooltip="Someone already booked this">
                                        Book
                                </span>
                            @elseif(!Auth::check())
                                <span 
                                    class="feed-action feed-action-disabled"
                                    data-tooltip="You must sign in first">
                                        Book
                                </span>
                            @elseif(!$areFriends)
                                <span 
                                    class="feed-action feed-action-disabled"
                                    data-tooltip="You can only book for your friends">
                                        Book
                                </span>
                            @else
                                <button class="feed-action feed-book" data-id="{{ $itch->id }}">Book</button>
                            @endif

                            <a class="feed-action" href="{{ $itch->url }}" target="_blank">Go to Amazon</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection
