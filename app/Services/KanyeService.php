<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KanyeService
{
    public function getQuote()
    {
        return Http::get('https://api.kanye.rest')->json();
    }
}
