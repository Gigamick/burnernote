<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery\Matcher\Not;
use Psr\Log\NullLogger;
use Illuminate\Support\Facades\Crypt;

class NoteController extends Controller
{
    public function create(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
        }

        $note = new Note();
        $sanitizednote = strip_tags($request->note);
        $note->note = Crypt::encryptString($sanitizednote);
        if ($request->password) {
            $note->password = Hash::make($request->password);
        } else {
            $note->password = null;
        }
        $note->user_id = $user->id ?? null;
        $note->token = Str::uuid();
        $note->save();

        return view('note-summary', compact('note'));
    }

    public function show($token)
    {
        $note = Note::query()->where('token', $token)->first();

        if (!$note) {
            return view('deleted-note');
        }

        if ($note->password != null) {
            return view('enter-password', compact('token'));
        }

        $actualnote = Crypt::decryptString($note->note);

        $deletednote = Note::query()->where('token', $token)->first();
        $deletednote->note = "";
        $deletednote->token = "";
        $deletednote->password = "";
        $deletednote->save();

        return view('note', compact('note', 'actualnote'));
    }

    public function password(Request $request)
    {

        $passwordcheck = Note::query()->where('token', $request->token)->first();
        $password = $passwordcheck->password;
        $verifypasswordtrue = Hash::check($request->password, $passwordcheck->password);

        if(! $verifypasswordtrue) {
            return back()->with('success', 'Incorrect password');
        }

        $check = Note::query()->where([
            ['token', $request->token],
            ['password', $password]
        ])->exists();

        if ($check) {
            $note = Note::query()->where([
                ['token', $request->token],
                ['password', $password]
            ])->first();

            $note->password = null;
            $note->save();

            return redirect('/n/'.$request->token);
        };

    }
}
