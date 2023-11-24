<?php session_start(); ?>
<?php

    error_reporting(E_ALL);

    if(!isset($_SESSION['crisdaSession'])){
        header('Location: index.php');
    }
    
    include('conn.php');

    $products = mysqli_query($conn, "SELECT * FROM products");
    $categories = mysqli_query($conn, "SELECT * FROM categories");
    $categories_edit = mysqli_query($conn, "SELECT * FROM categories");
    $categories_src = mysqli_query($conn, "SELECT * FROM categories");
    
    $categories_obj = [];

    while($cat=mysqli_fetch_object($categories_src)){
        array_push($categories_obj, $cat);
    }
    
    // $products_q = mysqli_query($conn, "SELECT p.id, p.name, p.descripion, p.price, c.id as catid, c.name as category FROM products p INNER JOIN categories c ON p.category_id = c.id");
    // die(var_dump(mysqli_fetch_object($products_q)));
    
    
    if(isset($_POST) AND isset($_POST['action'])){
        
        
        if($_POST['action'] == 'close-session'){
            session_destroy();
            header('Location: index.php');
        }
        
        if($_POST['action'] == 'add'){

            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = str_replace('.', '', $_POST['price']);
            $extension = $_FILES['photo']['type'] == 'image/jpeg' ? '.jpg' : '.png';
            $image = str_replace(' ', '', $_FILES['photo']['name']);
            $category_id = $_POST['category_id'];

            move_uploaded_file($_FILES['photo']['tmp_name'], '../resources/photos/'.$image);
            
            $product_insert = mysqli_query($conn, "INSERT INTO products(name, description, price, image, category_id) VALUES ('".$name."', '".$description."', ".$price.", '".$image."', '".$category_id."')");
            header('Location: products.php');
            
        }
        
        if($_POST['action'] == 'edit'){

            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = str_replace('.', '', $_POST['price']);
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];

            $product_update = mysqli_query($conn, "UPDATE products SET name='".$name."', description='".$description."', price=".$price.", category_id='".$category_id."' WHERE id = ".$id);

            if(isset($_FILES) AND isset($_FILES['photo-edit']) AND $_FILES['photo-edit']['name'] != ''){
                $extension = $_FILES['photo-edit']['type'] == 'image/jpeg' ? '.jpg' : '.png';
                
                $image = str_replace(' ', '', $_FILES['photo-edit']['name']);
                
                move_uploaded_file($_FILES['photo-edit']['tmp_name'], '../resources/photos/'.$image);
                
                $product_image_update = mysqli_query($conn, "UPDATE products SET image='".$image."' WHERE id = ".$id);
            }

            header('Location: products.php');
            
        }
        
        if($_POST['action'] == 'delete'){
            
            $id = $_POST['id'];
            $delete_product = mysqli_query($conn, 'DELETE FROM products WHERE id='.$id);
            header('Location: products.php');

        }


    }

?>

