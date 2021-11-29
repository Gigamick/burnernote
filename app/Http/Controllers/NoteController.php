<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mockery\Matcher\Not;
use Psr\Log\NullLogger;

class NoteController extends Controller
{
    public function create (Request $request)
    {
        if(Auth::check()) {
            $user = Auth::user();
        }

        $note = new Note();
        $note->note = $request->note;
        $note->password = $request->password ?? NULL;
        $note->user_id = $user->id ?? NULL;
        $note->token = Str::uuid();
        $note->save();

        return view('note-summary', compact('note'));
    }

    public function show ($token)
    {
        $note = Note::query()->where('token', $token)->first();

        if(! $note) {
            return view('deleted-note');
        }

        if($note->password != NULL) {
            return view('enter-password', compact('token'));
        }


        $deletednote = Note::query()->where('token', $token)->first();
        $deletednote->note = "";
        $deletednote->token = "";
        $deletednote->password = "";
        $deletednote->save();

        return view('note', compact('note'));
    }

    public function password (Request $request)
    {
        $check = Note::query()->where([
            ['token', $request->token],
            ['password',$request->password]
        ])->exists();

        if($check) {
            $note = Note::query()->where([
                ['token', $request->token],
                ['password',$request->password]
            ])->first();

            $note->password = NULL;
            $note->save();

            return redirect('/n/'.$request->token);
        };

    }
}
