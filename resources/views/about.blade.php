@extends('layouts.app')

@section('content')

    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <h2 class="text-muted mt-2 copy-note">The Story</h2>
                    <h4 class="mt-3 font-italic text-muted">TL;DR
                        <ul class="mt-3">
                            <li>We encrypt your note using an AES-256-CBC cipher</li>
                            <li>We delete it from our
                                database once its been read
                            </li>
                            <li>You can verify this yourself because Burner Note is open source</li>
                        </ul>
                    </h4>
                    <hr>
                    <h4 class="mt-3">Burner note came into existing after years of using other products that claim to do
                        something similar. However their pages are laden with ads, have a poor UI, and you can't know for
                        sure if they really are actually encrypting / deleting anything.</h4>
                    <h4 class="mt-3"> As a developer I wanted to build something better; something more useable and
                        technically transparent, and that's what Burner Note is.</h4>
                    <h4 class="mt-3">The good stuff... Burner Note is open source. Go and check out the code. If you
                        can't be bothered doing that then I can tell you that from browser to server we are relying on good old
                        SSL. On the back end we utilise <a href="https://laravel.com/docs/8.x/encryption"
                                                           target="_blank">Laravel's out of the box encryption
                            protocols</a> which are recognised as being both excellent and are also open source.</h4>
                    <h4 class="mt-3">On clicking the link and opening your note, it is deleted instantly and completely
                        from our database. Gone forever.</h4>
                    <h4 class="mt-3">Pretty simple really.</h4>
                </div>
            </div>
        </div>
    </section>

@endsection