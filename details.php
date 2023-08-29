<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();


$id= isset($_GET['id']) ? $_GET['id']: '';
$token =  isset($_GET['token']) ? $_GET['token']:'';

if($id =='' || $token ==''){
    echo 'Error al procesar la peticion';
    exit;
}else{
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token == $token_tmp){
        $sql = $con->prepare("SELECT count(id), nombre, precio FROM productos WHERE id=? and activo = 1");
    $sql->execute([$id]);


    if ($sql->fetchColumn() > 0) {
        $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id = ? AND activo = 1 LIMIT 1");
        $sql->execute([$id]); // Cambiado '$id' por [$id]
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        
        $nombre = $row['nombre']; // Corregido 'precio' a 'nombre'
        $descripcion = $row['descripcion'];
        $precio = $row['precio'];
        $descuento = $row['descuento'];
        $precio_desc= $precio - (($precio * $descuento)/100);

        $dir_images='assets/productos/'. $id.'/';

        $rutaImg=$dir_images. 'principal.jpg';

        if(!file_exists($rutaImg)){
            $rutaImg= 'assets/img2.jpg';
        }
        $imagenes = array();
        /*VALIDA */
        if(file_exists($dir_images)){

        
        $dir=dir($dir_images);
        while(($archivo = $dir->read()) != false){
            if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg')|| strpos($archivo,'jpeg'))){
                /*archiv */
                $imagenes[]= $dir_images.$archivo;
            }
        }
        $dir-> close();
    }
    }
    
    }else{
        echo 'error al precesar la peticion';
        exit;
    }
}

 


?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="estilos.css" rel="stylesheet">
</head>

<body>
    <!--Barra de navegación-->
    <header class="menu">
        <div class="menu__logo"><a href="#"><img
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAfNJREFUSEu11UuozVEUx/HPVZ4RhkQU8sqjhJCSmFAmMiIMRAZCuaWUmUwkSjKRAZkQJhgYCRGllFcG8k6IlLyV1m2d+t//Pee0z+Duyensvdb+7r3+6/fbXfp5dPXz/loBJmE7lmIaPXGv8QjncBnfSw7XDDAEa3GmzQZfcQBH8bsdqA7Yg9v4izsFJ3yRh7nfKrYKmIon2IQr+FQAiJCf2Jil65NSBRzE3rz2LjzDlEJIhK3H2Xp8FXAX8/EeY3AEOzsARFmX40Y1pwr4jNG5uChBjzG0A8jb7LpvjZwq4AtG5cKDbNGtONQBIEKPYUczwFPEh26Mm1iNhamJFRhRAPuRJY5W7iW009hQ2+AdtuBqzs/AbMxN8LIWwBDpiTpgM061SLie+riHl3iDD5iXzbCklnce6+qAYfiI+C0Zz9GNC6jf/hUm1AHx/zB2l+xeidmWN49vtiDnQ3w93Ve3iuGI1hzfASRMbzrG4Vbm/UJ4WlM3DQ1EzQd2ANmHcILQQYj0IWa1AsT8GlzEgEJIGORiHM+WDpcNu2n5HsTaqjSwko/+D4PTKE9mG4dY2wJifQ4uYWLBTSZjLFZifyO+5MkclKYXdR7ZBhSqv4Y/1ZgSQCM+ShWbhIBmZtdEfnRdNEV4UDyrvUYngIIq9Q3pd8B/vnlZGUFe5tYAAAAASUVORK5CYII=" /></a>
        </div>
        <div class="menu__search">
            <input type="text" placeholder="Buscar ..." class="menu__search-input">
        </div>
        <ul class="menu__options">
            <li class="menu__option"><a href="#" class="menu__link">Hombre</a></li>
            <li class="menu__option"><a href="#" class="menu__link">Mujer</a></li>
            <li class="menu__option"><a href="#" class="menu__link">Kids</a></li>
            <li class="menu__option menu__option--sale"><a href="#" class="menu__link">Sale</a></li>
        </ul>
        <div class="menu__car"><a href="carrito.php"><img
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAT1JREFUSEvN1CEsRlEYxvHfNyMQbaaZTBNIkiJogsJIhqIwySbaREwwQzFBExRBMoJEUBTFRjCbYAI7du929+377j1cn3nLDec57/8853nPrWhwVRrc358CPhI3r9jG/G+4yzpIAWnfIZyWhdS6okWs4hgjjQC04wFN6MJ9GUi9kPcxXqLxIcbC/nqAAZyXANygNw8Q1q7Rg0nsRcKCbgJLSY6572AaW7hEfwSgDU9oQSceixy0JqLw7cNVAWQKOzjBcKotesnrmMMuQoO8OsNgEm4I+auKACGDkMUbOvBSh9CNOzwnuvdYQNClJ1vAWh3ACpaTzGaymiIHQRvm+SAi5CAJ433xXUAzbhGuIa+OMFotiHEQefjasljABmaxmUxVtlveWuEUpY2yv/LqQ+WtRQMa7uDHOcRm8H8Bn2QFNRlXu2umAAAAAElFTkSuQmCC" /><span
                    id="num_cart" class="badge bg-secondary">
                    <?php echo $num_cart;?>
                </span> </a>
        </div>
        <div class="menu__cart"><a href="#"><img
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAZJJREFUSEu11L9L1WEUx/GXNAdKklHY0mCjU3+A2C+l0aSpv0AIDXSS2lSKGtpbU0eLRLPGVjdxaDH6JUahjYlx4DEu3+5zny/X7lmfcz7v8+s5XTpsXR3WVxdwCw9wKSX0AbN4VUqwDmAacxmh+3jcClICXMcqviJAa0nsGuZxDsPYyEFKgPUkMI6lishtLOI1RtoF/EA3TuNXReQM9vAZF9oFfMNZ9OJ7BhA+0aqmVmpR9Pwqoh3LmRbFjG62C2gccmxMzORUgi6g76RDjsQmEWIh3GiHCOjTk6zpcewAphDr+Rtv0/5v/4+PVtJo+d5qyLGekfUVDKZtahTbxSbep2oOmpFygNiK52mIdSqIv3AXb6rOzQCjeJkcV/AQcdx+VoKjwjh+8R4xYZFYrO1fqwJ6sJUyj1szUyd9PErt/ILL2D+OqwLu4QneYaimeLiFTnzKOHwTeJYDxEEbK32eDPhGOnwvcCcH2EE/olXVnpcKOo9P+IiLOcBReijdqBzsn/h2hUrVZLeodmBdx45X8Afl0EcZyvkojQAAAABJRU5ErkJggg==" /></a>
        </div>

    </header>

    <!--Contenido-->
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">

                    <div id="carouselImages" class="carousel slide">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">

                            <div class="carousel-item active">
                                <img src="<?php echo $rutaImg; ?>" class="d-block w-100" alt="...">

                                <!--<img src="assets/productos/1/principal.jpg" class="d-block w-100" alt="">
