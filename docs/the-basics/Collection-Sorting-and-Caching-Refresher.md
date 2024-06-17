[< Volver al índice](/docs/readme.md)

#  Collection Sorting and Caching Refresher
En este último episodio modificaremos el `Post.php`. Agregaremos `return cache()->rememberForever` para almacenar 
el resultado de la consulta a los posts en la memoria de manera permanente para evitar cargar y procesar 
los datos de los posts desde el sistema de archivos cada vez que se accede a la lista de posts. 
También agregaremos `->sortByDesc('date')` para mostrar los posts de manera descendente según la propiedad date.

 ```php
 <?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

Class Post
{
    public $title;

    public $excerpt;
    
    public $date;
    
    public $body;

    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function all()
    {
        return cache()->rememberForever('posts.all', function () {
            return collect(File::files(resource_path("posts")))
            ->map(fn($file) => YamlFrontMatter::parseFile($file))
            ->map(fn($document) => new Post(
                $document->title,
                $document->excerpt,
                $document->date,
                $document->body(),
                $document->slug
            ))
            ->sortByDesc('date');
        });
    }

    public static function find($slug)
    {
        return static::all()->firstWhere('slug', $slug);
    }
}
 ```

 Por último crearemos un file en posts `my-fifth-post.html` y agregamos todo el encabezado. En esa misma carpeta
 modificamos la fecha de `my-fourth-post.html` `date: 2021-06-21`