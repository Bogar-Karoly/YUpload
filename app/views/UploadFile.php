<?php require APP_ROOT.'/views/includes/Header.php'; ?>
<?php require APP_ROOT.'/views/includes/Navigation.php'; ?>

<?php if(!empty($data)) {
    print_r($data);    
}
    ?>

<div class="container">
    <h1>Sign up Page</h1>
    <form action="<?php echo URL_ROOT; ?>/upload/uploadFile" method="POST" enctype="multipart/form-data">
        <input type="file" accept=".jpg, .jpeg, .png, .gif" name="imagefile" placeholder="">
        <input type="text"  name="name" placeholder="Image name...">
        <input type="text"  name="tags" placeholder="tags...">
        <input type="text"  name="visibility" placeholder="visibility...">

        <button id="submit" type="submit" value="submit">Send</button>
    </form>
</div>

<?php require APP_ROOT.'/views/includes/Footer.php'; ?>