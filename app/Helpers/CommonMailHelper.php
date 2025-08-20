<?php

namespace App\Helpers;

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CommonMailHelper
{
    public static function send($to, $subject, $body)
    {
        try {
            Mail::to($to)->send(new TestMail($subject, $body));
            return true;
        } catch (\Exception $e) {
            Log::error('Email send failed: ' . $e->getMessage());
            return false;
        }
    }
}
