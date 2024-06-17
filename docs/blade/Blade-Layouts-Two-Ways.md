[< Volver al índice](/docs/readme.md)

# Blade Layouts Two Ways
 En este episodio vamos a crear una carpeta llamada components en resource dentro de components crearemos un archivo llamado
`layout.blade.php`

Este codigo estará en `layout.blade.php`

`<body>{{ $slot }}</body>: ` es la sección principal del documento html. Dentro del elemento `<body>`,
 se encuentra la expresión `{{ $slot }}`, que es un marcador de posición que será reemplazado por el 
 contenido principal de la página cuando se cargue.
```php
 <!doctype html>

<title>My Blog</title>
<link rel="stylesheet" href="/app.css">

<body>
    {{ $slot }}
</body> 
```


Modificaremos el codigo de `post` que se encuentra en resource/views

Post
```php
<x-layout>
    <article>
        <h1>{{ $post->title }}</h1>

        <div>
            {!! $post->body !!}
        </div>
    </article>

    <a href="/">Go Back</a>
</x-layout>


```
Tambíen el codigo de `posts`

```php

<x-layout>
    @foreach ($posts as $post)
        <article class="{{ $loop->even ? 'foobar' : '' }}">
            <h1>
                <a href="posts/{{ $post->slug }}">
                    {{ $post->title }}
                </a>
            </h1>

            <div>
                {{ $post->excerpt }}
            </div>
        </article>
    @endforeach
</x-layout>

```

En este episodio cambiamos un poco la sintaxis esto porque views tiene la estructura html y para que cada vez que queramos
actualizar no debamos hacerlo en cada vista.Esto reducira la duplicación