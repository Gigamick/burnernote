@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
    <script>
        new ClipboardJS('.copy');
    </script>
    <section class="hero mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <div data-clipboard-target=".link"  class="card copy pointer p-4 d-flex justify-content-center align-items-center">
                        <p class="m-0 p-0">We've sent your link to the email address number you supplied.</p>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-8 offset-md-2 text-center">
                    <a href="/" class="text-muted mt-4"><u>Create another Burner Note</u></a>
                </div>
            </div>
        </div>
    </section>
@endsection