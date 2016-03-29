<?php

require_once 'core/init.php';

$user=new User();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
$username=$user->data()->Username;


?>

<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chat Room</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" charset="utf-8">
    <link rel="stylesheet" href="bootstrap/css/advanced/advanced.css" charset="utf-8">
    <link rel="stylesheet" href="bootstrap/css/style.css" charset="utf-8">
    <link rel="stylesheet" href="bootstrap/css/advanced/knust-filla.min.css">
    <script src="js/jquery-2.2.2.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">

    <nav class="navbar navbar-dark  bg-success navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mynav">
                    <span class="icon-bar text-black text-bold">__</span>
                    <span class="icon-bar text-black text-bold">__</span>
                    <span class="icon-bar text-black text-bold">__</span>
                </button>
                <a href="chat.php" class="navbar-brand">Knust Filla</a>
            </div>
            <div class="collapse navbar-collapse" id="mynav">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user">Welcome <?php echo $username?></span></span></a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out">Logout</span></a></li>
                    <input type="hidden" id="myname" value="<?php echo $username?>"/>
                </ul>
            </div>
        </div>
    </nav><br><br><br>
    <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <marquee>
            <button type="button" class="btn btn-lg btn-danger"> Knust filla - wo b3 kasaa br3</button>
          </marquee>
        </div>
        <div class="col-md-3">
          <p class="text-default bg-success" id="connected_count">

          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 col-md-offset-1">
          <div class="box box-success direct-chat direct-chat-success">
              <div class="box-header with-border">
                  <h3 class="box-title">Chat Room</h3>
                  <h4 class="pull-right text-muted" id="state"> </h4>
                  <p id="conn"></p>

              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <!-- Conversations are loaded here -->
                  <div class="direct-chat-messages" id="chatWindow">
                      <!-- Message. Default to the left -->

                  </div>
                  <!--/.direct-chat-messages-->
                  <div class="box-footer">

                          <div class="input-group">
                              <textarea type="text" cols="80" rows="3" id="message" name="message" placeholder="Type Message ..."
                        autofocus="autofocus" class="form-control"></textarea>
                          </div>
                      
                  </div>
                  <!--chat footer-->

              </div>
          </div>

        </div>
        <div class="col-md-5">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <p class="text-black">JOINED USERS <span id="total"></span></p>
                </div>
                <div class="panel-body">
                    <div id="users" style="max-height: 400px">

                    </div>
                </div>
            </div>

        </div>
      </div>


    </div>

    <script type="text/javascript" language="JavaScript">
        loaddata();
        setInterval(function(){
            loaddata();
        },5000);
        function loaddata(){

                $.ajax({
                    url: 'displayUsers.php',
                    data: "",
                    success : function(response){
                        $('#users').html(response);
                    }
                });

        }
    </script>
    <script type="text/javascript" language="JavaScript">
        setInterval(function(){
            loadnumber();
        },100);
        function loadnumber(){
            $.ajax({
                url: 'counter.php',
                data: "",
                dataType:'json',
                success : function(response1){
                    //var v1=JSON.parse(response1);
                    var v2=response1['total'];
                    $('#total').html('<b>[ ' + v2+ '] </b>');
                }
            });
        }
    </script>
    <script type="text/javascript" src="js/chat.js"></script>

  </body>
</html>
