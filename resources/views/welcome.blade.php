<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>  {{ config('app.name', 'Laravel') }} - Inicio</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
		<link rel="shortcut icon" href="https://res.cloudinary.com/vgd/image/upload/c_scale,h_2000/v1675039059/logo/LO_mvdc7e.png" type="image/x-icon">

        <!-- Styles -->
        	<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

<!-- Bootstrap -->

<link href="{{ asset('plantilla/css/bootstrap.min.css') }}" rel="stylesheet">



<!-- Slick -->
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

<!-- nouislider -->
<link href="{{ asset('plantilla/css/nouislider.min.css') }}" rel="stylesheet">


<!-- Font Awesome Icon -->
<link href="{{ asset('plantilla/css/font-awesome.min.css') }}" rel="stylesheet">

<!-- Custom stlylesheet -->
<link href="{{ asset('plantilla/css/style.css') }}" rel="stylesheet">

       

        <style>
           .social {
	position: fixed; /* Hacemos que la posición en pantalla sea fija para que siempre se muestre en pantalla*/
	left: 0; /* Establecemos la barra en la izquierda */
	top: 50%; /* Bajamos la barra 200px de arriba a abajo */
	z-index: 2000; /* Utilizamos la propiedad z-index para que no se superponga algún otro elemento como sliders, galerías, etc */
}

	.social ul {
		list-style: none;
	}

	.social ul li a {
		display: inline-block;
		color:#fff;
		background: #000;
		padding: 10px 15px;
		text-decoration: none;
		-webkit-transition:all 500ms ease;
		-o-transition:all 500ms ease;
		transition:all 500ms ease; /* Establecemos una transición a todas las propiedades */
	}
    .social li img{ float:left;}
	.social ul li  .icon-facebook {background:#3b5998;
    } /* Establecemos los colores de cada red social, aprovechando su class */
	.social ul li .icon-twitter {background: #00abf0;}
	.social ul li .icon-instagram {background: #C13584;}
	.social ul li .icon-youtube {background: #ae181f;}
	.social ul li .icon-mail {background: #666666;}

	.social ul li a:hover {
		background: #000; /* Cambiamos el fondo cuando el usuario pase el mouse */
		padding: 10px 30px; /* Hacemos mas grande el espacio cuando el usuario pase el mouse */
	}
        </style>
    </head>
    <body class="antialiased">
	<!-- HEADER -->
    <header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
                    @foreach ($empresa_datos as $d)
						<li><a href="#"><i class="fa fa-phone"></i>{{$d->telefono}} </a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i>{{$d->email}}</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i>{{$d->direccion}}</a></li>
                        @endforeach
					</ul>
					<ul class="header-links pull-right">
						<li><a href="#"><i class="fa fa-dollar"></i> USD</a></li>
						@if (Route::has('login'))
           
                    @auth
					<li> <a href="{{ url('/home') }}"><i class="fa fa-user-o"></i> My Account</a></li>
                    @else
					<li> <a href="{{ route('login') }}"><i class="fa fa-user-o"></i> Log in</a></li>

                        @if (Route::has('register'))
                      <!--  <li> <a href="{{ route('register') }}"><i class="fa fa-user-o"></i> Registrar</a></li> -->
                        @endif
                    @endauth
             
            @endif


					</ul>
				</div>
			</div>
			<div class="social">
		<ul>
			<li><a href="https://www.facebook.com/javier.velasque.562" target="_blank" class="icon-facebook"><i class='link-facebook fa fa-facebook-square'  style="font-size:35px;margin-left: 2px"></i></a></li>
			<li><a href="#" target="_blank" class="icon-twitter"><i class='fa fa-twitter-square' style="font-size:35px;margin-left: 2px"></i></a></li>
			<li><a href="https://www.instagram.com/xaviervg20/?hl=es-la" target="_blank" class="icon-instagram"><i class="fa fa-instagram"  style="font-size:35px;margin-left: 2px"></i></i></a></li>
			<li><a href="#" target="_blank" class="icon-youtube"><i class="fa fa-youtube"  style="font-size:35px;margin-left: 2px"></i></i></a></li>
		</ul>
	</div>

			<!-- /TOP HEADER -->
		
		</header>
			




		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Productos</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<li class="active"><a data-toggle="tab" href="#tab1">Todo</a></li>
							
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1">
										<!-- product -->
										@foreach ($articulos as $a)
										<div class="product">
											<div class="product-img">
												<img src="{{$a->file_url}}" style="height: auto;
max-width: 100%;" alt="">
												
											</div>
											<div class="product-body" >
												<p class="product-category">{{$a-> nombre_categoria}}</p>
												<h3 class="product-name"><a href="#">{{$a->nombre}}</a></h3>
												<h4 class="product-price">$ {{$a->precio_venta}}</h4>
												
												
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Ver</button>
											</div>
										</div>
										<!-- /product -->
										@endforeach

									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->


    </body>
	<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <script src="{{asset('plantilla/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{asset('plantilla/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script src="{{asset('plantilla/js/nouislider.min.js') }}" type="text/javascript"></script>
    <script src="{{asset('plantilla/js/jquery.zoom.min.js') }}" type="text/javascript"></script>
    <script src="{{asset('plantilla/js/main.js') }}" type="text/javascript"></script>

 
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

</body>
</html>
