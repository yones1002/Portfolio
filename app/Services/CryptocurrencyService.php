<?php

namespace App\Services;

use App\Models\Cryptocurrency;
use Illuminate\Support\Facades\Http;

class CryptocurrencyService
{
    public function fetchCryptocurrencyList()
    {
        $url = "https://api.coingecko.com/api/v3/coins/list";
        $response = Http::get($url);

        if (!$response->ok()) {
            throw new \Exception(__('messages.error.api', ['item' => 'لیست ارزها']));
        }

        return $response->json();
    }

    public function fetchCryptocurrencyPrice($coinId)
    {
        $url = "https://api.coingecko.com/api/v3/simple/price?ids={$coinId}&vs_currencies=usd";
        $response = Http::get($url);

        if (!$response->ok() || !isset($response->json()[$coinId])) {
            throw new \Exception(__('messages.error.api', ['item' => 'قیمت ارز']));
        }

        return $response->json()[$coinId]['usd'];
    }

    public function storeCryptocurrency(array $data)
    {
        return Cryptocurrency::create($data);
    }

    public function updateCryptocurrency(Cryptocurrency $cryptocurrency, array $data)
    {
        $cryptocurrency->update($data);
        return $cryptocurrency;
    }

    public function deleteCryptocurrency(Cryptocurrency $cryptocurrency)
    {
        $cryptocurrency->delete();
    }
}
