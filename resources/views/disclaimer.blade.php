@extends('layouts.app')

@section('content')
    <section class="hero mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2 text-center">
                    <h4 class="mt-4 mb-0 text-muted">You've been sent a self destructing note.</h4>
                    <h4 class="mt-1 text-muted">This note can only be accessed once.</h4>
                    <a href="/n/{{$token}}" class="btn btn-dark mt-4 py-3 px-5">Show Me The Note</a>
                </div>
            </div>
        </div>
    </section>
@endsection