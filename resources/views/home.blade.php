@extends('layouts.app')

@section('content')

    @if(!Auth::check())
        <div class="wellcome">
            <p class="wellcome-title">Itchlist</p>
            <p class="wellcome-separator">:</p>
            <p class="wellcome-subtitle">a better wishlist</p>
        </div>
    @endif
        
    <section class="feed">

        @if(Auth::check())
            <p id="feed-heading" class="feed-heading">
                Your itchlist&nbsp;|&nbsp;
                <span id="feed-add">
                    <i class="fas fa-plus heading-icon"></i>
                    <span class="heading-action">Add</span>&nbsp;|&nbsp;
                </span>
                <span id="feed-share">
                    <i class="fas fa-share-alt heading-icon"></i>
                    <span class="heading-action">Share</span>
                    <span id="share-list" data-share="{{ 'http:' . route('list') . '/' . auth()->user()->uuid }}"></span>
                </span>
            </p>
            <p id="feed-heading-copied" class="feed-heading" style="display: none;">
                <span id="feed-share">
                    <span>Url copied to clipboard</span>
                </span>
            </p>

            <div id="list-add" class="list-add">
                <input id="list-add-input" class="list-add-input" name="provider-url" placeholder="Paste Amazon link"></input>
                <button id="list-add-button" class="list-add-button">Save</button>
            </div>
        @else
            <p class="feed-heading">Recently added</p>
        @endif

        <div class="feed-items">
            @foreach ($itches as $itch)
           
                <div class="feed-item">
                    <img class="feed-pic" src="{{ $itch->pic ?: asset('images/loading-preview.svg')}}">
                    <p class="feed-price">{{ $itch->price ?: ''}}</p>
                    <p class="feed-description">{{ $itch->description ?: 'See on Amazon' }}</p>
                    <div class="feed-overlay">
                        <div class=feed-actions>
                            @if(Auth::check())
                                <!--<button class="feed-action feed-hide" data-id="{{ $itch->id }}">Hide</button>-->
                                <button class="feed-action feed-delete" data-id="{{ $itch->id }}">Delete</button>
                            @endif
                            <a class="feed-action" href="{{ $itch->url }}" target="_blank">Go to Amazon</a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </section>

@endsection
