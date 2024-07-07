[< Volver al índice](/docs/readme.md)

# All About Authorization

Para abordar la configuración y corrección de la autorización en tu aplicación, seguiremos los pasos detallados que has mencionado. Aquí tienes los pasos organizados para llevar a cabo estos cambios:

1. **Paso 1: Eliminar `MustBeAdministrator.php`**

Eliminarás el archivo `MustBeAdministrator.php` que se utilizaba anteriormente para la autorización.

2. **Definir la Gate y Directiva Blade en `AppServiceProvider.php`**

En el archivo `AppServiceProvider.php`, en el método `boot()`, definiremos la Gate para verificar si un usuario es administrador y también crearemos una directiva Blade para verificar esta capacidad.

```php
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;

public function boot()
{
    Gate::define('admin', function (User $user) {
        return $user->username === 'ErickArguello'; // Aquí debes ajustar la lógica según tus requisitos
    });

    Blade::if('admin', function () {
        return auth()->check() && auth()->user()->can('admin');
    });
}
```

 3. **Actualizar el archivo `layout.blade.php`**

Dentro del archivo `layout.blade.php`, actualiza los enlaces de navegación desplegable para mostrar solo los enlaces de administrador a usuarios autorizados.

```php
@admin
    <x-dropdown-item href="/admin/posts" :active="request()->is('admin/posts')">Dashboard</x-dropdown-item>
    <x-dropdown-item href="/admin/posts/create" :active="request()->is('admin/posts/create')">New Post</x-dropdown-item>
@endadmin
```

4. **Eliminar la Middleware de `Kernel.php`**

Dentro del archivo `Kernel.php`, elimina la referencia a la middleware `MustBeAdministrator::class` que ya no se necesita después de usar Gates y directivas Blade para la autorización.

5. **Actualizar las rutas en `web.php`**

En el archivo `web.php`, asegúrate de que las rutas de administrador estén protegidas por la Gate que acabamos de definir.

```php
use App\Http\Controllers\AdminPostController;

Route::middleware('can:admin')->group(function () {
    Route::resource('admin/posts', AdminPostController::class)->except('show');
});
```

# Resumen

Hemos simplificado y mejorado la autorización en tu aplicación Laravel. Ahora, solo los usuarios que cumplan con los criterios definidos en la Gate `admin` podrán ver y acceder a las rutas y enlaces específicos de administrador. Este enfoque hace que el código sea más limpio y mantenible al usar Gates y directivas Blade para gestionar la autorización.