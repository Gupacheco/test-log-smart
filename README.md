# Test Log Smart

Um projeto Laravel moderno com configuração Docker completa para facilitar o desenvolvimento e deploy.

## 🚀 Tecnologias

- **Laravel 12** - Framework PHP moderno
- **PHP 8.4** - Versão mais recente do PHP
- **MySQL 8.0** - Banco de dados relacional
- **Redis** - Cache e sessões
- **Docker & Docker Compose** - Containerização
- **Laravel Sail** - Ambiente de desenvolvimento Laravel

## 📋 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/downloads)

## 🛠️ Instalação e Configuração

### 1. Clone o repositório

```bash
git clone git@github.com:Gupacheco/test-log-smart.git
cd test-log-smart
```

### 2. Configure as variáveis de ambiente

```bash
cp .env.example .env
```

Edite o arquivo `.env` com suas configurações:

```env
APP_NAME="Test Log Smart"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 3. Inicie os containers Docker

```bash
./vendor/bin/sail up
```

### 4. Instale as dependências do PHP

```bash
./vendor/bin/sail composer install
```

### 5. Gere a chave da aplicação

```bash
./vendor/bin/sail artisan key:generate
```

### 6. Execute as migrações do banco de dados

```bash
./vendor/bin/sail artisan migrate
```

## 🌐 Acessando a aplicação

Após a instalação, você pode acessar:

- **Aplicação**: http://localhost
- **Banco de dados**: localhost:3306
- **Redis**: localhost:6379


## 🐳 Comandos Docker úteis

### Criar um Alias para o ./vendor/bin/sail
```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

Agora pode rodar os comandos usando sail no lugar de ./vendor/bin/sail

### Iniciar os serviços
```bash
sail up -d
```

### Parar os serviços
```bash
sail down
```

### Limpar Cache
```bash
sail artisan optimize:clear
```
