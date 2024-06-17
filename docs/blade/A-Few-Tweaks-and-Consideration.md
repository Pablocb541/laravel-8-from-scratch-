[< Volver al índice](/docs/readme.md)

# A Few Tweaks and Consideration

En este último episodio vamos a hacer un pequeño cambio para el manejo de errores en la pagina 


empezando por el web.php donde eliminaremos `->where('post', '[A-z_\-]+');`

```php
Route::get('/', function () {
    return view('posts', [
        'posts' => Post::all()
    ]);
});

Route::get('posts/{post}', function ($slug) {
    return view ('post', [
        'post' => Post::findOrFail($slug)
    ]);
});
```

En nuestro app/Models Luego, agregaremos un segundo método Post::findOrFail() 
que cancela automáticamente si no se encuentra ninguna publicación que coincida con el slug dado.

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

    public static function findOrFail($slug)
    {
        $post = static::find($slug);

        if (! $post) {
            throw new ModelNotFoundException();
        }
        
        return $post;
    }
}
```
