[< Volver al índice](/docs/readme.md)

#  Route Wildcard Constraints

En este episodio vamos a modificar el archivo web.php, agregando `$post = cache()->remember("posts.{$slug}", 1200, fn() => file_get_contents($path));`
esto con el fin de que no este llamado a `file_get_contents()` cada vez que entramos a la pagina.Este se utiliza para almacenar 
en caché el contenido del archivo correspondiente al post durante un tiempo determinado y
 para recuperar este contenido de la caché en lugar de leer el archivo directamente cada vez que se recarga la página.
```php


Route::get('/', function () {
    return view('posts');
});

Route::get('posts/{post}', function ($slug) {
    if (! file_exists($path = __DIR__ . "/../resources/posts/{$slug}.html")) {
        return redirect('/');
    }

    $post = cache()->remember("posts.{$slug}", 1200, fn() => file_get_contents($path));

    return view('post', ['post' => $post]);
})->where('post', '[A-z_\-]+');
```
