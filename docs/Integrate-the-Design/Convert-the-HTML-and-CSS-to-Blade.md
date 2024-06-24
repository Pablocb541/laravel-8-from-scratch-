[< Volver al índice](/docs/readme.md)

# Convert the HTML and CSS to Blade

En este episodio, comenzaremos a construir el diseño real del blog  utilizando Blade, el motor de plantillas de Laravel.

Primero, descargamos el archivo zip del repositorio desde el siguiente enlace:

- [Diseño de laracast](https://github.com/laracasts/Laravel-From-Scratch-HTML-CSS)


Descomprimimos y abrimos la carpeta descargada, luego copiamos la carpeta `images` y la pegamos en nuestro proyecto dentro de la carpeta `public`



Luego, abrimos el archivo `index.html` de la carpeta descargada, copiamos todo el código y lo pegamos en nuestro archivo `layout.blade.php.`

Refrescamos la página:


Eliminamos parte del código en el archivo `layout.blade.php`, específicamente desde el componente <header> hasta antes del componente `<footer class="bg-gray-100 border border-black border-opacity-5 rounded-xl text-center py-16 px-10 mt-16">.`


El código eliminado lo pegamos en el archivo `posts.blade.php` y comentamos el código que estaba originalmente.

En el archivo `layout.blade.php`, escribimos lo siguiente entre el final del componente </nav> y el principio del componente <footer>:

```html
{{ $slot }}
```
Luego, eliminamos una parte del código, específicamente lo que se encuentra en el componente `<div class="lg:grid lg:grid-cols-3">`, y solo el primer <article> se agrega en un nuevo archivo que creamos en la carpeta components dentro de resources:

```html
<article
    class="transition-colors duration-300 hover:bg-gray-100 border border-black border-opacity-0 hover:border-opacity-5 rounded-xl">
    <div class="py-6 px-5 lg:flex">
        <div class="flex-1 lg:mr-8">
            <img src="./images/illustration-1.png" alt="Blog Post illustration" class="rounded-xl">
        </div>

        <div class="flex-1 flex flex-col justify-between">
            <header class="mt-8 lg:mt-0">
                <div class="space-x-2">
                    <a href="#"
                    class="px-3 py-1 border border-blue-300 rounded-full text-blue-300 text-xs uppercase font-semibold"
                    style="font-size: 10px">Techniques</a>

                    <a href="#"
                    class="px-3 py-1 border border-red-300 rounded-full text-red-300 text-xs uppercase font-semibold"
                    style="font-size: 10px">Updates</a>
                </div>

                <div class="mt-4">
                    <h1 class="text-3xl">
                        This is a big title and it will look great on two or even three lines. Wooohoo!
                    </h1>

                    <span class="mt-2 block text-gray-400 text-xs">
                            Published <time>1 day ago</time>
                        </span>
                </div>
            </header>

            <div class="text-sm mt-2">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>

                <p class="mt-4">
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
            </div>

            <footer class="flex justify-between items-center mt-8">
                <div class="flex items-center text-sm">
                    <img src="./images/lary-avatar.svg" alt="Lary avatar">
                    <div class="ml-3">
                        <h5 class="font-bold">Lary Laracore</h5>
                        <h6>Mascot at Laracasts</h6>
                    </div>
                </div>

                <div class="hidden lg:block">
                    <a href="#"
                    class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8"
                    >Read More</a>
                </div>
            </footer>
        </div>
    </div>
</article>

```
En el archivo posts.blade.php, dentro del <div class="lg:grid lg:grid-cols-3">, agregamos lo siguiente:

```html
Copiar código
<x-post-card/>
<x-post-card/>
<x-post-card/>
```
Hacemos lo mismo en el <div class="lg:grid lg:grid-cols-2">:

```html
<x-post-card/>
<x-post-card/>
<x-post-card/>
```
Luego, eliminamos los articles restantes del archivo `posts.blade.php` y los pegamos en un nuevo archivo que creamos en la carpeta components, llamado `post-featured-card.blade.php.`

Volvemos al archivo posts.blade.php y dentro del main, escribimos la siguiente línea de código:

```html

<main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
    <x-post-featured-card />

```    
Por último, eliminamos el componente header del archivo `posts.blade.php` y creamos un nuevo archivo en la carpeta views llamado `_posts-header.blade.php`, donde pegamos el header.

En el archivo `posts.blade.php`, escribimos la siguiente línea de código:

```html
@include ('_posts-header')

```
# Resumen
En este episodio, convertimos el diseño HTML y CSS a Blade. Descargamos y configuramos los archivos de diseño, reorganizamos y limpiamos el código HTML, y creamos componentes Blade reutilizables para simplificar y mejorar la estructura del proyecto. Esto nos permitió establecer una base sólida para continuar desarrollando nuestro blog con Laravel.





