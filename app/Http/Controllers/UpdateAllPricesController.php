<?php
namespace App\Http\Controllers;

use App\Models\Cryptocurrency;
use Illuminate\Support\Facades\Http;

class UpdateAllPricesController extends Controller
{
    public function updateAll()
    {
        try {
            $coins = Cryptocurrency::all();

            $listUrl = "https://api.coingecko.com/api/v3/coins/list";
            $listResponse = Http::get($listUrl);

            if (!$listResponse->ok()) {
                logger()->error('Error fetching CoinGecko list');
                session()->flash('message', 'خطا در دریافت اطلاعات از API.');
                return redirect()->back();
            }

            $coinList = collect($listResponse->json());

            $coinIds = [];
            foreach ($coins as $coin) {
                $coinData = $coinList->first(function ($value) use ($coin) {
                    return strtolower($value['symbol']) === strtolower($coin->symbol)
                        || strtolower($value['name']) === strtolower($coin->name);
                });
                if ($coinData) {
                    $coinIds[$coin->id] = $coinData['id'];
                } else {
                    logger()->warning("Coin not found for symbol: {$coin->symbol}");
                }
            }

            if (empty($coinIds)) {
                session()->flash('message', 'هیچ ارز معتبری برای به‌روزرسانی یافت نشد.');
                return redirect()->back();
            }

            $updatedCoins = 0;
            $chunks = array_chunk($coinIds, 250, true);
            foreach ($chunks as $chunk) {
                $ids = implode(',', $chunk);
                $priceUrl = "https://api.coingecko.com/api/v3/simple/price?ids=".implode(',', $chunk)."&vs_currencies=usd";
                $priceResponse = Http::get($priceUrl);

                if (!$priceResponse->ok()) {
                    logger()->error('Error fetching CoinGecko prices');
                    session()->flash('message', 'خطا در دریافت قیمت‌ها.');
                    return redirect()->back();
                }

                $prices = $priceResponse->json();

                foreach ($chunk as $dbId => $coinId) {
                    if (isset($prices[$coinId]['usd'])) {
                        $price = $prices[$coinId]['usd'];
                        $cryptocurrency = Cryptocurrency::find($dbId);
                        if ($cryptocurrency) {
                            $cryptocurrency->current_price = $price;
                            $cryptocurrency->save();
                            $updatedCoins++;
                            logger()->info("Price updated for {$coinId}: {$price}");
                        }
                    } else {
                        logger()->warning("Price not found for {$coinId}");
                    }
                }
            }

            session()->flash('message', "تعداد {$updatedCoins} ارز با موفقیت به‌روزرسانی شدند.");
        } catch (\Exception $e) {
            logger()->error('Error updating prices: ' . $e->getMessage());
            session()->flash('message', 'خطایی در فرآیند به‌روزرسانی رخ داد.');
        }

        return redirect()->back();
    }
}
