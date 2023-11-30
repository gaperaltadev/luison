<?php session_start(); ?>
<?php

    if(!isset($_SESSION['barberSession'])){
        header('Location: index.php');
    }
    
    include('conn.php');
    
    $categories = mysqli_query($conn, "SELECT * FROM categories");

    if(isset($_POST) AND isset($_POST['action'])){

        if($_POST['action'] == 'close-session'){
            session_destroy();
            header('Location: index.php');
        }
                
        if($_POST['action'] == 'add'){
            
            $name = $_POST['name'];
            $name = $_POST['description'];

            $category_insert = mysqli_query($conn, "INSERT INTO categories(name) VALUES ('".$name."', '".$description."') ");
            header('Location: categories.php');

        }

        if($_POST['action'] == 'edit'){
            
            $id = $_POST['id'];
            $name = $_POST['name'];
            $category_update = mysqli_query($conn, "UPDATE categories SET name='".$name."' WHERE id = ".$id);
            header('Location: categories.php');
            
        }

        if($_POST['action'] == 'delete'){
            
            $id = $_POST['id'];

            $delete_category = mysqli_query($conn, 'DELETE FROM categories WHERE id='.$id);
            header('Location: categories.php');
            
        }

    }

?>

<html>
    <head>
        <title>Luison Admin</title>

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
                z-index: 2;
            }
            
            .modal .modal-container{
                background-color: aliceblue;
                border-radius: 20px;
                padding: 30px;
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

            

            </style>
    </head>

    <body>  

            <div class="modal add">
                <div class="modal-container">
                    <h3>Crear categoria</h3>
                    <form method="POST" action="">
                        <input name="action" value="add" type="hidden" />
                        <label for="name">Nombre de la categoria</label>
                        <input required id="name" name="name" type="text" />
                        <label for="name">Descripción</label>
                        <textarea required id="description" name="description" ></textarea>
                        <button type="submit">Guardar</button>
                        <p class="close-modal" style="cursor: pointer;">Cancelar</p>
                    </form>
                </div>
            </div>

            <div class="modal edit">
                <div class="modal-container">
                    <h3>Editar categoria</h3>
                    <form method="POST" action="">
                        <input name="action" value="edit" type="hidden" />
                        <input name="id" value="" type="hidden" />
                        <label for="name">Nombre de la categoria</label>
                        <input required id="name" name="name" type="text" />
                        <label for="name">Descripcion</label>
                        <textarea required id="description" name="description"></textarea>
                        <button type="submit">Guardar</button>
                        <p class="close-modal" style="cursor: pointer;">Cancelar</p>
                    </form>
                </div>
            </div>

            <div class="logo">
                <img src="../img/Logo.jpg" />
                <h3>Luison Barber</h3>
            </div>

            <div style="position: absolute; top: 20px; right: 20px; z-index: 1;">
                <form action="" method="POST"><input name="action" type="hidden" value="close-session"/><button type="submit">Cerrar sesion</button></form>
            </div>

            <ul class="menu">
                <li><a href="scheduling.php">Agendamientos</a></li>
                <li><a href="products.php">Productos</a></li>
                <li class="active"><a href="categories.php">Categorias</a></li>
                <li><a href="subcategories.php">Sub Categorias</a></li>
            </ul> 

            <div class="container">
                <button class="create">Crear categoria</button>

                <table>
                    <thead>
                        <tr>
                            <th style="border-radius: 15px 0 0 0;">Id</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th style="border-radius: 0 15px 0 0;">Accion</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while($category = mysqli_fetch_object($categories)){ ?>
                            
                            <tr>
                                <td style='border: 1px solid gray'><?=$category->id?></td>
                                <td style='border: 1px solid gray' class="category-name"><?=$category->name?></td>
                                <td style='border: 1px solid gray' class="category-description"><?=$category->description?></td>
                                <td style="text-align:center; border: 1px solid gray;">
                                    <button data-id="<?=$category->id?>" class="edit-cat">Editar</button>
                                    <form action="" method="POST"><input type="hidden" name="action" value="delete" /><input type="hidden" name="id" value="<?=$category->id?>" /><button data-id="<?=$category->id?>" class="delete">Borrar</button></form>
                                </td>
                            </tr>

                        <?php } ?>
                        
                        <?php if($categories->num_rows <= 0){ ?>
                            <tr>
                                <td style='padding: 20px 0; font-weight: bold;' colspan="4">Sin registros (0)</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <script type="text/javascript" src="../js/jquery-3.7.0.min.js"></script>
            <script>
                $(document).ready(function(){

                    $('.create').click(function(){
                        $('.modal.add').fadeIn().css('display', 'flex');
                    });
                    
                    $('.edit-cat').click(function(){
                        let name = $(this).parent().parent().find('.category-name').html();
                        $('.modal.edit').fadeIn().css('display', 'flex');
                        $('.modal.edit input[name="name"]').val(name);
                        $('.modal.edit input[name="id"]').val($(this).data('id'));
                    });

                    $('.close-modal').click(function(){
                        $(this).parent().parent().parent().fadeOut();
                    });

                });
            </script>
    </body>
</html>