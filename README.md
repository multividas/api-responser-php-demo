# Laravel demo: api-responser package usage.

```sh
cp .env.example .env
```

```sh
php artisan key:generate
```

Generate db seed
```
php artisan migrate:fresh --seed
```

Start the development server

```sh
php artisan serve
```

API endpoints

- To fetch posts: GET http://127.0.0.1:8000/api/posts
- To fetch users: GET http://127.0.0.1:8000/api/users
