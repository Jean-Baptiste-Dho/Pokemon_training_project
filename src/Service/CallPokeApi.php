<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class CallPokeApi
{

    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function getGen($id): array
    {
        $response = $this->client->request(
            'GET',
            'https://pokeapi.co/api/v2/generation/'.$id
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