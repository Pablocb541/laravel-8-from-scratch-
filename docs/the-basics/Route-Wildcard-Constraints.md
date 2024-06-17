[< Volver al índice](/docs/readme.md)

#  Route Wildcard Constraints

En este episodio vamos a modificar el archivo web.php, agregando en la última línea `->where('post', '[A-z_\-]+');` para 
hacer uso de las expresiones regulares. Esto nos permitirá garantizar que el slug de la publicación del blog 
consista exclusivamente en cualquier combinación de letras, números, guiones y guiones bajos.
```php

Route::get('/', function () {
    return view('posts');
});

Route::get('posts/{post}', function ($slug) {
    $path = __DIR__ . "/../resources/posts/{$slug}.html";

    if (! file_exists($path)) {
        return redirect('/');
    }

    $post = file_get_contents($path);

    return view('post', [
        'post' => $post
    ]);
})->where('post', '[A-z_\-]+');
```

![Vista Welcome](images/expressiones.png.png)