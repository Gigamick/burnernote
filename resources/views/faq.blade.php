@extends('layouts.app')

@section('content')

    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <h2 class="text-muted mt-2 copy-note">FAQs</h2>
                    <h4 class="mt-3 fw700">How does this product make money?</h4>
                    <h4>It doesn't. Making money isn't the point of this product. </h4>
                    <hr>
                    <h4 class="mt-3 fw700">Do you use Google Analytics?</h4>
                    <h4>Nope. We use <a href="https://plausible.io/?ref=burnernote">Plausible Analytics</a>. They are a
                        privacy first alternative to the big analytics players like Google.</h4>
                    <hr>
                    <h4 class="mt-3 fw700">Why are you open source?</h4>
                    <h4>To promote trust; so that people can see we do what we say we do.</h4>
                    <hr>
                    <h4 class="mt-3 fw700">How do I know the linked repo is really what is deployed?</h4>
                    <h4>I actually don't know how to prove that. It is a problem for any OSS I imagine. However I
                        promise you it is.</h4>
                </div>
            </div>
        </div>
    </section>

@endsection