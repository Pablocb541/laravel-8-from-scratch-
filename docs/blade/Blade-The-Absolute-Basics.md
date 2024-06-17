[< Volver al índice](/docs/readme.md)

#  Blade The Absolute Basics

En este episodio se modificará el post y posts en resource/Views


```php
<!doctype html>

<title>My Blog</title>
<link rel="stylesheet" href="/app.css">

<body>
    <article>
        <h1>{{ $post->title }}</h1>

        <div>
            {!! $post->body !!}
        </div>
    </article>
    <a href="/">Go Back</a>
</body>
```

También el posts

```php
<!doctype html>

<title>My Blog</title>
<link rel="stylesheet" href="/app.css">

<body>
    @foreach ($posts as $post)
    <article class="{{ $loop->even ? 'foobar' : '' }}">
        <h1>
            <a href="posts/{{ $post->slug }}">
                {{ $post->title }}
            </a>
        </h1>

        <div>
            {{ $post->excerpt }}
        </div>
    </article>
    @endforeach
</body>

```

Las modificaciones que se hicieron fueron la implementación de {{ }} esto para implementar 
la sintaxis necesaria para construir estas vistas sea lo más limpia y concisa posible.