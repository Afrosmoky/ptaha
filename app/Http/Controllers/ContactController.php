<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // honeypot
        if ($request->filled('company')) {
            return back();
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::raw(
            "Imię: {$data['name']}\nEmail: {$data['email']}\n\n{$data['message']}",
            function ($mail) use ($data) {
                $mail->to(config('mail.from.address'))
                    ->replyTo($data['email'])
                    ->subject('Wiadomość ze strony PTAHA');
            }
        );

        return back()->with('success', 'Dziękujemy za wiadomość. Skontaktujemy się wkrótce.');
    }
}
