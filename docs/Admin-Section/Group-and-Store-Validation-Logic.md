[< Volver al índice](/docs/readme.md)

# Group and Store Validation Logic


En este episodio, aprenderemos a agrupar y almacenar la lógica de validación para evitar la duplicación de código, mejorando así la mantenibilidad y la limpieza de nuestro código. A continuación, se presentan los pasos detallados para realizar esta tarea:

1. **Editar `AdminPostController.php`:**
   Modificamos el archivo `AdminPostController.php` para agrupar la lógica de validación en un método reutilizable.

    ```php
    <?php

    namespace App\Http\Controllers;

    use App\Models\Post;
    use Illuminate\Validation\Rule;

    class AdminPostController extends Controller
    {
        public function index()
        {
            return view('admin.posts.index', [
                'posts' => Post::paginate(50)
            ]);
        }

        public function create()
        {
            return view('admin.posts.create');
        }

        public function store()
        {
            Post::create(array_merge($this->validatePost(), [
                'user_id' => request()->user()->id,
                'thumbnail' => request()->file('thumbnail')->store('thumbnails')
            ]));

            return redirect('/');
        }

        public function edit(Post $post)
        {
            return view('admin.posts.edit', ['post' => $post]);
        }

        public function update(Post $post)
        {
            $attributes = $this->validatePost($post);

            if ($attributes['thumbnail'] ?? false) {
                $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
            }

            $post->update($attributes);

            return back()->with('success', 'Post Updated!');
        }

        public function destroy(Post $post)
        {
            $post->delete();

            return back()->with('success', 'Post Deleted!');
        }

        protected function validatePost(?Post $post = null): array
        {
            $post ??= new Post();

            return request()->validate([
                'title' => 'required',
                'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
                'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post)],
                'excerpt' => 'required',
                'body' => 'required',
                'category_id' => ['required', Rule::exists('categories', 'id')],
                'published_at' => 'required'
            ]);
        }
    }
    ```

# Resumen

En este episodio, hemos optimizado nuestro código eliminando la duplicación de la lógica de validación en el `AdminPostController`. Ahora, toda la lógica de validación se maneja en un único método `validatePost`, que se reutiliza tanto para la creación como para la actualización de publicaciones. Esta mejora no solo hace que el código sea más limpio y fácil de mantener, sino que también reduce el riesgo de errores al garantizar que la lógica de validación se encuentra en un solo lugar.