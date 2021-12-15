<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SendGrid\Mail\Mail;
use Twilio\Rest\Client;

class EmailController extends Controller
{
    public function sendemail(Request $request)
    {
        $email = new Mail();
        $email->setFrom("noreply@burnernote.com", "Burner Note");
        $email->setSubject("A link from Burner Note");
        $email->addTo($request->email);
        $email->addContent("text/plain", "You've been sent a note from Burner Note: ".$request->link);

        $sendgrid = new \SendGrid(env('SENDGRID_APIKEY'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }

        return view('email-sent');
    }

    public function sendsms(Request $request)
    {
        $client = new Client(env('TWILIO_ACCOUNT_ID'), env('TWILIO_AUTH_TOKEN'));
        $client->messages->create(

            $request->phonenumber,
            array(
                'from' => env('TWILIO_NUMBER'),
                'body' => 'Someone sent you a note from Burner Note: '.$request->link
            )
        );

        return view('sms-sent');
    }
}
