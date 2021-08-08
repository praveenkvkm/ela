<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>BoersIndia</title>
  
  <link rel="icon" href="/images/favicon/favicon.jpg" type="image/gif" sizes="16x16">
  <!-- Bootstrap Stylesheet -->
  <!-- Including the bootstrap CDN -->
    <link rel="stylesheet" href= 
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> 
    <script src= 
"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> 
    </script> 
    <script src= 
"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"> 
    </script> 
    <script src= 
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"> 
    </script>   <!-- Bootstrap Js -->
	
  <!-- Bootstrap Stylesheet -->
 
 
 <style>

.carousel-caption	/* TO MAINTAIN POSTION OF SLIDER CAPTION */
{
	top: 80%;
	transform: translateY(-80%);
	bottom: initial;
}

.responsive-image 
{
  height: auto;
  width: 22vw;
}

.navbar-custom 
{
    background-color: #f8f8f9!important;
	padding: 0rem 1rem;
}

.custom-toggler .navbar-toggler-icon {
  background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(201,207,208, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
}

.custom-toggler.navbar-toggler {
  border-color: rgb(201,207,208);
} 

a  {
    color: #159a38;
    font-weight: 700;
}

a:hover {
    color: #14ec4d;
}

.title {
	
	background: -webkit-linear-gradient(#006600 0%, #33cc33 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 700;
}

 </style>
<script>
		jQuery(document).ready(function() {
			jQuery(window).resize(function() {
				jQuery('#main').css("padding-top", 
				jQuery("#header").height());
			}).resize();
		});
	</script></head>
<body>
 
  <!-- Responsive Navigation Bar -->
	<nav id="header" class="navbar navbar-expand-lg fixed-top navbar-custom">
		<a class="navbar-brand" href="#">
			<img class="responsive-image" src="images/logo/logo-boers5.png" alt="logo" />
		</a>
		<button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
		  aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
 
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto ">
				<li class="nav-item active">
					<a class="nav-link" href="#">Home
						<span class="sr-only">(current)</span>
					</a>
				</li>
				<!--
				<li class="nav-item">
					<a class="nav-link" href="#">Blog</a>
				</li>
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="false">
					Services
				  </a>
				  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Something else here</a>
				  </div>
				</li>
				-->
				<li class="nav-item">
					<a href="#" class="nav-link">About Us</a>
				</li>
				<li class="nav-item">
				  <a href="#" class="nav-link">Contact Us</a>
				</li>
			</ul>
			

			<!--
			<form class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-danger my-2 my-sm-0" type="submit">Submit</button>
			</form>
			-->
		</div>
	</nav>
<!-- Responsive Navigation Bar -->
<section id="main"> 
	<div class="container-flow">
		<div class="row">
			<div class="col-lg-12">
				
 <!--Carousel Wrapper-->
    <div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel">
      <!--Indicators-->
      <ol class="carousel-indicators">
        <li data-target="#carousel-example-2" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-2" data-slide-to="1"></li>
        <li data-target="#carousel-example-2" data-slide-to="2"></li>
      </ol>
      <!--/.Indicators-->
      <!--Slides-->
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
          <div class="view">
            <img class="d-block w-100" height="auto" src="images/slider/8-3.jpg" alt="First slide">
            <div class="mask rgba-black-light"></div>
          </div>
          <div class="carousel-caption">
             <!--<h3 class="h3-responsive">Light mask</h3>
            <p>First text</p>-->
          </div>
        </div>
        <div class="carousel-item">
          <!--Mask color-->
          <div class="view">
            <img class="d-block w-100" height="auto" src="images/slider/2-4.jpg" alt="Second slide">
            <div class="mask rgba-black-strong"></div>
          </div>
          <div class="carousel-caption">
             <!--<h3 class="h3-responsive">Strong mask</h3>
            <p>Secondary text</p>-->
          </div>
        </div>
        <div class="carousel-item">
          <!--Mask color-->
          <div class="view">
            <img class="d-block w-100" height="auto" src="images/slider/4.jpg" alt="Third slide">
            <div class="mask rgba-black-slight"></div>
          </div>
          <div class="carousel-caption">
             <!--<h3 class="h3-responsive">Slight mask</h3>
            <p>Third text</p>-->
          </div>
        </div>
      </div>
      <!--/.Slides-->
      <!--Controls-->
      <a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
      <!--/.Controls-->
    </div>
    <!--/.Carousel Wrapper-->				
				
				
			
			</div>
		</div>
	</div> 
</section> 

<section id="contact" class="mt-5"> 
<div class="container-fluid">
				<div class="row">
				<div class="col-lg-12 mb-4">
				
				
					<div class="card h-100">
						<div class="card-header">
								<h3 class="title">Contact us</h3>

						</div>
					</div>					
					
				</div>
</div>
  </div>
  <!-- Scroll Demo Text -->
</section> 
 
</body>
</html>