<html>
    <head>
        <title>Crisda Admin</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../css/simple-line-icons.min.css">

        <style>

            @font-face {
                font-family: regular;
                src: url(../fonts/Montserrat/static/Montserrat-Regular.ttf);
            }

            @font-face {
                font-family: light;
                src: url(../fonts/Montserrat/static/Montserrat-Light.ttf);
            }

            @font-face {
                font-family: bold;
                src: url(../fonts/Montserrat/static/Montserrat-Bold.ttf);
            }

            * { margin: 0 auto; padding: 0; box-sizing: border-box }

            html{
                background-color: aliceblue;
                font-family: regular;
            }

            button, select{
                background-color:  #1d283b;
                border: none;
                color: white;
                padding: 7px;
                border-radius: 20px;
                cursor: pointer;
                padding-left: 15px;
                padding-right: 15px;
                font-size: 13px;
            }

            a {
                color: #1d283b;
                text-decoration: none;
            }

            input, textarea{
                margin: 5px;
                border-radius: 10px;
                border: none;
                padding: 10px;
                box-shadow: 0 .1em 4px gray;
            }

            .logo{
                text-align: center;
                margin: 15px;
            }
            
            .logo img{
                width: 50px;
            }

            .menu {
                list-style: none;
                text-align: center;
                padding: 0;
            }
            
            .menu li{
                display: inline-block;
                margin: 5px;
                cursor: pointer;
            }
            
            .menu li.active{
                font-family: bold;
            }

            .container .create {
                float: right;
                margin: 20px;
            }

            table {
                width: 90%;
                border-spacing: 0;
            }
            
            table thead tr th {
                background-color:  #1d283b;
                color: white;
                font-family: light;
                padding: 5px;
                margin: 0;
            }
            
            table tbody{
                background-color: white
            }

            table tbody tr td {
                padding: 5px;
            }
            
            table tbody tr td:first-child {
                text-align: center;
            }

            table button{
                margin: 3px;
            } 

            table tr td {
                text-align: center;
            }

            .modal {
                background-color: rgba(0,0,0,0.5);
                width: 100%;
                height: 100%;
                display: none;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align:center;
                position: fixed;
                top: 0;
                left: 0;
                overflow: auto;
                z-index: 2;
            }
            
            .modal .modal-container{
                background-color: aliceblue;
                border-radius: 20px;
                padding: 30px;
                margin-bottom: 50px;
            }
            
            .modal .modal-container h3{
                margin-bottom: 20px;
            }

            .modal form {
                display: inline-flex;
                flex-direction: column;
            }
            
            .modal form *:not(label) {
                margin: 6px;
            }

            .photo-preview, .photo-edit-preview {
                width: 150px;
                height: 200px;
                background-color: lightgray;
                display: flex;
                align-items: center;
                justify-content: center;
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
                position: relative;
            }


            .photo-clean, .photo-edit-clean{
                width: 20px;
                height: 20px;
                border-radius: 20px;
                background-color: red;
                color: white;
                position: absolute;
                top: -10;
                right: -10;
                cursor: pointer;
                display: none;
            }

            </style>
    </head>

    <body>  

            <div class="modal add">
                <div class="modal-container" style="margin-top: 150px;">
                    <h3>Crear producto</h3>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input name="action" value="add" type="hidden" />

                        <label for="photo">
                            <div class="photo-preview">
                                <p>+ <br/> Foto</p>
                                <p class="photo-clean">X</p>
                            </div>
                        </label>
                        <input style="display: none;" required accept="image/*" id="photo" name="photo" type="file" />

                        <label for="name">Nombre</label>
                        <input required id="name" name="name" type="text" />

                        <label for="description">Descripcion</label>
                        <textarea required id="description" name="description"></textarea>
                        
                        <label for="category_id">Categoria</label>
                        <select required style="background-color: white; color: #1d283b; box-shadow: 0 .2em 7px gray;" name="category_id" id="category_id">
                            <?php while($category=mysqli_fetch_object($categories)){ ?>
                                <option value="<?=$category->id?>"><?=$category->name?></option>
                            <?php } ?>
                        </select>

                        <label for="price">Precio</label>
                        <input required id="price" name="price" type="text" />

                        <button type="submit">Guardar</button>
                        <p class="close-modal" style="cursor: pointer;">Cancelar</p>
                    </form>
                </div>
            </div>

            <div class="modal edit">
                <div class="modal-container" style="margin-top: 150px;">
                    <h3>Editar producto</h3>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input name="action" value="edit" type="hidden" />
                        <input name="id" value="" type="hidden" />

                        <label for="photo-edit">
                            <div class="photo-edit-preview">
                                <p>+ <br/> Foto</p>
                                <p class="photo-edit-clean">X</p>
                            </div>
                        </label>
                        <input style="display: none;" accept="image/*" id="photo-edit" name="photo-edit" type="file" />

                        <label for="name">Nombre</label>
                        <input id="name" name="name" type="text" />

                        <label for="description">Descripcion</label>
                        <textarea id="description" name="description"></textarea>

                        <label for="category_id">Categoria</label>
                        <select style="background-color: white; color: #1d283b; box-shadow: 0 .2em 7px gray;" name="category_id" id="category_id">
                            <?php while($category=mysqli_fetch_object($categories_edit)){ ?>
                                <option value="<?=$category->id?>"><?=$category->name?></option>
                            <?php } ?>
                        </select>

                        <label for="price">Precio</label>
                        <input id="price" name="price" type="text" />
                        
                        <button type="submit">Guardar</button>
                        <p class="close-modal" style="cursor: pointer;">Cancelar</p>
                    </form>
                </div>
            </div>

            <div class="logo">
                <img src="../img/logo.gif" />
                <h3>CRISDA</h3>
            </div>

            <div style="position: absolute; top: 20px; right: 20px; z-index: 1;">
                <form action="" method="POST"><input name="action" type="hidden" value="close-session"/><button type="submit">Cerrar sesion</button></form>
            </div>

            <ul class="menu">
                <li class="active"><a href="products.php">Productos</a></li>
                <li><a href="categories.php">Categorias</a></li>
            </ul> 

            <div class="container">
                <button class="create">Crear producto</button>

                <table>
                    <thead>
                        <tr>
                            <th style="border-radius: 15px 0 0 0;">Id</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Categoria</th>
                            <th>Imagen</th>
                            <th style="border-radius: 0 15px 0 0;">Accion</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while($product = mysqli_fetch_object($products)){ 

                            foreach($categories_obj as $catobj){
                                if($catobj->id == $product->category_id){
                                    $product->category_name = $catobj->name;
                                }
                            }

                            ?>
                            
                            <tr data-cat="<?=$product->category_id?>">
                                <td><?=$product->id?></td>
                                <td class="product-name"><?=$product->name?></td>
                                <td class="product-description"><?=$product->description?></td>
                                <td class="product-price"><?=$product->price?></td>
                                <td class="product-category"><?=$product->category_name?></td>
                                <td class="product-image"><img style="width: 50px; height: 65px;" src="../resources/photos/<?=$product->image?>" /></td>
                                <td style="text-align: center;"><button data-id="<?=$product->id?>" class="edit-prod">Editar</button>
                                <form action="" method="POST"><input type="hidden" name="action" value="delete" /><input type="hidden" name="id" value="<?=$product->id?>" /><button type="submit" class="delete">Borrar</button></form>
                                </td>
                            </tr>

                        <?php } ?>
                        
                        <?php if($products->num_rows <= 0){ ?>
                            <tr>
                                <td colspan="7">Sin registros (0)</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <script type="text/javascript" src="../js/jquery-3.7.0.min.js"></script>
            <script>
                $(document).ready(function(){
                    
                    function numberWithCommas(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }

                    $('.create').click(function(){
                        $('.modal.add').fadeIn().css('display', 'flex');
                    });

                    $('.product-price').each(function(){
                        $(this).html(numberWithCommas($(this).html()));
                    })
                    
                    
                    $('[name="price"]').keyup(function(){
                        let val = $(this).val().replace(/\./g, ''),
                            val_with_commas = numberWithCommas(val);

                            $(this).val(val_with_commas);
                    });

                    
                    $('.edit-prod').click(function(){
                        let name = $(this).parent().parent().find('.product-name').html();
                        let description = $(this).parent().parent().find('.product-description').html();
                        let price = $(this).parent().parent().find('.product-price').html();
                        let category = $(this).parent().parent().data('cat');
                        let image = $(this).parent().parent().find('.product-image img').attr('src');
                        
                        $('.modal.edit').fadeIn().css('display', 'flex');
                        $('.photo-edit-preview p').fadeOut();
                        $('.photo-edit-preview .photo-edit-clean').fadeIn();

                        $('.modal.edit .photo-edit-preview').css('background-image', 'url('+image+')');

                        $('.modal.edit input[name="name"]').val(name);
                        $('.modal.edit textarea[name="description"]').val(description);
                        $('.modal.edit input[name="price"]').val(price);
                        $('.modal.edit select[name="category_id"]').val(category);

                        $('.modal.edit input[name="id"]').val($(this).data('id'));

                    });

                    $('.close-modal').click(function(){
                        $(this).parent().parent().parent().fadeOut();
                        $('.product-edit-preview').css('background-image', '');
                        $('.product-preview').css('background-image', '');
                    });

                    document.getElementById('photo').onchange = evt => {
                        const [file] = document.getElementById('photo').files
                        if (file) {
                            $('.photo-preview').css('background-image', 'url('+URL.createObjectURL(file)+')');
                            $('.photo-preview p').fadeOut();
                            $('.photo-clean').fadeIn();
                        }
                    }

                    document.getElementById('photo-edit').onchange = evt => {
                        const [file] = document.getElementById('photo-edit').files
                        if (file) {
                            $('.photo-edit-preview').css('background-image', 'url('+URL.createObjectURL(file)+')');
                            $('.photo-edit-preview p').fadeOut();
                            $('.photo-edit-clean').fadeIn();
                        }
                    }
                    
                    $('.photo-clean').click(function(e){
                        e.preventDefault();
                        $('.photo-preview').css('background-image', 'url()');
                        $('.photo-preview p').fadeIn();
                        $(this).fadeOut(); 
                    });

                    $('.photo-edit-clean').click(function(e){
                        e.preventDefault();
                        $('.photo-edit-preview').css('background-image', 'url()');
                        $('.photo-edit-preview p').fadeIn();
                        $(this).fadeOut(); 
                    });

                });
            </script>
    </body>
</html>