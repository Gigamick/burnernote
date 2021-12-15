@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
    <script>
        new ClipboardJS('.copy');
    </script>
    <section class="hero mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2 text-center">
                    <h4 class="mb-2">Here's your link:</h4>
                    <div data-clipboard-target=".link"
                         class="card copy pointer p-4 d-flex justify-content-center align-items-center">
                        <p class="link npm ">{{env('APP_URL')}}/v/{{$note->token}}</p>
                    </div>
                </div>
                <div class="col-12 col-md-8 offset-md-2 text-center">
                    <p class="text-muted mt-2 copy-note">Click on the link to copy it</p>
                    <p class="text-muted mt-2 copy-success font-red font-weight-bold" style="display: none">Copied</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-md-6 offset-md-3">
                    <div class="row">
{{--                        <div class="col-12 col-md-6">--}}
{{--                            <form class="" method="post" action="/send-sms">--}}
{{--                                @csrf--}}
{{--                                <label>Send link by SMS</label>--}}
{{--                                <p class="m-0 p-0 text-muted">International format eg +441234511234</p>--}}
{{--                                <div class="input-group mb-2">--}}
{{--                                    <input required type="tel" name="phonenumber" class=""--}}
{{--                                           placeholder="Eg +447900000000"--}}
{{--                                           value="" id="">--}}
{{--                                </div>--}}
{{--                                <input type="hidden" name="link" class="" placeholder=""--}}
{{--                                       value="{{env('APP_URL')}}/v/{{$note->token}}" id="">--}}
{{--                                <div class="input-group mb-3">--}}
{{--                                    <input type="submit" name="" class="btn btn-dark" placeholder="" value="Send SMS" id="">--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
                        <div class="col-12">
                            <form class="" method="post" action="/send-email">
                                @csrf
                                <label>Or send link by email</label>
                                <p class="m-0 p-0 text-muted">Enter email address below</p>
                                <div class="input-group mb-2">
                                    <input type="email" name="email" class="" placeholder="Eg hello@burnernote.com" value=""
                                           id="">
                                </div>
                                <input type="hidden" name="link" class="" placeholder=""
                                       value="{{env('APP_URL')}}/v/{{$note->token}}" id="">
                                <div class="input-group mb-3">
                                    <input type="submit" name="" class="btn btn-dark" placeholder="" value="Send Email" id="">
                                </div>
                            </form>
                        </div>
                    </div>

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