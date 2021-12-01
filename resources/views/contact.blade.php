@extends('layouts.app')

@section('content')

    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <h2 class="text-muted mt-2 copy-note">Contact</h2>
                    <h4 class="my-3">We'd love to hear from you. Use the form below to say hi.</h4>
                    <form class=" mt-5" method="POST" action="https://submit-form.com/coj4IR32">
                    @csrf
                        <label>Your Email</label>
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="" placeholder="" value="" id="">
                        </div>
                        <label>Your Message</label>
                        <div class="input-group mb-3">
                            <textarea rows="5" name="message" class="" placeholder="" id=""></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <input type="submit" name="" class="btn btn-dark py-3" placeholder="" value="Send Message" id="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection