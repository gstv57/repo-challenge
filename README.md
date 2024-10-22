# GUIA DE INSTALAÇÃO E EXECUÇÃO

## Requisitos
* PHP ^8.2
* Composer
* MySQL/SQLite

## Guia Simplificado

1. Clone o repositório
   ```bash
   git clone https://github.com/gstv57/repo-challenge.git challenge-oauth
   cd challenge-oauth
   ```

2. Instale as dependências
   ```bash
   composer install
   npm install
   ```

3. Configure o ambiente
   ```bash
   cp .env.example .env
   ```

4. Configure as variáveis de ambiente:
    * `MERCADOLIVRE_SECRET`
    * `MERCADOLIVRE_CLIENT`
    * `MERCADOLIVRE_REDIRECT_URL`
    * Configurações do banco de dados:
        * `DB_CONNECTION`
        * `DB_HOST`
        * `DB_PORT`
        * `DB_DATABASE`
        * `DB_USERNAME`
        * `DB_PASSWORD`

   > **Nota**: Para usar SQLite, basta definir `DB_CONNECTION=sqlite` (requer extensão PHP SQLite)

5. Prepare o ambiente
   ```bash
   php artisan config:clear
   php artisan migrate --seed
   php artisan key:generate
   php artisan serve
   ```

6. Configuração do MercadoLivre:
    1. Acesse a URL definida em `APP_URL`
    2. Clique no botão para gerar seu `ACCESS_TOKEN`
    3. O token deve se parecer com: `APP_USR-297454493794-102215-0b9c83038ad262ca7daa003e-791310071`
    4. Insira o token na variável `MERCADOLIVRE_ACCESS_TOKEN` no arquivo `.env`
    5. Atualize a página e faça o cadastro do seu produto
    6. Faça o login usando:  test@example.com   senha: 123 

## Guia Avançado

1. Siga os passos 1-5 do Guia Simplificado

2. Prepare a URL de autorização:
   ```
   https://auth.mercadolivre.com.br/authorization?response_type=code&client_id=SEU_CLIENT_ID&redirect_uri=SUA_REDIRECT_URI
   ```

3. Processo de autorização:
    * Abra a URL em uma nova aba do navegador (com sua conta de desenvolvedor autenticada)
    * Aceite todas as permissões solicitadas
    * Você será redirecionado de volta ao site com um parâmetro `code` na URL
    * Copie este código

4. Faça a requisição do token via terminal:
   ```bash
   curl --request POST \
   --url https://api.mercadolibre.com/oauth/token \
   --header 'Content-Type: multipart/form-data' \
   --form grant_type=authorization_code \
   --form client_id=SEU_CLIENT_ID \
   --form client_secret=SEU_CLIENT_SECRET \
   --form code=CODIGO_OBTIDO_NA_URL \
   --form redirect_uri=SUA_URL_DE_REDIRECIONAMENTO
   ```

5. Resposta esperada:
   ```json
   {
       "access_token": "APP_USR-29785843794-102211-8b0c8eeebc402ce3cbb52a6271f5f-791310071",
       "token_type": "Bearer",
       "expires_in": 21600,
       "scope": "offline_access read write",
       "user_id": 791310000,
       "refresh_token": "TG-672be36805c1b555cdd-791310071"
   }
   ```

6. Configure o token:
    * Insira o `access_token` na variável `MERCADOLIVRE_ACCESS_TOKEN` no arquivo `.env`
    * Atualize a página inicial do site
    * O cadastro do produto estará disponível
    * Faça o login usando:  test@example.com   senha: 123 
