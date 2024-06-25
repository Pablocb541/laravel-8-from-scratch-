[< Volver al índice](/docs/readme.md)

# Laravel Breeze Quick Peek

Aunque ya hemos trabajado en un sistema de autenticación personalizado para nuestro blog, es importante revisar los paquetes de autenticación integrados de Laravel, como Laravel Breeze. En este episodio, daremos un vistazo rápido a cómo se configura y utiliza Laravel Breeze en un nuevo proyecto. También haremos algunas modificaciones a nuestro controlador de sesiones para mejorar la autenticación.

Aunque estamos explorando Laravel Breeze, también haremos una mejora en nuestro `SessionController.php` para nuestro sistema de autenticación personalizado. Actualizaremos el método store para manejar la autenticación de manera más robusta.

```php


class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (! auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }

        session()->regenerate();

        return redirect('/')->with('success', 'Welcome Back!');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'Goodbye!');
    }
}
```

# Resumen

En este episodio, revisamos rápidamente cómo configurar Laravel Breeze en un nuevo proyecto. Breeze facilita la implementación de la autenticación básica con un mínimo esfuerzo. Además, mejoramos nuestro SessionController.php para manejar la autenticación de manera más efectiva, asegurándonos de que los usuarios reciban comentarios adecuados si sus credenciales no son válidas y regenerando la sesión para mejorar la seguridad después de un inicio de sesión exitoso.

Estas herramientas y mejoras nos permiten ofrecer una experiencia de usuario más fluida y segura en nuestra aplicación.