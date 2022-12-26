<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * STEP MAKING MAILER
     * 1. php artisan make:mail NamaMail
     * 2. Buat function di controller ini
     * 3. Tempelkan ke route web.php
     */

    public function index()
    {
        $details = [
            'title' => 'Mail from Beehive',
            'body' => ' '
        ];

        Mail::to('enricoadi49@gmail.com')->send(new \App\Mail\TestMail($details));

        dd("Email sudah terkirim.");
    }

    public static function verificationMail($email, $nama, $code)
    {
        $details = [
            'title' => 'Confirmation Account Registration',
            'body' => ' ',
            "email" => $email,
            "nama" => $nama,
            "code" => $code
        ];
        Mail::to($email)->send(new \App\Mail\VerificationRegisterMail($details));
    }
    public static function forgotPasswordMail($email, $nama, $code)
    {
        $details = [
            'title' => 'Forgot password',
            'body' => ' ',
            "email" => $email,
            "nama" => $nama,
            "code" => $code
        ];
        Mail::to($email)->send(new \App\Mail\ForgotPasswordMail($details));
    }
}
