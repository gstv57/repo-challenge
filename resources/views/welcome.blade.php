<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
<div class="container-fluid flex gap-4 p-4 content-center">
    @php
        $secret = config('services.mercadolivre.secret');
        $client = config('services.mercadolivre.client_token');
        $access = config('services.mercadolivre.access_token');
    @endphp

    @if($secret && $client && !empty($access))
        <div class="w-1/2">
            <form method="post" action="{{ route('produto.store') }}" class="bg-slate-400 p-6 rounded-lg shadow-md"
                  enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <label for="nome" class="block uppercase font-bold text-sm mb-2">Nome do Produto</label>
                    <input type="text" name="nome" class="p-2 rounded w-full" placeholder="Item de Teste – Por favor, NÃO OFERTAR!"
                           value="{{ old('nome') }}">
                    @error('nome') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label for="descricao" class="block uppercase font-bold text-sm mb-2">Descrição do Produto</label>
                    <textarea name="descricao" class="p-2 rounded w-full" rows="3"
                              value="{{ old('descricao') }}" placeholder="Digite a descrição do produto"></textarea>
                    @error('descricao') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label for="preco" class="block uppercase font-bold text-sm mb-2">Preço do Produto</label>
                    <input type="tel" name="preco" class="p-2 rounded w-full" placeholder="10.00" value="{{ old('preco') }}">
                    @error('preco') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label for="quantidade_em_estoque" class="block uppercase font-bold text-sm mb-2">Quantidade em
                        Estoque</label>
                    <input type="tel" name="quantidade_em_estoque" class="p-2 rounded w-full" placeholder="10" value="{{ old('quantidade_em_estoque') }}">
                    @error('quantidade_em_estoque') <span
                        class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label for="categoria" class="block uppercase font-bold text-sm mb-2">Categoria</label>
                    <select name="categoria" class="p-2 rounded w-full">
                        <option>Selecione uma categoria</option>
                        <option value="MLB38870">Carcaças</option>
                    </select>
                    @error('categoria') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label for="brand" class="block uppercase font-bold text-sm mb-2">Brand</label>
                    <input type="text" name="brand" class="p-2 rounded w-full" placeholder="Digite o brand" value="{{ old('brand') }}">
                    @error('brand') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label for="modelo" class="block uppercase font-bold text-sm mb-2">Modelo</label>
                    <input type="text" name="modelo" class="p-2 rounded w-full" placeholder="Digite o modelo" value="{{ old('modelo') }}">
                    @error('modelo') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label for="imagem" class="block uppercase font-bold text-sm mb-2">Imagem</label>
                    <input type="file" name="imagem" class="p-2 rounded w-full" multiple>
                    @error('imagem') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-center">
                    <button type="submit"
                            class="bg-green-900 px-6 py-2 rounded text-white hover:bg-green-700 transition-colors">
                        Cadastrar
                    </button>
                </div>
            </form>
            <table class="table-auto w-full my-2">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Nome</th>
                        <th class="px-4 py-2 text-left">Descrição</th>
                        <th class="px-4 py-2 text-left">Preço</th>
                        <th class="px-4 py-2 text-left">Estoque</th>
                        <th class="px-4 py-2 text-left">Categoria</th>
                        <th class="px-4 py-2 text-left">Brand</th>
                        <th class="px-4 py-2 text-left">Modelo</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($produtos as $produto)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $produto->id }}</td>
                        <td class="px-4 py-2">{{ $produto->nome }}</td>
                        <td class="px-4 py-2">{{ $produto->descricao }}</td>
                        <td class="px-4 py-2">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $produto->quantidade_em_estoque }}</td>
                        <td class="px-4 py-2">{{ $produto->categoria }}</td>
                        <td class="px-4 py-2">{{ $produto->brand }}</td>
                        <td class="px-4 py-2">{{ $produto->modelo }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <div class="w-1/2">
            <div class="bg-slate-200 p-4 rounded-lg h-full">
                <h2 class="text-xl font-bold mb-4">Resposta da API</h2>
                @if(session()->has('response'))
                    <div id="api-response" class="overflow-auto bg-white p-4 rounded shadow">
                        <pre class="whitespace-pre-wrap break-words bg-slate-100">
                            {{ session('response') }}
                        </pre>
                    </div>
                @else
                    <div class="text-gray-500 text-center py-4">
                        Faça um cadastro de produto
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="w-full flex justify-center mt-4">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 text-center">Configuração Necessária</h2>

                @if(!$secret || !$client)
                    <p class="text-gray-700">
                        Você deve configurar o <b class="text-green-600">MERCADOLIVRE_SECRET</b> e <b
                            class="text-green-600">MERCADOLIVRE_CLIENT</b> acessando seu .env antes de continuar.
                    </p>
                @endif

                @if($secret && $client)
                    <a href="https://auth.mercadolivre.com.br/authorization?response_type=code&client_id={{ $client }}&redirect_uri={{ config('services.mercadolivre.redirect_uri') }}"
                       class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200">Clique
                        aqui</a> para obter seu MERCADOLIVRE_ACCESS_TOKEN
                @endif

                <div class="text-white p-2 font-bold" id="accessTokenDisplay">
                </div>
            </div>
        </div>
        <script>
            const url = new URL(window.location.href);
            const code = url.searchParams.get('code');

            const clientId = "{{ $client }}";
            const clientSecret = "{{ $secret }}";
            const redirectUri = "{{ config('services.mercadolivre.redirect_uri') }}";

            async function getOAuth() {
                const formData = new FormData();
                formData.append('grant_type', 'authorization_code');
                formData.append('client_id', clientId);
                formData.append('client_secret', clientSecret);
                formData.append('code', code);
                formData.append('redirect_uri', redirectUri);

                try {
                    const response = await fetch('https://api.mercadolibre.com/oauth/token', {
                        method: 'POST',
                        body: formData,
                        headers: {},
                    });

                    const data = await response.json();

                    if (data.access_token) {
                        document.getElementById('accessTokenDisplay').textContent = `Access Token: ${data.access_token}`;
                    }
                } catch (error) {
                    document.getElementById('accessTokenDisplay').textContent = 'Erro ao obter o Access Token.';
                }
            }

            getOAuth();
        </script>
    @endif
</div>
</body>
</html>
