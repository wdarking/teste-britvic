# Teste Britvic/Ebba

### Demonstração

![](https://s4.gifyu.com/images/Peek-2021-02-21-23-01.gif)

### Instalação

Para rodar o projeto, clone o repositório e instale as dependencias com o `composer install` e rode `npm install && npm run dev`.

### Executando o projeto

Utilize `sail` para rodar o projeto, executando `./vendor/bin/sail up -d`. Após isto, você poderá acessar o endereço http://127.0.0.1 e usar a aplicação.

Instale as migrações e o seeder executando o comando `./vendor/bin/sail artisan migrate --seed`.

Após isto, você pode fazer o login em http://127.0.0.1/login com a conta dev/admin:

- email: dev@dev.com
- senha: dev
