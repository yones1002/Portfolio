<?php

namespace App\Http\Controllers;

use App\Models\Cryptocurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CryptocurrencyRequest;

class CryptocurrencyController extends Controller
{
    public function index()
    {
        $list = Cryptocurrency::orderby('rank','asc')->get();
        return view('cryptocurrency.index', compact('list'));
    }

    public function create()
    {
        return view('cryptocurrency.create');
    }

    public function store(CryptocurrencyRequest $request)
    {
        $symbol = strtoupper($request->symbol);
        $fa_name = $request->fa_name;
        $rank = $request->rank;
        $description = $request->description;
        $status = $request->status;
        $name = $request->name;
        // list of cryptocurrency
        $listUrl = "https://api.coingecko.com/api/v3/coins/list";

        try {
            $response = Http::get($listUrl);

            if ($response->ok()) {
                $coins = $response->json();

                // search cryptocurrency by symbol
                $coin = collect($coins)->firstWhere('symbol', strtolower($symbol));

                if (!$coin) {
                    return back()->withErrors(['message' => __('messages.error.not_found', ['item' => 'ارز'])]);
                }

                $coinId = $coin['id']; // find cryptocurrency id

                // get price of cryptocurrency
                $priceUrl = "https://api.coingecko.com/api/v3/simple/price?ids={$coinId}&vs_currencies=usd";

                $priceResponse = Http::get($priceUrl);

                if ($priceResponse->ok() && isset($priceResponse->json()[$coinId])) {
                    $price = $priceResponse->json()[$coinId]['usd'];

                    Cryptocurrency::create([
                        'fa_name' => $fa_name,
                        'name' => $name,
                        'symbol' => $symbol,
                        'current_price' => $price,
                        'rank' => $rank,
                        'status' => $status,
                        'description' => $description,
                        'image' => $coin['image']['large'] ?? null,
                    ]);

                    return redirect()->route('cryptocurrency.create')
                        ->with('success', __('messages.success.added', ['item' => 'ارز']));
                } else {
                    return back()->withErrors(['message' => __('messages.error.api', ['item' => 'قیمت ارز'])]);
                }
            } else {
                return back()->withErrors(['message' => __('messages.error.api', ['item' => 'لیست ارزها'])]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['message' => __('messages.error.exception', ['message' => $e->getMessage()])]);
        }
    }

    public function edit($id)
    {
        $cryptocurrency = Cryptocurrency::find($id);

        if (!$cryptocurrency) {
            return back()->withErrors(['message' => __('messages.error.not_found', ['item' => 'ارز'])]);
        }

        return view('cryptocurrency.create', compact('cryptocurrency'));
    }

    public function update(CryptocurrencyRequest $request, $id)
    {
        $cryptocurrency = Cryptocurrency::find($id);

        if (!$cryptocurrency) {
            return back()->withErrors(['message' => __('messages.error.not_found', ['item' => 'ارز'])]);
        }

        $cryptocurrency->update($request->all());

        return redirect()->route('cryptocurrency.index')
            ->with('success', __('messages.success.updated', ['item' => 'ارز']));
    }

    public function destroy($id)
    {
        $cryptocurrency = Cryptocurrency::find($id);

        if (!$cryptocurrency) {
            return back()->withErrors(['message' => __('messages.error.not_found', ['item' => 'ارز'])]);
        }

        $cryptocurrency->delete();

        return redirect()->route('cryptocurrency.index')
            ->with('success', __('messages.success.deleted', ['item' => 'ارز']));
    }
}
