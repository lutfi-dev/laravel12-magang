<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use ReCaptcha\ReCaptcha;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required',
        ]);

        // Validasi ReCAPTCHA
        $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
        $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());
        if (!$response->isSuccess()) {
            return back()->withErrors(['g-recaptcha-response' => 'ReCAPTCHA verification failed.']);
        }

        // Kirim email
        Mail::raw($request->message, function ($message) use ($request) {
            $message->to('raflycyber69@gmail.com')
                    ->subject('Pesan dari ' . $request->name)
                    ->from($request->email);
        });

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }
}
