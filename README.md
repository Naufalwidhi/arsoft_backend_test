## ====== BACK END DEVELOPER ARSOFT TEST ======

## Identitas

Nama : Naufal Widhi Ashshiddiqi
Email : naufalwidhi1@gmail.com
Framework : Laravel

## Penggunaan

1. Sesuaikan Environment yang ada di laravel dengan yang ada di database.
2. Migrate terlebih dahulu data ke dalam database dengan "php artisan migrate"
3. Seed terlebih dahulu data untuk menambahkan satu user dummy ke dalam database dengan "php artisan db:seed"
4. Method yang digunakan adalah GET, POST, PUT, dan DELETE sesuai dengan fungsi endpoint masing masing
5. Routes menggunakan API.php jadi pastikan tambahkan /api/(pilih fungsi api) di belakang endpoint
6. Untuk autentikasi dan keamanan saya menggunakan JWT manual jadi pastikan saat mengakses endpoint selain login tambahkan di dalam header "token" dengan isian token yang telah dikembalikan pada saat login.

## API Route

## ---- Login (POST)

Endpoint : /api/login
Parameter (Body):

-   email(string)
-   password(string)
    Return :
-   Token untuk akses endpoint lain

## ---- Index (GET)

Endpoint : /api/todos
Parameter (Header):

-   token
    Return :
-   Data All Todos

## ---- Add To dos (POST)

Endpoint : /api/todos
Parameter (Header):

-   token
    (Body):
-   id
-   title
-   detail (Nullable)
-   status (waiting, on-process, done)
    Return :
-   Data Todos

## ---- Update To dos (PUT)

Endpoint : /api/todos
Parameter (Header):

-   token
    (Body):
-   id
-   title
-   detail (Nullable)
-   status (waiting, on-process, done)
    Return :
-   Data All Todos

## ---- Delete To dos (DELETE)

Endpoint : /api/todos/(id)
Parameter (Header):

-   token
    (Body):
-   id
-   title
-   detail (Nullable)
-   status (waiting, on-process, done)
    Return :
-   Data All Todos
