<?php
//  echo "</br>";
//  var_dump($model->username);
//  die;
// 
?>
<div class="register login">
    <h1>Sign up</h1>
    <form action="" method="post">
        <div class="form-group mb-1">
            <input type="text" class="form-control <?php echo ($model->hasError('username')) ? ' is-invalid' : '' ?>"
             name="username" value="<?php echo $model->username ?>" placeholder="Username" />
            <div class="invalid-feedback"><?php echo $model->getFirstError('username') ?></div>
        </div>
        <div class="form-group mb-1">
            <input type="email" class="form-control <?php echo ($model->hasError('email')) ? ' is-invalid' : '' ?>" name="email" value="<?php echo $model->email ?>" placeholder="Email" />
            <div class="invalid-feedback"><?php echo $model->getFirstError('email') ?></div>
        </div>
        <div class="form-group mb-1">
            <input type="password" class="form-control <?php echo ($model->hasError('password')) ? ' is-invalid' : '' ?>" name="password" value="<?php echo $model->password ?>" placeholder="Password" />
            <div class="invalid-feedback"><?php echo $model->getFirstError('password') ?></div>
        </div>

        <div class="form-group  mb-1">
            <input type="password" class="form-control <?php echo ($model->hasError('confirmPassword')) ? ' is-invalid' : '' ?>" name="confirmPassword" placeholder="Password Confirmation" required="required" />
            <div class="invalid-feedback"><?php echo $model->getFirstError('confirmPassword') ?></div>
        </div>
        <!-- <input type="email" class="form-control" name="email" placeholder="email" required="required" /> -->  
        <button type="submit" class="btn btn-primary btn-block btn-large">Let me in.</button>
    </form>
</div>