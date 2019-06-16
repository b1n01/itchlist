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
                    <span id="share-list" data-share="{{ route('list') . '/' . auth()->user()->uuid }}"></span>
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
            @if(count($itches))
                <p class="feed-heading">Recently added</p>
            @endif
        @endif

        @if(count($itches))
            <div class="feed-items">
                @foreach ($itches as $itch)
                    <div class="feed-item {{ $itch->hidden ? 'hidden' : '' }}">
                        <img class="feed-pic" src="{{ $itch->pic ?: asset('images/loading-preview.svg')}}">
                        <p class="feed-price">{{ $itch->price ?: ''}}</p>
                        <p class="feed-description">{{ $itch->description ?: $itch->url }}</p>
                        <div class="feed-overlay">
                            <div class=feed-actions>
                                @if(Auth::check())
                                    @if($itch->hidden)
                                        <button class="feed-action feed-show" data-id="{{ $itch->id }}">Show</button>
                                    @else
                                        <button class="feed-action feed-hide" data-id="{{ $itch->id }}">Hide</button>
                                    @endif
                                    <button class="feed-action feed-delete" data-id="{{ $itch->id }}">Delete</button>
                                @endif
                                <a class="feed-action" href="{{ $itch->url }}" target="_blank">Go to Amazon</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>   
        @else
            @if(Auth::check())
                <div class="feed-empty">
                    <p>Hi! Looks like you are new here</p>
                    <p>Use '+ ADD' to add items to your list</p>
                </div>
            @endif
        @endif

    </section>

@endsection
