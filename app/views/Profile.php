<?php require APP_ROOT.'/views/includes/Header.php'; ?>
<?php require APP_ROOT.'/views/includes/Navigation.php'; ?>

<div class="container">
    <h1>Profile Page</h1>
    <script>
        $(document).ready(function() {
            console.log('sas');

$.ajax({
    type: 'GET',
    url: 'index.php?url=api/image/index',
    dataType: 'json',
    success: function(data) {
        console.log(data);
    },
    error: function(e) {
        console.log(e);
    }
});
});
    </script>
</div>

<?php require APP_ROOT.'/views/includes/Footer.php'; ?>