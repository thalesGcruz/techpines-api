
# techpines-api
Este projeto é uma API desenvolvida em Laravel para gerenciar e rankear músicas da dupla Tião Carreiro & Pardinho.
---

## 🚀 Tecnologias utilizadas

- [Laravel](https://laravel.com/)
- [MySQL](https://www.mysql.com/)
- [Redis](https://redis.io/)
- [Docker](https://www.docker.com/)
- [PHP](https://www.php.net/)

---

## 📁 Organização do projeto
---
    app/
    ├── Http/
    │ ├── Controllers/ # Controladores da aplicação
    │ ├── Requests/ # Validações de requisição (Form Requests)
    │ ├── Resources/ # Resources para formatação de respostas JSON
    ├── Models/ # Modelos Eloquent
    database/
    ├── migrations/ # Estrutura do banco de dados (migrations)
    ├── seeders/ # População inicial do banco (seeders)
    routes/
    ├── api.php # Rotas da API
---

## 🐳 Rodando o projeto  com Docker

## ⚠️ Atenção para usuários Windows
Se estiver usando **Windows**, é altamente recomendado abrir este projeto via **WSL (Windows Subsystem for Linux)**.

Clone Repositório
```sh
git clone https://github.com/thalesGcruz/techpines-api.git
```
```sh
cd techpines-api
```

Suba os containers do projeto
```sh
docker compose up -d
```

Crie o Arquivo .env
```sh
cp .env.example .env
```

Acesse o container app
```sh
docker compose exec app bash
```

Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Rodar as migrations
```sh
php artisan migrate
```


Rodar os seeder
```sh
php artisan db:seed
```


Acesse o projeto
[http://localhost:8000](http://localhost:8000)

Acesse o banco de dados
[http://localhost:8000](http://localhost:8080)

