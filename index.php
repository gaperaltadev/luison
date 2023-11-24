<?php 

    if(isset($_POST['name'])){

        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $msg = $_POST['msg'];

        // mail("gaboo2332@gmail.com", "Web Crisda", $name.' - '.$phone.' - '.$msg);

        $header = "From: noreply@crisda.com\r\n";
        $header.= "MIME-Version: 1.0\r\n";
        $header.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $header.= "X-Priority: 1\r\n";

        $status = mail("gaboo2332@gmail.com", 'Web Crisda', $name.' - '.$phone.' - '.$msg, $header);
    }

    include('./admin/conn.php');

    $products = mysqli_query($conn, "SELECT * FROM products");
    $categories = mysqli_query($conn, "SELECT * FROM categories");

?>


<html>
    <head>
        <title>Luison Barber</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="./vendors/fullPage.js-master/dist/fullpage.css" />
        <link rel="stylesheet" href="./css/simple-line-icons.min.css">
        <link rel="icon" href="./img/logo.gif">
        
        
        <style type="text/css">
            
            @font-face {
                font-family: regular;
                src: url(./fonts/Montserrat/static/Montserrat-Regular.ttf);
            }
            
            @font-face {
                font-family: light;
                src: url(./fonts/Montserrat/static/Montserrat-Light.ttf);
            }

            @font-face {
                font-family: bold;
                src: url(./fonts/Montserrat/static/Montserrat-Bold.ttf);
            }
            
            @font-face {
                font-family: logo;
                src: url(./fonts/Alinore.otf);
            }
            
            * {
                margin: 0 auto;
                padding: 0;
                box-sizing: border-box;
                font-family: light;
            }
            
            html, body{
                color: black;
                background-color: white;
            }
            
            a {
                font-weight: bold;
                color: black;
                text-decoration: none;
            }
            
            h2 {
                text-align: center;
            }
            
            button, select{
                background-color:  black;
                border: none;
                color: white;
                padding: 7px;
                border-radius: 20px;
                cursor: pointer;
                padding-left: 15px;
                padding-right: 15px;
                font-size: 13px;
            }
            
            input, textarea{
                margin: 5px;
                border-radius: 10px;
                border: none;
                padding: 10px;
                box-shadow: 0 .1em 4px gray;
            }
            
            header{
                width: 100%;
                display: flex;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 9;
            }
            
            header .logo{
                margin-top: 15px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            
            header .logo h3 {
                font-family: logo;
                font-size: 40px;
            }
            
            header .logo img{
                width: 70px;
                position: relative;
                right: -25px;
            }
            
            header .menu ul
            {
                list-style: none;
            }
            
            header .menu ul li:not(.cart-popup li) {
                display: inline-block;
                padding: 15px;
                cursor: pointer;
            }
            
            .mobile-menu-icon {
                display: none !important;
            }
            
            .video-shade {
                width: 100%;
                height: 100%;
                background-color: rgba(255,255,255,0.3);
                position: absolute;
                z-index: 9;
                top: 0;
                left: 0;
            }
            
            .products{
                min-height: 350px;
                width: 100%;
                margin: 20px;
                list-style: none;
                overflow: scroll;
                white-space: nowrap;
            }
            
            .products-top{
                display: flex;
                flex-direction: row;
            }
            
            .products-filter{
                margin: 0;
            }
            
            .products li{
                text-align: center;
                width: 170px;
                background-color: lightgray;
                padding: 20px;
                border-radius: 20px;
                display: none; 
                margin: 7px;
            }

            .product-image{
                height: 170px;
                background-color: darkgray;
            }
            
            #myVideo {
                position: absolute;
                right: 0;
                bottom: 0;
                min-width: 100%;
                min-height: 100%;
            }

            .fp-is-overflow .fp-overflow.fp-auto-height-responsive, .fp-is-overflow .fp-overflow.fp-auto-height, .fp-is-overflow > .fp-overflow {
                width: 90%;
                overflow-y: hidden;
                overflow-x: hidden;
            }
            
            .arrow{
                font-size: 30px;
                cursor: pointer;
            }
            
            .mobile-menu {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                list-style: none;
                text-align: center;
                width: 100%;
                height: 200px;
                background-color: aliceblue;
                position: fixed;
                bottom: -200px;
                left: 0;
                z-index: 99;
                border-radius: 20px 20px 0 0;
                box-shadow: 0 .1em 4px gray;
            }
            
            .mobile-menu li {
                margin: 10px;
            }
            
            @media screen and (max-width: 768px){
                .menu-to-hide{
                    display: none !important;
                }
                
                .mobile-menu-icon { 
                    display: inline-block !important;
                }
                
                .contact-container{
                    flex-direction: column !important;
                }

                #map {
                    display: none;
                }
                
                .menu ul {
                    margin-top: 20px;
                }
                
            }

            ::-webkit-scrollbar {
            opacity: 1;
        }
        
        .close-mobile-menu{
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 22px;
            cursor:pointer;
            font-family: regular;
        }
        
        .cart-popup{
            text-align: center;
            display: none;
            width: 200px;
            border-radius: 20px;
            position: absolute;
            z-index: 99;
            background-color: white;
            left: -140;
            top:50;
            box-shadow: 0 .2em 6px gray;
        }
        
        .cart-popup li:not(.cart-total){
            display: flex !important;
            flex-direction: row;
            padding: 10px !important;
            text-align: left;
        }
        
        .cart-total{
            display: none;
        }
        
        #map {
            width: 300px;
            height: 300px;
            background-color: lightgray;
        }
        
        .product-modal{
            width: 100%;
            height: 80%;
            background-color: aliceblue;
            position: fixed;
            left: 0;
            bottom: -100%;
            z-index: 99;
            box-shadow: 0 .2em 7px gray;
            border-radius: 30px 30px 0 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        
        .product-modal .product-image-modal{
            width: 200px;
            height: 300px;
            background-color: gray;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        .close-product-modal{
            position: absolute;
            top: 15px;
            right: 25px;
            font-family: bold;
            font-size: 26px;
            cursor: pointer;
        }
        
        </style>
    
</head>


<body>
    
        <div class="product-modal">
            <p class="close-product-modal">X</p>
            <div class="product-image-modal"></div>
            <h3 class="product-modal-title" style="text-transform: uppercase; font-weight: 800; font-family: bold; margin: 10px auto;">Estante</h3>
            <p class="product-modal-description" style="text-align:center;">Nuestra misión es ofrecer soluciones metalúrgicas de vanguardia que superen las expectativas e impulsen el progreso en todo el mundo.</p>
            <h3 class="product-modal-price" style="font-size: 18px;text-transform: uppercase; font-weight: 800; font-family: bold; margin: 10px auto;">200.000 Gs</h3>
        </div>
        
        <div id='loading-screen' style='display: flex; flex-direction: column; justify-content: center; align-items: center; z-index: 9999; position: fixed;background-color: white; height:100%; width:100%; overflow:hidden; top:0; left:0;'>
            <img src="./img/logo.gif" />
            <h1 style="font-family: regular;">Cargando...</h1>
        </div>
        
        <header>
            <div class="logo">
                <img src="./img/logo.gif" />
                <h3>&nbsp;Luison Barber</h3>
            </div>
            <div class="menu">
                <ul>
                    <li class="menu-to-hide"><a href="#firstPage">Inicio</a></li>
                    <li class="menu-to-hide"><a href="#secondPage">Productos</a></li>
                    <li class="menu-to-hide"><a href="#thirdPage">Nosotros</a></li>
                    <li class="menu-to-hide"><a href="#fourthPage">Contacto</a></li>
                    <li class="open-cart" style="position: relative;">
                        <span class="icon-basket"></span>
                        
                        <ul class="cart-popup">

                            <!-- <li>
                                <div class="cart-product-img" style="width: 50px; height: 50px; background-color: gray;margin: 3px;margin-right: 6px;"></div>
                                <div style="margin: 0;">
                                    <h4>Estante</h4>
                                    <p style="font-size: 13px;">200.000 Gs</p>
                                    <p style="font-size: 13px;">Cantidad: 2</p>
                                </div>
                                <div style="margin: 0;">
                                    <span class="icon-trash deleteProduct" style="font-size: 22px; position: relative; left: 15px; top: 15px;"></span>
                                </div>
                            </li> -->


                            <li class="cart-empty">
                                <p>Sin productos (0)</p>
                            </li>

                            <li class="cart-total">
                                <h4 style="margin: 10px auto;">Total: <span style="font-family: light !important;">0 Gs</span></h4>
                            </li>

                                
                            <button class="sendOrder" style="background-color: green;display: none;">Realizar pedido</button>
                            <h4 class="close-cart-popup" style="margin: 7px;text-align: center;">Cerrar</h4>
                            </ul>

                    </li>
                    <li class="mobile-menu-icon"><span class="icon-menu"></span></li>
                </ul>
            </div>
        </header>

        <ul class="mobile-menu">
            <p class="close-mobile-menu">X</p>
            <li><a href="#firstPage">Inicio</a></li>
            <li><a href="#secondPage">Productos</a></li>
            <li><a href="#thirdPage">Nosotros</a></li>
            <li><a href="#fourthPage">Contacto</a></li>
        </ul>

        

        <div id="fullpage">       
            
            <div class="section">
                <h1 style="font-size:45px;font-family:logo; top: 400px;position:absolute;z-index:999;">
                Estilo que habla por sí mismo, <br>
                en cada corte y afeitado.</h1>
                <video autoplay muted loop id="myVideo">
                    <source src="./resources/videoplayback.mp4" type="video/mp4">
                </video>
                <div class="video-shade"></div>
            </div>

            <div class="section">
                
                <div class="products-top">
                    <h2>Productos</h2>
                    <select class="products-filter">
                        <?php while($categories_f = mysqli_fetch_object($categories)){ ?>
                            <option value="<?=$categories_f->id;?>"><?=$categories_f->name;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div style="display: flex; flex-direction: row; justify-content: center; align-items: center;">
                        <span class="arrow icon-arrow-left"></span>
                        <ul class="products">
                            
                            
                            <?php while($products_f = mysqli_fetch_object($products)){ ?>
                                <li data-id="<?=$products_f->id?>" data-cat="<?=$products_f->category_id?>" data-description="<?=$products_f->description?>">
                                    <div class="product-image" style="background-position: center center; background-repeat: no-repeat; background-size: cover; background-image: url(./resources/photos/<?=$products_f->image?>);"></div>
                                    <h3 class="product-title"><?=$products_f->name?></h3>
                                    <p class="product-price"><span><?=$products_f->price?></span> Gs</p>
                                    <div style="display: flex; flex-direction: row; justify-content: center; align-items:center;">
                                        <span style="margin: 0; cursor: pointer;" class="qty-remove icon-minus"></span>
                                        <input readonly style="cursor: inherit; width: 30%; font-family: regular;height: 30px;text-align: center;" type="text" value="1" name="qty" min="1" />
                                        <span style="margin: 0; cursor: pointer;" class="qty-add icon-plus"></span>
                                    </div>
                                    <button class="add-to-cart" style="margin-left: -6px;">Agregar al carrito</button>
                                </li>
                            <?php } ?>

                            <li class="no-products" style="margin: 7px auto;">Sin productos (0)</li>

                        <!-- <li data-id="2" data-cat="1">
                            <div class="product-image" style="background-position: center center; background-repeat: no-repeat; background-size: cover; background-image: url(./resources/photos/silla.jpg);"></div>
                            <h3 class="product-title">Silla</h3>
                            <p class="product-price">150.000 Gs</p>
                            <div style="display: flex; flex-direction: row; justify-content: center; align-items:center;">
                                <span style="margin: 0; cursor: pointer;" class="qty-remove icon-minus"></span>
                                <input readonly style="cursor: inherit; width: 30%; font-family: regular;height: 30px;text-align: center;" type="text" value="1" name="qty" min="1" />
                                <span style="margin: 0; cursor: pointer;" class="qty-add icon-plus"></span>
                            </div>
                            <button class="add-to-cart" style="margin-left: -6px;">Agregar al carrito</button>
                        </li>

                        <li data-id="3" data-cat="1">
                            <div class="product-image" style="background-position: center center; background-repeat: no-repeat; background-size: cover; background-image: url(./resources/photos/ropero.jpg);"></div>
                            <h3 class="product-title">Ropero</h3>
                            <p class="product-price">500.000 Gs</p>
                            <div style="display: flex; flex-direction: row; justify-content: center; align-items:center;">
                                <span style="margin: 0; cursor: pointer;" class="qty-remove icon-minus"></span>
                                <input readonly style="cursor: inherit; width: 30%; font-family: regular;height: 30px;text-align: center;" type="text" value="1" name="qty" min="1" />
                                <span style="margin: 0; cursor: pointer;" class="qty-add icon-plus"></span>
                            </div>
                            <button class="add-to-cart" style="margin-left: -6px;">Agregar al carrito</button>
                        </li> -->
                        
                    </ul>
                    <span class="arrow icon-arrow-right"></span>
                </div>

            </div>
            <div class="section" style="text-align: center;">
                <h2>Nosotros</h2>
                <p style="width: 80%;font-size: 18px; margin: 10px auto; text-align: center;">Nuestra misión es ofrecer soluciones metalúrgicas de vanguardia que superen las expectativas e impulsen el progreso en todo el mundo.
                    Nos esforzamos por superar las demandas de los clientes a través de una calidad, confiabilidad y servicios personalizados.
                    La sustentabilidad está en el centro de nuestros valores, y estamos comprometidos a minimizar nuestra huella ecológica mientras maximizamos el impacto social.</p>
            </div>
            <div class="section">

                <h2>Contacto</h2>
                
                <div class="contact-container" style="display: flex; flex-direction: row; justify-content: center; align-items: center;">
                    <form method="POST" action="" style="display: flex; flex-direction: column; margin-top: 20px; width: 220px;">
                        <input name="name" type="text" placeholder="Nombre" />
                        <input name="phone" type="text" placeholder="Telefono" />
                        <textarea name="message" style="height: 120px;" placeholder="Aqui va tu mensaje"></textarea>
                        <button>Enviar</button>
                    </form>
                    <div>
                        <div id="map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3607.173489663442!2d-57.555786190006515!3d-25.298374577552735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x945daf10a8e69b09%3A0x8704b212a3d2dd8a!2sLuison%20Barber!5e0!3m2!1ses!2spy!4v1700697267946!5m2!1ses!2spy" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script type="text/javascript" src="./js/jquery-3.7.0.min.js"></script>
        <script type="text/javascript" src="./vendors/fullPage.js-master/vendors/easings.js"></script>
        <script type="text/javascript" src="./vendors/fullPage.js-master/dist/fullpage.js"></script>

        <script type="text/javascript">
            
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            $(document).ready(function() {

                let cat = $('.products-filter').val();
                $('.products li[data-cat="'+cat+'"]').fadeIn().css({ display: 'inline-block' });
                
                if($('.products li[data-cat="'+cat+'"]').length <= 0){
                    $('.no-products').fadeIn();
                }
                
                
                $('.products-filter').change(function(){
                    $('.products li').css('display','none');
                    $('.products li[data-cat="'+$(this).val()+'"]').fadeIn().css('display', 'inline-block');

                    if($('.products li[data-cat="'+$(this).val()+'"]').length <= 0){
                        $('.no-products').fadeIn();
                    }

                });

                $('.product-price').each(function(){
                    let price = $(this).find('span').html();
                    $(this).find('span').html(numberWithCommas(price));
                })

                $('ul.products li .product-image').click(function(){

                    let title = $(this).parent().find('.product-title').html(),
                        description = $(this).parent().data('description'),
                        image = $(this).css('background-image'),
                        price = $(this).parent().find('.product-price').html();

                    $('.product-modal-price').html(price);
                    $('.product-modal-title').html(title);
                    $('.product-modal-description').html(description);
                    $('.product-image-modal').css('background-image', image);

                    $('.product-modal').animate({ bottom: 0 }, 500);
                    
                });
                
                $('.close-product-modal').click(function(){
                    
                    $('.product-modal').animate({ bottom: "-100%" }, 500);

                })

                $('.sendOrder').click(function(){

                    let cart = JSON.parse(localStorage.getItem('crisdaCart'));

                    let message = 'Buenas, le hablo desde la web, quiero realizar este pedido: ';

                    cart.map(item => {
                        message += item.qty +' x '+item.title+' '+numberWithCommas(item.price)+' Gs,';
                    });

                    window.open('https://wa.me/+595982249896/?text='+message);

                });

                setTimeout(function(){
                    $('#loading-screen').fadeOut();
                }, 1500);

                function drawCart(){

                    let items = JSON.parse(localStorage.getItem('crisdaCart'));

                    $('.cart-total').fadeOut();
                    $('.cart-total h4').html('Total: 0 Gs');
                    $('.cart-empty').css({ filter: 'opacity(1)', height: 40 });
                    $('li[data-item]').remove();
                    $('.cart-popup button').fadeOut();

                    if(items && items.length <= 0) return false;
                    
                    $('.cart-empty').css({ filter: 'opacity(0)', height: '0' });
                    $('.cart-total').fadeIn();
                    $('.cart-popup button').fadeIn();

                    let htmlToDraw = '';
                    let total = 0;

                    items?.map(item => {

                        total += item.price * item.qty;
                        htmlToDraw += '<li data-item="'+item.id+'"><div class="cart-product-img" style="width: 50px; height: 50px; background-color: gray;margin: 3px;margin-right: 6px; background-position: center center; background-size: cover; background-repeat: no-repeat;background-image: url('+item?.image+');"></div><div style="margin: 0;"><h4>'+item.title+'</h4><p style="font-size: 13px;">'+numberWithCommas(item.price)+' Gs</p><p style="font-size: 13px;">Cantidad: '+item.qty+'</p></div><div style="margin: 0;"><span class="icon-trash deleteProduct" style="font-size: 22px; position: relative; left: 15px; top: 15px;"></span></div></li>';

                    })

                    $('.cart-total h4').html('Total: ' + numberWithCommas(total) + ' Gs');
                    
                    $('.cart-popup').prepend(htmlToDraw).after(function(){
                        
                        $('.deleteProduct').click(function(){
                            
                            let id = $(this).parent().parent().data('item');
                            let cart = JSON.parse(localStorage.getItem('crisdaCart'));
                            let newCart = [];
                            
                            cart.map(item => {
                                if(item.id != id){
                                    newCart.push(item);
                                }
                            });
                            
                            localStorage.setItem('crisdaCart', JSON.stringify(newCart));
                            drawCart();

                        });
                    
                    });
                        
                }

                drawCart();

                    $('.deleteProduct').click(function(){

                        let id = $(this).parent().parent().data('item');
                        let cart = JSON.parse(localStorage.getItem('crisdaCart'));
                        let newCart = [];

                        cart.map(item => {
                            if(item.id != id){
                                newCart.push(item);
                            }
                        });

                        localStorage.setItem('crisdaCart', JSON.stringify(newCart));
                        drawCart();

                    });



                $('.add-to-cart').click(function(){
                    let id = $(this).parent().data('id'),
                        title = $(this).parent().find('.product-title').html(),
                        image = $(this).parent().find('.product-image').css('background-image').replace('url("', '').replace('")', ''),
                        price = $(this).parent().find('.product-price span').html().replace(' ', '').replace(/\./g,''),
                        qty = $(this).parent().find('[name="qty"]').val();


                        let cart = JSON.parse(localStorage.getItem('crisdaCart'));

                    if(cart == null || cart.length <= 0){
                        
                        let item_to_add = [{ id, title, image, price, qty }];
                        localStorage.setItem('crisdaCart', JSON.stringify(item_to_add));

                    }else{
                        
                        let newCart = cart;
                        
                        let existsOnCart = 0;

                        newCart.map(item => {
                            if(item.id == id){
                                existsOnCart += 1;
                                item.qty = qty;
                            }
                        })

                        if(existsOnCart == 0){
                            newCart.push({ id, title, image, price, qty });
                        }

                        localStorage.setItem('crisdaCart', JSON.stringify(newCart));
                        
                    }
                    
                    $('.cart-popup').slideDown();
                    drawCart();
                    
                });

                $('#fullpage').fullpage({
                    //options here
                    navigation: false,
                    scrollingSpeed: 700,
                    easing: 'easeInOutCubic',
                    loopTop: true,
                    loopBottom: true,
                    anchors:['firstPage', 'secondPage', 'thirdPage', 'fourthPage'],
                    onLeave: function(origin, destination, direction, trigger){

                        if(destination.index == 0){
                            document.getElementById("myVideo").play();
                        }

                    },
                });

                $('.fp-watermark').remove();

                $('.icon-arrow-left').click(function(){
                    $('.products').animate({ scrollLeft: $(".products").scrollLeft() - 200 });
                });

                $('.icon-arrow-right').click(function(){
                    $('.products').animate({ scrollLeft: $(".products").scrollLeft() + 200 });
                });

                $('.mobile-menu-icon').click(function(){

                    $('.mobile-menu').animate({ 
                        bottom: 0
                    })

                }); 

                $('.mobile-menu li, .close-mobile-menu').click(function(){
                    setTimeout(function(){
                        $('.mobile-menu').animate({ 
                        bottom: -220
                        });
                    }, 500);
                });

                $('.qty-add').click(function(){

                    var qty = $(this).parent().find('input').val();
                    $(this).parent().find('input').val(parseInt(qty)+1);

                });

                $('.qty-remove').click(function(){
                    var qty = $(this).parent().find('input').val();

                    if(qty == 1) return false;

                    $(this).parent().find('input').val(parseInt(qty)-1);

                });

                $('.open-cart').click(function(){
                    $('.cart-popup').slideDown();
                });
                
                $('.close-cart-popup').click(function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    $('.cart-popup').slideUp();
                });
                
            });

        </script>

    </body>
</html>