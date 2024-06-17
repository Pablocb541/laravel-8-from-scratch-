[< Volver al índice](/docs/readme.md)

#  Use the Filesystem Class to Read a Directory

En este episodio vamos hacer uso de Filesystem para leer un directorio. Vamos a empezar creando un `Post.php` en app/Models

contenido de `Post.php`esta clase proporciona métodos estáticos para obtener todos los posts disponibles y para buscar un post
específico por su slug, utilizando manipulaciones de archivos y caché de Laravel para mejorar el rendimiento de acceso a datos.
Todo estos post estará en un array

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

Class Post
{
    public static function all()
    {
        $files = File::files(resource_path("posts/"));

        return array_map(fn($file) => $file->getContents(), $files);
    }

    public static function find($slug)
    {
        if (! file_exists($path = resource_path("posts/{$slug}.html"))) {
            throw new ModelNotFoundException();
        }
    
        return cache()->remember("posts.{$slug}", 1200, fn() => file_get_contents($path));
    }
}
```

Creamos un nuevo html en nuestra carpeta de post se llamará `my-fourth-post.html`, pondremos un encabezado con title,excerpt y date
esto para facilitar la busqueda

```html

---
title: My Fourth Post
excerpt: Lorem ipsum dolor sit amet consectetur adipisicing elit.
date: 2021-05-21
---

<p>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem maxime laborum doloremque rerum! Consequatur similique, odio facere itaque sequi error facilis dolorem, quaerat labore voluptates tempore, sit unde dolorum ad.
</p>

```



En los demas post de la carpe de post eliminaremos `<a href="/post">`



Modificaremos nuesto posts que se encuentra en resource/views,esto para renderizar la lista de post en el blog.
Cada post es representado por un artículo <article> y el contenido de cada post se inserta directamente en la página html


```html
<!doctype html>

<title>My Blog</title>
<link rel="stylesheet" href="/app.css">

<body>
    <?php foreach ($posts as $post) : ?>
    <article>
        <?= $post; ?>
    </article>
    <?php endforeach; ?>
</body>

```

Por ultimo modificaremos nuetro `web.php`,esta modificacion permite construir un sistema dinámico de visualización de 
posts de blog, donde la lista de todos los posts se muestra en una página y cada post individual se 
puede ver en una página separada, todo esto gestionado a través de rutas .


```php
Route::get('/', function () {
    return view('posts', [
        'posts' => Post::all()
    ]);
});

Route::get('posts/{post}', function ($slug) {

    return view ('post', [
        'post' => Post::find($slug)
    ]);
})->where('post', '[A-z_\-]+');

```

En este episodio pudimos ver como usar  el método allFiles de la clase Filesystem para obtener todos los archivos contenidos dentro de un
directorio específico.Vimos como se guardan los post en un array y como podemos buscar segun el encabezado.
