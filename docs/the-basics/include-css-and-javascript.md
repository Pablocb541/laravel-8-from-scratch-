[< Volver al índice](/docs/readme.md)

# Include CSS and JavaScript

En este episodio vamos a ver como podemos modificar nuestra pagina de Laravel como nosotros querramos comencemos por.

crear un archivo en `/public/app.css` con el siguiente contenido.

```css
body {
    background: navy;
    color: white;
}
```

Y luego vamos a crear el archivo `/public/app.js` con el siguiente contenido.

```javascript
alert('I am here');
```

Ahora modificamos la vista _Welcome_ con el siguiente código.

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LFTS</title>
    <script src="app.js"></script>
    <link rel="stylesheet" href="app.css">
</head>
<body>
    <h1>¡Hola mundo!...</h1>
</body>
</html>
```

![Vista Welcome](images/Hello_word.png)


![Vista Welcome](images/alerta.png)

En conclusion se creo una pagina donde pudimos poner texto meidante un h1 , le dimos estilo con css y se creo con css una alerta