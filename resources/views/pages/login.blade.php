<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Админка</title>

    <link rel="stylesheet" href="/css/admin.css">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    <main class="container mt-5">
        <div class="row">
            <div class="col-6">
                <form class="card" action="/login" method="POST">
                    <div class="card-body">
                        <h1 class="mb-3">Вход</h1>
                        <div class="mb-3">
                            <label class="form-label">Самый важный контакт в моем телефоне</label>
                            <input class="form-control" type="text" name="password">
                        </div>
                        <div>
                            <button class="btn btn-success" type="submit">
                                Войти
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>