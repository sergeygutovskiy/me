<!DOCTYPE html>
<html lang="ru">
<head>
    @include('templates.header')
    <title>
        @yield('title') - Гутовский Сережа
    </title>
</head>
<body>
    @include('templates.navigation')
    @yield('header')
    
    <main>
        @yield('content')
    </main>
    
    @include('templates.sidebar')
    @include('templates.blur')

    @include('templates.footer')
</body>
</html>