@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add an itch</div>
                <form action="{{ route('itch.add') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <input name="provider-url" placeholder="paste amazon link"></input>
                    </div>
                    <div class="card-body">
                        <button>save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
