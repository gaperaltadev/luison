<?php session_start(); ?>
<?php
    
    if(isset($_POST) AND isset($_POST['action'])){
        
        if($_POST['action'] == 'login'){
            if($_POST['user'] == 'admin' AND $_POST['pwd'] == 'Asuncion2023'){
                $_SESSION['barberSession'] = 1;
                header('Location: scheduling.php');
            }else{
                header('Location: login.php?error=1');
            }
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

            h3{
                text-align: center;
                margin-bottom: 50px;
            }

            form{

                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;

            }
       

            </style>
    </head>

    <body>  

            <div class="logo">
                <img src="../img/Logo.jpg" />
                <h3>Luison Barber</h3>
            </div>


            <div class="container">
                <h3>Administracion</h3>
              <form method="POST" action="">
                    <input name="action" type="hidden" value="login"/>
                    <input name="user" placeholder="Usuario" type="text"/>
                    <input name="pwd" placeholder="Clave" type="password"/>
                    <button type="submit">Acceder</button>

                    <?php if(isset($_GET['error'])){ ?>
                        <p style="color: red">Datos incorrectos</p>
                    <?php } ?>

              </form>
            </div>

            
    </body>
</html>