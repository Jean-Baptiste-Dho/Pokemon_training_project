<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallPokeApi
{
    const BASE_URL = 'https://pokeapi.co/api/v2/';

    public function __construct(
        private HttpClientInterface $client,
    )
    {
    }

    public function getGen($id): array
    {
        $this->client->request('GET', self::BASE_URL . 'generation/');
        $response = $this->client->request(
            'GET',
            self::BASE_URL . 'generation/' . $id
        );

        return $response->toArray();
//        dd($response->getContent());
    }

    public function getPokemonByUrl($url): array
    {
        $response = $this->client->request(
            'GET',
            $url
//            'https://pokeapi.co/api/v2/pokemon-species/'.$id
        );

        return $response->toArray();
    }


}