<?php

namespace App\Http\Controllers;

use App\Models\Cryptocurrency;
use App\Services\CryptocurrencyService;
use App\Http\Requests\CryptocurrencyRequest;

class CryptocurrencyController extends Controller
{
    protected $cryptocurrencyService;

    public function __construct(CryptocurrencyService $cryptocurrencyService)
    {
        $this->cryptocurrencyService = $cryptocurrencyService;
    }

    public function index()
    {
        $list = Cryptocurrency::orderby('rank', 'asc')->get();
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

        try {
            $coins = $this->cryptocurrencyService->fetchCryptocurrencyList();
            $coin = collect($coins)->firstWhere('symbol', strtolower($symbol));

            if (!$coin) {
                return back()->withErrors(['message' => __('messages.error.not_found', ['item' => 'ارز'])]);
            }

            $price = $this->cryptocurrencyService->fetchCryptocurrencyPrice($coin['id']);

            $this->cryptocurrencyService->storeCryptocurrency([
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
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
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

        $this->cryptocurrencyService->updateCryptocurrency($cryptocurrency, $request->all());

        return redirect()->route('cryptocurrency.index')
            ->with('success', __('messages.success.updated', ['item' => 'ارز']));
    }

    public function destroy($id)
    {
        $cryptocurrency = Cryptocurrency::find($id);

        if (!$cryptocurrency) {
            return back()->withErrors(['message' => __('messages.error.not_found', ['item' => 'ارز'])]);
        }

        $this->cryptocurrencyService->deleteCryptocurrency($cryptocurrency);

        return redirect()->route('cryptocurrency.index')
            ->with('success', __('messages.success.deleted', ['item' => 'ارز']));
    }
}
