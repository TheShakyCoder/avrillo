<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuoteController extends Controller
{
    public function index(Request $request): LengthAwarePaginator
    {
        $query = Quote::query()->limit(5)->inRandomOrder();
        $count = $query->count();
        while($count < config('app.quote.count')) {
            //  get more quotes
            Quote::query()->updateOrCreate($this->getKanyeQuote());

            $query = Quote::query()->limit(config('app.quote.count'))->inRandomOrder();
            $count = $query->count();
        }
        //  get 1 new quote on each call as a way to 'eventually' get them all
        Quote::query()->updateOrCreate($this->getKanyeQuote());

        return $query->paginate(config('app.quote.count'));
    }

    private function getKanyeQuote()
    {
        return Http::get('https://api.kanye.rest')->json();
    }
}