-->
                            </div>
                            <?php foreach ($imagenes as $img) { ?>
                            <div class="carousel-item">
                                <img src="<?php echo $img; ?>" class="d-block w-100">
                            </div>
                            <?php } ?>


                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>


                    <!---->
                    <!--<img src="assets/productos/<?php echo $id; ?>/img1.jpg" alt="">-->
                    <img src="assets/productos/1/principal.jpg" alt="">


                </div>
                <div class="col-md-6 order-md-2">
                    <h2>
                        <?php echo $nombre;?>
                    </h2>
                    <?php if ($descuento > 0) { ?>
                    <p><del>
                            <?php echo MONEDA . number_format($precio, 2, '.', ','); ?>
                        </del></p>
                    <h2>
                        <?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?>
                        <small class="text-success">
                            <?php echo $descuento; ?> % descuento
                        </small>
                    </h2>
                    <?php } 
                     else { ?>
                    <h2>
                        <?php echo MONEDA . number_format($precio, 2, '.', ','); ?>
                    </h2>
                    <?php } ?>

                    <p class="lead">
                        <?php echo $descripcion;?>
                    </p>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button">Comprar Ahora</button>
                        <button class="btn btn-outline-primary" type="button"
                            onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al
                            Carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
    <script>
        function addProducto(id, token) {
            /*AJAX */
            /* let url='classes/carrito.php'
             let formData = new FormData()
             formData.append('id', $id)
             formData.append('token', token)
 
             fetch(url,{
                 method: 'POST',
                 body :formData,
                 mode: 'cors'
             }).then(response => response.json())
             
             .then(data=>{
                 if(data.ok){
                     let elemento = document.getElementById("num_cart")
                     elemento.innerHTML =data.numero
                 }
             })*/
            let url = 'classes/carrito.php';
            let formData = new FormData();
            formData.append('id', id); // Corregido $id a id
            formData.append('token', token);

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let elemento = document.getElementById("num_cart");
                        elemento.innerHTML = data.numero;
                    }
                });

        }


    </script>

</body>

</html>