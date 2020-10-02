<?php require APP_ROOT.'/views/includes/Header.php'; ?>
<?php require APP_ROOT.'/views/includes/Navigation.php'; ?>

<div class="container">
    <h1>Sign up Page</h1>
    <form action="<?php echo URL_ROOT; ?>/login/registration" method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="email" placeholder="Email address">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="passwordRepeat" placeholder="Password confirm">

        <button id="submit" type="submit" value="submit">SIGN UP</button>
    </form>
</div>

<?php require APP_ROOT.'/views/includes/Footer.php'; ?>