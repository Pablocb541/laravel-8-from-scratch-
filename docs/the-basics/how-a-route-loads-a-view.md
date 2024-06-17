[< Volver al índice](/docs/readme.md)

# How a Route Loads a View

En Laravel las rutas se configuran en el archivo `routes/web.php`.

Por ejemplo con el siguiente fragmento se renderiza la vista _Welcome_.

```php
Route::get('/', function () {
    return view('welcome');
});
```

Laravel puede retorna cualquier tipo de contenido, por ejemplo, código HTML donde llamamos a la pagina que se encuentra en la carpeta.

```php
Route::get('/html', function () {
    return '<h1>Esto es HTML</h1>';
});
```

tambien se puede retornar un JSON.

```php
Route::get('/json', function () {
    return ['foo' => 'bar'];
});
```

En conclusion el primer video fue introductorio para saber como funciona y que es lo que podemos modificar