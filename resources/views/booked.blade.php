@extends('layouts.app')

@section('content')

    <section class="feed">
        @if(count($itches))
            <p id="feed-heading" class="feed-heading">
                Booked Itches
            </p>
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
                    <p>Aw, Snap! You have no booked itches</p>
                </div>
            @endif
        @endif

    </section>

@endsection
