<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use App\Bank;
use App\Party;

class DaDataController extends Controller
{
	
    public function search(Request $request) 
    {
        $client = new \GuzzleHttp\Client;
        $token = config('api.key');

        foreach (['address','bank','party'] as $subUrl) {
            $res = $client->request(
                'POST',
                'https://dadata.ru/api/v2/suggest/' . $subUrl,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Token' . ' ' . $token
                    ],
                    'json' => [
                        'query' => $request->get('s'),
                        'count' => 5
                    ]
                ]
            );

            $ret[] =[
                $subUrl . '_info' => $res->getBody()->getContents()
            ];
        }
        
        return json_encode($ret);
    }

    public function change(Request $request) 
    {
        $data = $request->get('data');

        $addressInfo = json_decode($data[0]['address_info']);
        $bankInfo = json_decode($data[1]['bank_info']);
        $partyInfo = json_decode($data[2]['party_info']);

        $party = new Party;

        //Aдреса
        foreach ($addressInfo->suggestions as $addressI) {
            Address::insert([
                'address' => $addressI->value,
                'postcode' => $addressI->data->region_fias_id,
                'codefias' => $addressI->data->fias_id,
                'codekladr' => $addressI->data->kladr_id
            ]);
        }

        //Банки
        foreach ($bankInfo->suggestions as $bankI) {
            Bank::insert([
                'bank_name' => $bankI->value,
                'bank_address' => $bankI->data->address->value,
                'bic' => $bankI->data->bic,
                'swift' => (isset($bankI->data->swift)) ? $bankI->data->swift : ''
            ]);
        }
            //Организация
        foreach ($partyInfo->suggestions as $partyI) {
            Party::insert([
                'name' => $partyI->value,
                'address' => $partyI->data->address->value,
                'inn' => $partyI->data->inn,
                'kpp' => $partyI->data->kpp
            ]);
        }

        return json_encode('');
    }
}
