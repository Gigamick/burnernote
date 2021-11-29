@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="card p-4">
                        <p class="link npm ">{{$note->note}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2 text-center">
                    <p class="mt-4">This note has been permanently deleted</p>
                </div>
            </div>
        </div>
    </section>
@endsection