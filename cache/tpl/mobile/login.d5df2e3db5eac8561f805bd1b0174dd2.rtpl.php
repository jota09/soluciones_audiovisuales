<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
<html>
   <head>
      <title><?php echo $title;?></title> 
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link type="text/css" href="base/librerias/css/bootstrap/bootstrap.min.css" rel="stylesheet">
      <link type="text/css" href="base/librerias/css/font-awesome/font-awesome.min.css" rel="stylesheet">
      <link type="text/css" href="assets/css/general/login.css" rel="stylesheet">
      <link type="image/png" href="assets/img/general/shorcut.png" rel="shortcut icon"/>
      <script type="text/javascript" src="base/librerias/js/jquery/jquery.min.js"></script>
      <script type="text/javascript" src="base/librerias/js/bootstrap/bootstrap.min.js"></script>
   </head>        
</head>
<body>
   <div class="container">

      <div class="col-sm-4 no-padding" >

      </div>
      <div class="col-sm-4">
         <div id="login">
            <form class="form-horizontal" role="form" action="index.php" method="post">
               <input type="hidden" name="modulo" id="modulo" value="usuarios">
               <input type="hidden" name="accion" id="accion" value="autenticar">
               <div class="col-sm-12 " id="logo">
                  <img src="assets/img/general/logo.png">
               </div>
               <div class="col-sm-12 " id="formulario">
                  <div class="col-sm-12  no-padding" >
                     <h4 class="text-bold"><?php echo $L_APP["lbl_bienvenidos_login"];?></h4>
                     <h3 class="text-bold"><?php echo $L_APP["lbl_nice"];?></h3>
                  </div>
                  <div class="col-sm-12 " >
                     <div class="form-group">                                
                        <input type="text" class="form-control" name="login_usuario" placeholder="<?php echo $L_MOD["phl_nombre_usuario"];?>" autocomplete="off">                                
                     </div>
                     <div class="form-group">
                        <input type="password" class="form-control" name="login_contrasenia" placeholder="<?php echo $L_MOD["phl_contrasenia"];?>" autocomplete="off">                                
                     </div>
                     <div class="form-group text-right" id="div-btn-login-acceder">
                        <button type="submit" class="btn  btn-primary" id="btn_ingresar"><?php echo $L_MOD["lbl_btn_ingresar"];?></button>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12 text-center" >
                  <?php echo $L_APP["lbl_producto"];?>
               </div>
         </div>
         </form>
      </div>
      <div class="col-sm-4 no-padding" >

      </div>
   </div>

</div>
</body>
</html>