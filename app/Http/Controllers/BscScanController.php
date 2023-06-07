<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Transaction;
use App\Models\User;

class BscScanController extends Controller
{
    
    public function getSuccessfulbscTransactions(Request $request)
    {
        $bscApiKey = 'FF6I7JPYAN35QPU5C9H31SJ479GPI4V8SU'; // replace with your BscScan API key
        $coinGeckoClient = new Client([
            'base_uri' => 'https://api.coingecko.com/api/v3/',
        ]);
        $users = User::all();
        foreach ($users as $user) {
            $address = $user->eth_address; // assuming you have eth_address column in User model
            $bscResponse = $this->getBscTransactions($bscApiKey, $address);
            $bnbToUsdRate = $this->getBnbToUsdRate($coinGeckoClient);
            if ($bscResponse) {
                $transactions = json_decode($bscResponse->getBody(), true);
                if (is_array($transactions['result'])) {
                    foreach ($transactions['result'] as $tx) {
                        // check if transaction already exists in the database
                        $existingTx = Transaction::where('hash', $tx['hash'])->first();

                        if ($existingTx === null) {
                            // calculate Coin value
                            $usdValue = $tx['value'] / 1e18 * $bnbToUsdRate;
                            $coinValue = $usdValue * 2;

                            // create new transaction model and save it to the database
                            $newTx = new Transaction();
                            $newTx->hash = $tx['hash'];
                            $newTx->block_number = $tx['blockNumber'];
                            $newTx->timestamp = $tx['timeStamp'];
                            $newTx->from_address = $tx['from'];
                            $newTx->to_address = $tx['to'];
                            $newTx->value = $tx['value'] / 1e18;
                            $newTx->coin_value = $coinValue;
                            $newTx->gas_price = $tx['gasPrice'];
                            $newTx->gas_used = $tx['gasUsed'];
                            $newTx->network = 'bnb'; // Set the network for bnb transactions
                            $newTx->save();

                          
                        }
                    }
                }
            }
            sleep(6);
        }

        return response()->json(['message' => 'Success']);
    }

    private function getBscTransactions($apiKey, $address)
    {
        $client = new Client([
            'base_uri' => 'https://api.bscscan.com/api/',
        ]);
        $response = $client->request('GET', '', [
            'query' => [
                'module' => 'account',
                'action' => 'txlist',
                'address' => $address,
                'apikey' => $apiKey,
                'sort' => 'desc',
                'startblock' => 0,
                'endblock' => 'latest',
                'page' => 1,
                'offset' => 100,
                'txreceiptstatus' => 1,
            ],
        ]);

        return $response;
    }

    private function getBnbToUsdRate($client)
    {
        $response = $client->request('GET', 'simple/price', [
            'query' => [
                'ids' => 'binancecoin',
                'vs_currencies' => 'usd',
            ],
        ]);
        $body = json_decode($response->getBody(), true);

        return $body['binancecoin']['usd'];
    }
    

}
