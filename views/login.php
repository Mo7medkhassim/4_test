<?php
//  echo "</br>";
//  var_dump($model['email']);
//  die;
// 
?>







<style>
    <?php

    include "../public/site/style.css";
    ?>
</style>


<div class="login">
    <h1>Login</h1>
    <form method="post" action="">
        <div class="form-group mb-1">
            <input type="text" name="email" class="form-control
               <?php echo ($model->hasError('email')) ? 'is-invalid' : '' ?>" value="" placeholder="Email" required="required" />
            <div class="invalid-feedback"><?php echo $model->getFirstError('email') ?></div>
        </div>
        <div class="form-group mb-1">
            <input type="password" class="form-control 
              <?php echo ($model->hasError('password')) ? 'is-invalid' : '' ?>
              " name="password" placeholder="Password" required="required" />
            <div class="invalid-feedback"><?php echo $model->getFirstError('password') ?></div>
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-large">Login</button>
    </form>
</div>