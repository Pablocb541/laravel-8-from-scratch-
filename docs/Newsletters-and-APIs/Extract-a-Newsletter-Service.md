[< Volver al índice](/docs/readme.md)

# Extract a Newsletter Service

En este episodio vamos a extraer un fragmento de código a su propia clase de servicio Newsletter.

# Pasos a seguir:

1. **Crear la carpeta `Services`**:
   - Creamos una nueva carpeta llamada `Services` dentro de `app`.

2. **Crear `Newsletter.php`**:
   - Dentro de `Services`, creamos un nuevo archivo llamado `Newsletter.php` y agregamos el siguiente código:

     ```php
     <?php

     namespace App\Services;

     use MailchimpMarketing\ApiClient;

     class Newsletter
     {
         public function subscribe(string $email, string $list = null)
         {
             $list ??= config('services.mailchimp.lists.subscribers');

             return $this->client()->lists->addListMember($list, [
                 'email_address' => $email,
                 'status' => 'subscribed'
             ]);
         }

         protected function client()
         {
             return (new ApiClient())->setConfig([
                 'apiKey' => config('services.mailchimp.key'),
                 'server' => 'us22'
             ]);
         }
     }
     ```

3. **Modificar `web.php`**:
   - Nos dirigimos al archivo `web.php` y cambiamos la ruta del boletín para usar un controlador:

     ```php
     Route::post('newsletter', \App\Http\Controllers\NewsletterController::class);
     ```

4. **Crear `NewsletterController`**:
   - Abrimos nuestra máquina virtual, nos ubicamos en la ruta del proyecto y ejecutamos el siguiente comando para crear un controlador llamado `NewsletterController`:

     ```bash
     php artisan make:controller NewsletterController
     ```

   - Nos dirigimos al archivo `NewsletterController.php` recién creado y agregamos el siguiente código:

     ```php
     <?php

     namespace App\Http\Controllers;

     use App\Services\Newsletter;
     use Exception;
     use Illuminate\Validation\ValidationException;

     class NewsletterController extends Controller
     {
         public function __invoke(Newsletter $newsletter)
         {
             request()->validate(['email' => 'required|email']);

             try {
                 $newsletter->subscribe(request('email'));
             } catch (Exception $e) {
                 throw ValidationException::withMessages([
                     'email' => 'This email could not be added to our newsletter list.'
                 ]);
             }

             return redirect('/')
                 ->with('success', 'You are now signed up for our newsletter!');
         }
     }
     ```

5. **Actualizar el archivo `.env`**:
   - Añadimos la siguiente línea al final del archivo `.env` para especificar la lista de suscriptores de Mailchimp:

     ```bash
     MAILCHIMP_LIST_SUBSCRIBERS=feab4e92e0
     ```

# Verificación final:

- Nos dirigimos a nuestra página web y verificamos que la suscripción al boletín funcione correctamente.

---

# Resumen 

En este episodio, hemos extraído el código relacionado con la suscripción al boletín de Mailchimp a su propia clase de servicio `Newsletter`. También hemos creado un nuevo controlador `NewsletterController` para manejar las suscripciones, actualizado la ruta en `web.php` para utilizar este nuevo controlador y añadido la lista de suscriptores en el archivo `.env`.