<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Login</title>
<script src='https://www.google.com/recaptcha/api.js'></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
<div class="container">

<?php echo form_open(base_url().'login'); ?>


  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted"><?php echo form_error('email', '<div class="error">', '</div>'); ?></small>
  </div>

  <div class="form-group">
    <label for="exampleInputPass1">Password</label>
    <input type="password" class="form-control" id="exampleInputPass1" aria-describedby="passHelp">
    <small id="passHelp" class="form-text text-muted"><?php echo form_error('password', '<div class="error">', '</div>'); ?></small>
  </div>

  <div class="form-group">
  <?=$recaptcha?>
  </div>
  <div><input type="submit" value="Submit" class="btn btn-primary"/></div>
    </form>

<br>
<p>
<a href="<?php echo base_url().'register/forget_pass'; ?>">forgot</a>
</p>
<p>
<a href="<?php echo base_url().'register/ednr'; ?>">resend</a>
</p>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>