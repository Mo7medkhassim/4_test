<?php
// session_start();

if (!array_key_exists('csrf-token', $_SESSION)) {

    $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
}

?>

<div class="col-md-6 p-2 m-3">

    <form action="/contact" method="post">

        <div class="form-group p-2">
            <label for="forSubject">Subject</label>
            <input type="text" name="subject" value="<?= htmlentities($_POST['subject'] ?? ''); ?>" class="form-control 
            <?php echo ($model->hasError('subject')) ? ' is-invalid' : '' ?>
            " id="subject" aria-describedby="emailHelp" placeholder="Enter Subject">
            <div class="invalid-feedback"><?php echo $model->getFirstError('subject') ?></div>

        </div>
        <div class="form-group p-2">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" value="<?= htmlentities($_POST['email'] ?? ''); ?>" class="form-control 
            <?php echo ($model->hasError('email')) ? ' is-invalid' : '' ?>" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email">
            <div class="invalid-feedback"><?php echo $model->getFirstError('email') ?></div>
        </div>
        <div class="form-group p-2">
            <label for="exampleInputPassword1">Message</label>
            <textarea type="text" name="message" class="form-control <?php echo ($model->hasError('message')) ? ' is-invalid' : '' ?>" placeholder="Enter Message"><?= htmlentities($_POST['message'] ?? ''); ?></textarea>
            <div class="invalid-feedback"><?php echo $model->getFirstError('message') ?></div>
        </div>

        <input type="text" hidden name="csrf-token" value="<?php echo $_SESSION['csrf-token'] ?>">



        <button type="submit" class="btn btn-primary m-2">Submit</button>
    </form>


</div>