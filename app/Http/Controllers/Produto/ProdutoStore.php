<?php

namespace App\Http\Controllers\Produto;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produto\StoreRequest;
use App\Models\Produto;
use App\Services\MercadoLivre\ImagemUpload;
use Exception;
use Illuminate\Support\Facades\DB;

class ProdutoStore extends Controller
{
    public function __construct(
        protected ImagemUpload $getSourceLinkImageService,
        protected \App\Services\MercadoLivre\ProdutoStore $serviceProdutoStore
    ) {
    }

    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $imagem = $this->getSourceLinkImageService->handle($request);

            $produtoStore = $this->serviceProdutoStore->handle($data, $imagem);

            $produto = Produto::create($data);

            $produto->images()->createMany($imagem);

            DB::commit();

            return to_route('welcome')->with([
                'response' => json_encode($produtoStore, JSON_PRETTY_PRINT),
            ]);

        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'message' => $exception->getMessage(),
                'code'    => $exception->getCode() ?? 'N/A',
            ]);
        }
    }
}
