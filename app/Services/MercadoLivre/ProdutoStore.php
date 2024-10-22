<?php

namespace App\Services\MercadoLivre;

use Exception;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\{Http, Log};

class ProdutoStore
{
    /**
     * @throws Exception
     */
    public function handle(array $payload, array $imagens)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.mercadolivre.access_token'),
            ])->post(config('services.mercadolivre.base_url') . '/items', [
                "title"              => $payload['nome'],
                "category_id"        => $payload['categoria'],
                "price"              => $payload['preco'],
                "currency_id"        => "BRL",
                "available_quantity" => $payload['quantidade_em_estoque'],
                "buying_mode"        => "buy_it_now",
                "condition"          => "new",
                "listing_type_id"    => "bronze",
                "description"        => 'plain test',
                'tags'               => [
                    'immediate_payment',
                ],
                "pictures" => [
                    [
                        "source" => $imagens[0]['path'],
                    ],
                    [
                        "source" => $imagens[1]['path'],
                    ],
                    [
                        "source" => $imagens[2]['path'],
                    ],
                    [
                        "source" => $imagens[3]['path'],
                    ],
                    [
                        "source" => $imagens[4]['path'],
                    ],
                    [
                        "source" => $imagens[5]['path'],
                    ],
                ],
                "attributes" => [
                    [
                        "id"         => "BRAND",
                        "value_name" => $payload['brand'],
                    ],
                    [
                        "id"         => "PART_NUMBER",
                        "value_name" => "Marca do produto",
                    ],
                    [
                        "id"         => "LAPTOP_HOUSING_TYPE",
                        "value_name" => "Marca do produto",
                    ], [
                        "id"         => "MODEL",
                        "value_name" => $payload['modelo'],
                    ],
                ],
            ]);

            if (!$response->successful()) {
                throw new Exception('Erro ao criar anúncio: ' . $response->body());
            }

            return $response->json();

        } catch (ConnectException) {
            throw new Exception('Não foi possível conectar ao Mercado Livre, por favor, tente novamente mais tarde.');
        } catch (Exception $exception) {
            Log::info("Exception Not Handle: " . $exception->getMessage());

            throw new Exception('Não foi possível realizar a postagem do produto no momento tente mais tarde.');
        }
    }
}
