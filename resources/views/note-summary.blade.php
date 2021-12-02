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
                        <p class="link npm ">{{env('APP_URL')}}/v/{{$note->token}}</p>
                    </div>
                </div>
                <div class="col-12 col-md-8 offset-md-2 text-center">
                    <p class="text-muted mt-2 copy-note">Click on the link to copy it</p>
                    <p class="text-muted mt-2 copy-success font-red font-weight-bold" style="display: none">Copied</p>
                </div>
            </div>
        </div>
    </section>
    <script>
        var clipboard = new ClipboardJS('.copy');

        clipboard.on('success', function (e) {
            $(".copy-success").show();
            $(".copy-note").hide();
            e.clearSelection();
        });
    </script>
@endsection