<?php require APP_ROOT.'/views/includes/Header.php'; ?>
<?php require APP_ROOT.'/views/includes/Navigation.php'; ?>

<?php print_r($data); ?>
<div class="container">
    <form action="<?php echo URL_ROOT; ?>/login/passwordRecovery" method="POST">
        <input type="text" name="email" placeholder="Your email...">

        <button id="submit" type="submit" value="submit">SIGN UP</button>
    </form>
</div>


<?php require APP_ROOT.'/views/includes/Footer.php'; ?>