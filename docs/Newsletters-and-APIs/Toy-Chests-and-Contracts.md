[< Volver al índice](/docs/readme.md)

# Toy Chests and Contracts

Este próximo episodio es suplementario. Es un poco más avanzado y revisa los contenedores de servicios, proveedores y contratos. Vamos a profundizar en cómo organizar y administrar nuestras dependencias usando estos conceptos.

### Pasos a seguir:

1. **Actualizar `AppServiceProvider.php`**:
   - Comenzamos agregando el siguiente código en la función `register()` de `AppServiceProvider.php`:

     ```php
     use App\Services\Newsletter;
     use App\Services\MailchimpNewsletter;
     use MailchimpMarketing\ApiClient;

     public function register()
     {
         app()->bind(Newsletter::class, function () {
             $client = (new ApiClient)->setConfig([
                 'apiKey' => config('services.mailchimp.key'),
                 'server' => 'us22'
             ]);

             return new MailchimpNewsletter($client);
         });
     }
     ```

2. **Modificar `MailchimpNewsletter.php`**:
   - Nos dirigimos al archivo `Newsletter.php` dentro de `Services` y eliminamos la función `client()` para que la configuración del cliente se maneje en el proveedor de servicios.
   - Cambiamos el nombre del archivo `Newsletter.php` a `MailchimpNewsletter.php`.

3. **Crear interfaces y clases**:
   - Creamos dos nuevos archivos en la carpeta `Services` llamados `ConvertKitNewsletter.php` y `Newsletter.php`.

   - En `MailchimpNewsletter.php`, implementamos la interfaz `Newsletter`:

     ```php
     <?php

     namespace App\Services;

     use MailchimpMarketing\ApiClient;

     class MailchimpNewsletter implements Newsletter
     {
         protected $client;

         public function __construct(ApiClient $client)
         {
             $this->client = $client;
         }

         public function subscribe(string $email, string $list = null)
         {
             $list ??= config('services.mailchimp.lists.subscribers');

             return $this->client->lists->addListMember($list, [
                 'email_address' => $email,
                 'status' => 'subscribed'
             ]);
         }
     }
     ```

   - En `Newsletter.php`, agregamos la interfaz:

     ```php
     <?php

     namespace App\Services;

     interface Newsletter
     {
         public function subscribe(string $email, string $list = null);
     }
     ```

   - En `ConvertKitNewsletter.php`, agregamos la siguiente implementación vacía para futuros desarrollos:

     ```php
     <?php

     namespace App\Services;

     class ConvertKitNewsletter implements Newsletter
     {
         public function subscribe(string $email, string $list = null)
         {
             // Implementar la lógica para ConvertKit aquí
         }
     }
     ```

4. **Actualizar `AppServiceProvider.php`**:
   - Finalmente, nos aseguramos de que `AppServiceProvider.php` devuelva una instancia de `MailchimpNewsletter`:

     ```php
     use App\Services\MailchimpNewsletter;

     return new MailchimpNewsletter($client);
     ```

### Resumen del episodio:

En este episodio, hemos explorado cómo utilizar contenedores de servicios y contratos para gestionar nuestras dependencias de manera más efectiva. Creamos una interfaz `Newsletter` y dos implementaciones concretas (`MailchimpNewsletter` y `ConvertKitNewsletter`). Luego, configuramos nuestro proveedor de servicios para vincular la interfaz `Newsletter` a una implementación específica (`MailchimpNewsletter`). Esto nos permite cambiar fácilmente las implementaciones en el futuro sin necesidad de modificar el código que depende de estas clases.