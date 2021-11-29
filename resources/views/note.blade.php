@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="card p-4">
                        <p class="npm ">{!!  nl2br( $actualnote ) !!}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2 text-center">
                    <p class="mt-4 mb-0">This note has now been permanently deleted</p>
                    <a href="/" class="text-muted mt-1"><u>Create your own Burner Note</u></a>
                </div>
            </div>
        </div>
    </section>
@endsection