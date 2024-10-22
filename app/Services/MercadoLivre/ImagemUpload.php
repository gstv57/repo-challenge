<?php

namespace App\Services\MercadoLivre;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImagemUpload
{
    public function handle(Request $request): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.mercadolivre.access_token'),
            ])->attach(
                'file',
                file_get_contents($request->file('imagem')->getRealPath()),
                $request->file('imagem')->getClientOriginalName()
            )->post(config('services.mercadolivre.base_url') . '/pictures/items/upload');

            if (!$response->successful()) {
                throw new Exception('Erro ao fazer upload da imagen: ' . $response->body());
            }

            $pictures_url = [];

            $data = $response->json();

            foreach ($data['variations'] as $picture) {
                $pictures_url[] = ['path' => $picture['secure_url']];
            }

            return array_slice($pictures_url, 0, 6);
        } catch (Exception $error) {
            return [
                'error'   => 'internal_error_not_handling',
                'message' => $error->getMessage(),
            ];
        }
    }
}
