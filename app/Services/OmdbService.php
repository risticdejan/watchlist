<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class OmdbService
{
    /**
     * Fetch movie details from the OMDB API by IMDB ID.
     *
     * @throws RequestException
     * @return array<string, mixed>
     */
    public function fetchMovieByImdbId(string $imdbId): array
    {
        $baseUri = config('services.omdb.base_uri');

        $query = [
            'i' => $imdbId,
        ];

        if ($key = config('services.omdb.key')) {
            $query['apikey'] = $key;
        }

        $response = Http::baseUrl($baseUri)
            ->acceptJson()
            ->retry(2, 100)
            ->get('', $query)
            ->throw();

        $payload = $response->json();

        return is_array($payload) ? $payload : [];
    }
}
