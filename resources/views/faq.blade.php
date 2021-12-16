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
                    <hr>
                    <h4 class="mt-3 fw700">How can I stop someone taking a screen shot?</h4>
                    <h4>In short, you can't. Taking screenshots is a function of the operating system and can't be
                        blocked or overridden by a website.</h4>
                    <h4>Further to that, even if it was possible there is no way to stop someone simply taking a
                        photograph of the screen. Or, even more simply writing out your note on paper. To that end Burner
                        Note and similar products make no effort to stop screenshots or copy / pasting. If the person
                        you're sending a note to wants to keep it bad enough then they will. One way or another.</h4>
                </div>
            </div>
        </div>
    </section>

@endsection