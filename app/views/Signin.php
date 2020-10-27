<?php require APP_ROOT.'/views/includes/Header.php'; ?>
<?php require APP_ROOT.'/views/includes/Navigation.php'; ?>

<div class="container">
    <h1>Sign up Page</h1>
    <?php
    if(isset($data)) {
        if(!empty($data)) {
            print_r($data);
        }
    }
    ?>
    <form action="<?php echo URL_ROOT; ?>/login/login" method="POST">
        <input type="text" name="email" placeholder="Email address">
        <input type="password" name="password" placeholder="Password">

        <button id="submit" type="submit" value="submit">SIGN IN</button>
    </form>
    <p>Forgot your password? <a href="<?php echo URL_ROOT; ?>/login/passwordRecovery">Password</a></p>
</div>

<?php require APP_ROOT.'/views/includes/Footer.php'; ?>