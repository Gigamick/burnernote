@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12">

                </div>
            </div>
        </div>
    </section>
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <form class="" method="post" action="/submit-password">
                        @csrf
                        <label class="">Enter Password</label>
                        <div class="input-group mb-3">
                            <input type="text" name="password" class="" placeholder="" value="" id="">
                        </div>
                        <input type="hidden" name="token" class="" placeholder="" value="{{$token}}" id="">
                        <div class="input-group mb-3">
                            <input type="submit" name="" class="btn btn-dark" placeholder="" value="Submit" id="">
                        </div>

                    </form>
                    @if(session('success'))
                        <p>Wrong Password</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection