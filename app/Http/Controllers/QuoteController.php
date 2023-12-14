<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Services\KanyeService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request,  KanyeService $kanyeService): LengthAwarePaginator
    {
        $query = Quote::query()->limit(5)->inRandomOrder();
        $count = $query->count();
        while($count < config('app.quote.count')) {
            //  get more quotes
            Quote::query()->updateOrCreate($kanyeService->getQuote());

            $query = Quote::query()->limit(config('app.quote.count'))->inRandomOrder();
            $count = $query->count();
        }
        //  get 1 new quote on each call as a way to 'eventually' get them all
        Quote::query()->updateOrCreate($kanyeService->getQuote());

        return $query->paginate(config('app.quote.count'));
    }
}
