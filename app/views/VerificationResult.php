<?php require APP_ROOT.'/views/includes/Header.php'; ?>
<?php require APP_ROOT.'/views/includes/Navigation.php'; ?>

<?php

if(isset($data['confirmError'])) {
    ?>
        <p>Unsuccessful Verification!</p>
    <?php
} else {
    ?>
        <p>Successful verification</p>
    <?php
}

?>


<?php require APP_ROOT.'/views/includes/Footer.php'; ?>