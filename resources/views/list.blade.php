@extends('layouts.app')

@section('content')
    
    <section class="feed">

        <p class="feed-heading"><img class="heading-pic" src="{{ $user->pic }}">{{ $user->name }}'s itchlist</p>

        <div class="feed-items">
            @foreach ($itches as $itch)
            <div class="feed-item">
                    <img class="feed-pic" src="{{ $itch->pic ?: asset('images/loading-preview.svg')}}">
                    <p class="feed-price">{{ $itch->price ?: ''}}</p>
                    <p class="feed-description">{{ $itch->description ?: 'See on Amazon' }}</p>
                    <div class="feed-overlay">
                        <div class=feed-actions>

                            @if(!Auth::check())
                                <!--<span 
                                    class="feed-action feed-action-disabled"
                                    data-tooltip="You must sign in first">
                                        Book
                                </span>-->
                            @elseif(!$areFriends)
                                <!--<span 
                                    class="feed-action feed-action-disabled"
                                    data-tooltip="You can only book for your friends">
                                        Book
                                </span>-->
                            @else
                                <!--<button id="feed-book" class="feed-action feed-book" data-id="{{ $itch->id }}">Book</button>-->
                            @endif
                            <a class="feed-action" href="{{ $itch->url }}" target="_blank">Go to Amazon</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection
