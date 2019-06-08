@extends('layouts.app')

@section('content')

<div class="account">
    <p class="account-heading">{{ $user->name }} account</p>

    <div class="account-content">
        <p>Here you can delete your account</p>
        <p>WARNING: all your data will be removed</p>
        <input id="account-delete-input" class="account-delete-input" placeholder="Write '{{ $user->name }}' to delete"></input>
        <button id="account-delete" class="account-delete" data-passphrase="{{ $user->name }}" data-confirm="false">Delete</button>
        <span id="account-delete-label" class="account-delete-label">Wrong passphrase</span>
    </div>
</div>

@endsection
