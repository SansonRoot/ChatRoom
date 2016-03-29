
<?php
require_once 'core/init.php';
$user = new User();
$check=DB::getInstance()->get('visitors',array('ipaddress','=',Input::getIp()));
if(!$check->count()){
    $user->create('visitors',array('ipaddress'=>Input::getIp()));
}
if($user->isLoggedIn()){
    Redirect::to('chat.php');
}


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Knust Philla Real Time Chart</title>
      <link rel="stylesheet" href="bootstrap/css/bootstrap.css" charset="utf-8">
      <link rel="stylesheet" href="bootstrap/css/advanced/advanced.css" charset="utf-8">
      <link rel="stylesheet" href="bootstrap/css/style.css" charset="utf-8">
      <link rel="stylesheet" href="bootstrap/css/advanced/knust-filla.min.css">
  </head>
  <body>
    <div class="container">

      <header class="nav">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 col-lg-offset-4 col-sm-offset-3 col-xs-offset-2">
            <a href="index.php" class="btn-lg btn-success">WELCOME TO KNUST FILLA CHATROOM</a>
          </div>
        </div>
      </header>
      <div class="clearfix">
      </div><br>
        <!--End of navbar-->

      <div class="well">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                  <p class="text-muted col-sm-6 col-sm-offset-3">
                    <h3><strong>LOGIN TO THE CHATROOM</strong></h3>
                    </ p>
                </div>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" action="index.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="username" class="control-label col-md-3">Username :</label>
                      <div class="col-md-6">
                        <input type="text" name="username" value="<?php echo Input::get('username')?>" autofocus="autofocus" id="username"  placeholder="Username" class="form-control">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="password" class="control-label col-md-3">Password :</label>
                      <div class="col-md-6">
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                      </div>
                    </div>

                    <input type="submit" class="btn btn-lg btn-block btn-success" value="Login">
                      <p class="text-muted text-center"> <h4><strong>Not a member yet..?</strong></h4></ p>
                    <a href="register.php" class="btn btn-lg btn-block btn-danger">Register to Join</a>
                    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                  </ form>

                </div>
                <div class="panel-footer">
                    <?php
                    if(Input::exists()){
                        $validate = new Validate();
                        $validation = $validate->check($_POST, array(
                            'username' => array('required' => true),
                            'password' => array('required' => true)
                        ));

                        if ($validation->passed()) {
                            $table = 'users';
                            if ($user->login(Input::get('username'), Input::get('password'), $table)) {
                                Redirect::to('chat.php');
                            } else { ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button class="close" data-dismiss="alert" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                                <h4>Login Failed</h4>
                                Incorrect Username or Password
                            </div>
                             <?php
                            }

                        } else { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button class="close" data-dismiss="alert" data-toggle="dismiss" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                            <h4>Login Failed</h4> <?php
                                foreach ($validation->errors() as $error) {
                                    echo $error . '<br/>';
                            }
                        echo '</div>';
                        }

                    }
                    ?>
                </div>
            </div>

          </div>

        </div>

      </ div>

    </ div>

  </ body>
</ html>
