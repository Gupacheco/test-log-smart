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
git clone <URL_DO_SEU_REPOSITORIO>
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
docker-compose up -d
```

### 4. Instale as dependências do PHP

```bash
docker-compose exec laravel.test composer install
```

### 5. Gere a chave da aplicação

```bash
docker-compose exec laravel.test php artisan key:generate
```

### 6. Execute as migrações do banco de dados

```bash
docker-compose exec laravel.test php artisan migrate
```

### 7. (Opcional) Execute os seeders

```bash
docker-compose exec laravel.test php artisan db:seed
```

### 8. Instale as dependências do Node.js (se necessário)

```bash
docker-compose exec laravel.test npm install
```

### 9. Compile os assets (se necessário)

```bash
docker-compose exec laravel.test npm run build
```

## 🌐 Acessando a aplicação

Após a instalação, você pode acessar:

- **Aplicação**: http://localhost
- **Banco de dados**: localhost:3306
- **Redis**: localhost:6379

## 📁 Estrutura do projeto

```
test-log-smart/
├── app/                    # Código da aplicação
├── config/                 # Arquivos de configuração
├── database/               # Migrações, seeders e factories
├── public/                 # Arquivos públicos
├── resources/              # Views, assets e idiomas
├── routes/                 # Definição de rotas
├── storage/                # Logs, cache e uploads
├── tests/                  # Testes automatizados
├── vendor/                 # Dependências do Composer
├── docker-compose.yml      # Configuração Docker
└── README.md              # Este arquivo
```

## 🐳 Comandos Docker úteis

### Iniciar os serviços
```bash
docker-compose up -d
```

### Parar os serviços
```bash
docker-compose down
```

### Ver logs
```bash
docker-compose logs -f
```

### Executar comandos Artisan
```bash
docker-compose exec laravel.test php artisan [comando]
```

### Executar comandos Composer
```bash
docker-compose exec laravel.test composer [comando]
```

### Executar testes
```bash
docker-compose exec laravel.test php artisan test
```

### Acessar o container da aplicação
```bash
docker-compose exec laravel.test bash
```

## 🔧 Desenvolvimento

### Executar em modo de desenvolvimento
```bash
docker-compose exec laravel.test npm run dev
```

### Compilar para produção
```bash
docker-compose exec laravel.test npm run build
```

### Limpar cache
```bash
docker-compose exec laravel.test php artisan cache:clear
docker-compose exec laravel.test php artisan config:clear
docker-compose exec laravel.test php artisan route:clear
docker-compose exec laravel.test php artisan view:clear
```

## 🧪 Testes

```bash
# Executar todos os testes
docker-compose exec laravel.test php artisan test

# Executar testes com coverage
docker-compose exec laravel.test php artisan test --coverage
```

## 📊 Monitoramento

### Logs da aplicação
```bash
docker-compose exec laravel.test tail -f storage/logs/laravel.log
```

### Logs do Docker
```bash
docker-compose logs -f laravel.test
```

## 🚨 Solução de problemas

### Container não inicia
```bash
# Verificar status dos containers
docker-compose ps

# Verificar logs
docker-compose logs

# Reconstruir containers
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Problemas de permissão
```bash
# Ajustar permissões do storage
docker-compose exec laravel.test chmod -R 775 storage bootstrap/cache
```

### Banco de dados não conecta
```bash
# Verificar se o MySQL está rodando
docker-compose exec mysql mysql -u root -p

# Verificar variáveis de ambiente
docker-compose exec laravel.test php artisan config:show database
```

## 📝 Contribuindo

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 🤝 Suporte

Se você encontrar algum problema ou tiver dúvidas:

1. Verifique se seguiu todos os passos da instalação
2. Consulte os logs do Docker e da aplicação
3. Abra uma issue no repositório

---

**Desenvolvido com ❤️ usando Laravel e Docker**
