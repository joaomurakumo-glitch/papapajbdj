# Mercadinho do Seu João

Sistema Laravel para cadastrar produtos, acompanhar quantidades em estoque e editar ou excluir itens pelo navegador.

## Requisitos

- PHP 8.3 ou superior, com as extensões `fileinfo` e `pdo_mysql` ativadas
- Composer
- MySQL

## Configuração

1. Crie um banco de dados MySQL chamado `mercadinho`.
2. Copie `.env.example` para `.env` e ajuste `DB_HOST`, `DB_PORT`, `DB_USERNAME` e `DB_PASSWORD` conforme sua instalação.
3. Instale as dependências e gere a chave da aplicação:

   ```bash
   composer install
   php artisan key:generate
   ```

4. Crie as tabelas e inicie o servidor:

   ```bash
   php artisan migrate
   php artisan serve
   ```

5. Acesse <http://localhost:8000>.

## Funcionalidades

- Cadastro com validação de nome, categoria, preço e quantidade.
- Listagem com busca por nome ou categoria e alerta visual para estoque de até 5 unidades.
- Edição e exclusão com modais de confirmação.

## Testes

```bash
php artisan test
```
