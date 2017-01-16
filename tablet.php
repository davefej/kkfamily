<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KK Family</title>

    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
  </head>
  <body>
    <!--NAVBAR, MENU-->
    <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">KK Family</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Áruhozzáadás <span class="sr-only">(current)</span></a></li>
        <li><a href="release.html">Árukiadás</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Egyéb<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Raktárkészlet</a></li>
            <li><a href="#">Lejáró Termékek</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Raktár statisztikák</a></li>
          </ul>
        </li>
      </ul>
        
      <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Keresés">
            </div>
        </form>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    
    <!--MOBILBARÁT CONTAINER :)-->
    <div class="container-fluid" align="center">
        <p class="lead"><b>Ez a KK Family projekt próbaoldala.</b><br> A stíluslapokhoz készítettük!</p>
    </div>
    
    <!--MOBILBARÁT CONTAINER, KÉPEK EGY SORBAN-->
    <div class="container-fluid" align="center" style="width:75%">
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="img/cabbage.svg" alt="..."  height="200pt" width="200pt">
            </a>
        </div>
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="img/carrot.svg" alt="..."  height="200pt" width="200pt">
            </a>
        </div>
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="img/onion.png" alt="..."  height="200pt" width="200pt">
            </a>
        </div>
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
                <img src="img/lettuce.png" alt="..." height="200pt" width="200pt">
            </a>
        </div>
      </div>

      <!--Progress Bars-->
    <div class="progress center-block" style="width: 70%">
      <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
        Raktár: 50%
      </div>
</div>
    <div class="progress center-block" style="width: 70%">
      <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="83" aria-valuemin="0" aria-valuemax="100" style="width: 83%;">
        Saláta: 83%
      </div>
    </div>
    
    <footer class="footer navbar-fixed-bottom">
      <div class="container text-center">
        <p style="font-color: #ffffff">design by <b>David Szanto</b> | Bootstrap 3</p>
      </div>
</footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/bootstrap-3.3.7-dist/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>