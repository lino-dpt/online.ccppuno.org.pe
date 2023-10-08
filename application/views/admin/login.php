<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CCP PUNO ONLINE</title>
  <link rel="icon" href="<?php echo base_url();?>resources/img/logo.png" type="image/png" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="resources/css/bootstrap/css/bootstrap.css">

  <style type="text/css">
   
    .enlace:hover {
      font-weight: bold;
      cursor:pointer;
    }

    .enlace:hover img {
      -webkit-transform: scale(1.3);
      transform: scale(1.3);
    }

  </style>
  
</head>

<body>
  <div class="container-fluid">
    <div class="container" align="center">
      <div class="login-box">
        <br>
        <!-- /.login-logo -->
        <div class="login-box-body">
          <form action="<?php echo base_url();?>auth/login" method="post" class="form-signin">
            <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="250" height="250">
            <br><br>
            <div class="row" align="center">
              <div class="col-md-12">
                <span class="enlace" onclick="window.location.href = 'https://ccppuno.org.pe/'"><img src="<?php echo base_url();?>resources/img/regresar.png" width="30" height="30">&nbsp;&nbsp;&nbsp;Ir al portal web www.ccppuno.org.pe</span>
              </div>
            </div>
            <br>
            <div class="row">                
              <div class="col-md-4">
              </div>
              <div class="col-md-4">
                <?php if($this->session->flashdata("error")):?>
                  <div class="alert alert-danger">
                    <p><?php echo $this->session->flashdata("error");?></p>
                  </div> 
                <?php endif ?>
              </div>
              <div class="col-md-4"></div>
            </div>  
            <div class="row">                
              <div class="col-md-4"></div>
              <div class="col-md-4 border border-primary" style="padding: 40px;">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Nº Colegiatura" name="username" autofocus>
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" placeholder="Password" name="password">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
               </div>
              <div class="col-md-4"></div>
          </form>

        </div>
        <!-- /.login-box-body -->
      </div>
      <!-- /.login-box -->
    </div>

  </div>
    

    <br><br><br><br>

    <div style="background: #fff; padding: 30px;">
      <div class="container">
        <img src="<?php echo base_url();?>resources/img/logo.png" alt="" width="110" height="110">
        
        <hr style="border-top: 1px solid #ccc;">
        <small style="color: #24387c;">© Colegio de Contadores Públicos de Puno</small>
      </div>
    </div>

  <script src="resources/js/jquery.js"></script>
  <script src="resources/css/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
