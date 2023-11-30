<?php session_start(); ?>
<?php

    error_reporting(E_ALL);

    if(!isset($_SESSION['barberSession'])){
        header('Location: index.php');
    }
    
    include('conn.php');

    $shifts = mysqli_query($conn, "SELECT * FROM shifts ORDER BY id DESC");
    
    
    // $products_q = mysqli_query($conn, "SELECT p.id, p.name, p.descripion, p.price, c.id as catid, c.name as category FROM products p INNER JOIN categories c ON p.category_id = c.id");
    // die(var_dump(mysqli_fetch_object($products_q)));
    
    
    if(isset($_POST) AND isset($_POST['action'])){
        
        if($_POST['action'] == 'close-session'){
            session_destroy();
            header('Location: index.php');
        }
        
        
        if($_POST['action'] == 'delete'){
            
            $id = $_POST['id'];
            $delete_shift = mysqli_query($conn, 'DELETE FROM shifts WHERE id='.$id);
            header('Location: scheduling.php');

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


            <div class="logo">
                <img src="../img/Logo.jpg" />
                <h3>Luison Barber</h3>
            </div>

            <div style="position: absolute; top: 20px; right: 20px; z-index: 1;">
                <form action="" method="POST"><input name="action" type="hidden" value="close-session"/><button type="submit">Cerrar sesion</button></form>
            </div>

            <ul class="menu">
                <li class="active"><a href="scheduling.php">Agendamientos</a></li>
                <li><a href="products.php">Productos</a></li>
                <li><a href="categories.php">Categorias</a></li>
                <li><a href="subcategories.php">Sub Categorias</a></li>
            </ul> 

            <div class="container" style="margin-top: 50px;">

                <table>
                    <thead>
                        <tr>
                            <th style="border-radius: 15px 0 0 0;">Id</th>
                            <th>Cliente</th>
                            <th>Telefono</th>
                            <th>Fecha desde</th>
                            <th>Fecha hasta</th>
                            <th style="border-radius: 0 15px 0 0;">Accion</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while($shift = mysqli_fetch_object($shifts)){ 

                            ?>
                            
                            <tr>
                                <td><?=$shift->id?></td>
                                <td><?=$shift->client?></td>
                                <td><a href=""><?=$shift->phone?></a></td>
                                <td><?=$shift->dateFrom?></td>
                                <td><?=$shift->dateTo?></td>
                                <td style="text-align: center;">
                                <form action="" method="POST"><input type="hidden" name="action" value="delete" /><input type="hidden" name="id" value="<?=$shift->id?>" /><button type="submit" class="delete">Borrar</button></form>
                                </td>
                            </tr>

                        <?php } ?>
                        
                        <?php if($shifts->num_rows <= 0){ ?>
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
                    
 

                });
            </script>
    </body>
</html>