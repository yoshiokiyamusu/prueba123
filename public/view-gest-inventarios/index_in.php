<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>  <!--si no esta logeado redirect a login.php-->
<?php $page_title = 'INDICE'; ?>
<?php include('../front_end/header.php'); ?>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" /> -->
<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!--  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">-->


<style>
section {
    padding-top: 4rem;
    padding-bottom: 5rem;
    background-color: #f1f4fa;
}
.wrap {
    display: flex;
    background: white;
    padding: 1rem 1rem 1rem 1rem;
    border-radius: 0.5rem;
    box-shadow: 7px 7px 30px -5px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.wrap:hover {
    background: linear-gradient(135deg,#6394ff 0%,#0a193b 100%);
    color: white;
}

.ico-wrap {
    margin: auto;
}

.mbr-iconfont {
    font-size: 4.5rem !important;
    color: #313131;
    margin: 1rem;
    padding-right: 1rem;
}
.vcenter {
    margin: auto;
}

.mbr-section-title3 {
    text-align: left;
}
h2 {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
}
.display-5 {
    font-family: 'Source Sans Pro',sans-serif;
    font-size: 1.4rem;
}
.mbr-bold {
    font-weight: 700;
}

 p {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    line-height: 25px;
}
.display-6 {
    font-family: 'Source Sans Pro',sans-serif;
}
.botongrande a {
    text-decoration: none;
}
</style>



<div class="container">
  <?php include('../front_end/navbar_index.html'); ?>
<section>


      <div class="container text-center">
        <h2>5.1 Ingreso - inventario</h2>
        <h4>Sistema de gestión operativa</h4>
      </div>



      <div class="row mbr-justify-content-center col-xs-12">


              <a class="botongrande col-lg-6 mbr-col-md-10" target="_blank" href="<?php echo url_for('view-receiving/ordenes.php'); ?>" >
                <div class="wrap">
                    <div class="ico-wrap">
                        <span class="mbr-iconfont fa-box-open fa"></span>
                    </div>
                    <div class="text-wrap vcenter">
                        <h2 class="mbr-fonts-style mbr-bold mbr-section-title3 display-5"><span>5.1.1. Recepción inventario - Producto terminado</span></h2>
                        <p class="mbr-fonts-style text1 mbr-text display-6">Recibir, revisar calidad y almacenar </p>

                    </div>
                </div>
            </a>

              <a class="botongrande col-lg-6 mbr-col-md-10" target="_blank" href="<?php echo url_for('view-gest-inventarios/view-retorno/retorno.php'); ?>" >
                <div class="wrap">
                    <div class="ico-wrap">
                        <span class="mbr-iconfont fas fa-tshirt"></span>
                    </div>

                    <div class="text-wrap vcenter">
                        <h2 class="mbr-fonts-style mbr-bold mbr-section-title3 display-5"><span>5.1.2. Retorno inventario</span></h2>
                        <p class="mbr-fonts-style text1 mbr-text display-6"> Rollo de telas</p>
                    </div>
                </div>
              </a>

              <a class="botongrande col-lg-6 mbr-col-md-10" target="_blank" href="<?php echo url_for('view-gest-inventarios/view-noconforme/noconformept.php'); ?>" >
                <div class="wrap">
                    <div class="ico-wrap">
                        <span class="mbr-iconfont fas fa-bug"></span>
                    </div>

                    <div class="text-wrap vcenter">
                        <h2 class="mbr-fonts-style mbr-bold mbr-section-title3 display-5"><span>5.1.3. Inventario no conforme - Producto terminado</span></h2>
                        <p class="mbr-fonts-style text1 mbr-text display-6"> Almacenar, desechar, devolver</p>
                    </div>
                </div>
              </a>

          </div>




</section>
</div><!-- container -->


<!-- container -->



<?php include('../front_end/footer.php'); ?>
&nbsp;
