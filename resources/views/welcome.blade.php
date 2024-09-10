@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2 pt-4 text-center">
                    <h1 class="fw700">Send secure and encrypted notes that self destruct once they've been read</h1>
                    <h5 class="mt-4">Burner Note is a free, ad-free and open sourced service for sending secure text
                        based notes that are completely erased from existence once they've been read.</h5>
                    <div class="row">
                        <div class="col-12">
                            <p class="mt-0 text-muted">Utilising AES-256-CBC encryption signed with a message
                                authentication
                                code (MAC).</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <form class="" method="post" action="/create-note">
                        @csrf
                        <label>Create your note</label>
                        <div class="input-group mb-3">
                            <textarea rows="4" name="note" class="" placeholder="" id="" required></textarea>
                        </div>
                        <label class="">Create an optional password</label>
                        <p class="text-muted npm">Leave blank if you do not require password protection</p>
                        <div class="input-group mb-3">
                            <input type="text" name="password" class="" placeholder="" value="" id="">
                        </div>
                        <label class="">Days till auto self destruct</label>
                        <p class="text-muted npm">The note will expire after a set number of days</p>
                        <div class="input-group mb-3">
                            <input type="number" min="1" name="expiry" class="" placeholder="" value="7" id="">
                        </div>
                        <div class="input-group mb-3">
                            <input type="submit" name="" class="btn btn-dark py-3" placeholder="" value="Get Link"
                                   id="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div class="fixed-bottom py-3 border-top">
        <div class="d-flex justify-content-center align-items-center">
            <style>
                .pizzabtn {
                    background: #333333;
                    border-radius: 7px;
                    font-size: 12px;
                    color: white;
                    padding: 0px 10px;
                    font-weight: bold;
                    height: 32px;
                }

                .pizzabtn:hover {
                    text-decoration: none;
                    color: white;
                }
            </style>
            <div class="d-flex justify-content-center text-align-center">
                <a href="https://buymeacoffee.com/gigamick" target="_blank"
                   class="pizzabtn d-flex align-items-center">&#x1F355; Buy me a Pizza</a>
            </div>
            <div class="spacer mx-4">|</div>
            {{--                        <a href="buymeacoffee.com/gigamick" class="text-muted">Sponsor on Github</a>--}}
            <a href="https://github.com/sponsors/Gigamick" target="_blank"
               class="pizzabtn d-flex align-items-center" style="gap: 8px">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-github" viewBox="0 0 16 16">
                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                </svg>
                Sponsor on Github</a>
        </div>
    </div>

@endsection