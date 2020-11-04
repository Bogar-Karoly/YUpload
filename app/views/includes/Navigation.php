<nav>
    <ul>
        <li class="icon">
            <a href="<?php echo URL_ROOT; ?>/home">CLOUD</a>
        </li>
        <?php if(isset($_SESSION['userId'])) { ?>
            <li class="test">
                <div class="btn-container">
                    <div class="title">
                        <a href="<?php echo URL_ROOT; ?>/login/logout"><i class="far fa-times-circle fa-1x"></i></a>
                    </div>
                    <div class="detail">
                        PROFILE
                    </div>
                </div>
                <div class="btn-container">
                    <div class="title">
                        <a href="<?php echo URL_ROOT; ?>/home/profile"><i class="fas fa-user-circle fa-1x"></i></a>
                    </div>
                    <div class="detail">
                        PROFILE
                    </div>
                </div>
                <div class="btn-container">
                    <div class="title">
                        <a href="<?php echo URL_ROOT; ?>/upload/uploadFile"><i class="fas fa-file-upload fa-1x"></i></a>
                    </div>
                    <div class="detail">
                        PROFILE
                    </div>
                </div>
            </li>
        <?php } else { ?>
            <li>
                <a href="<?php echo URL_ROOT; ?>/login/registration">SIGN UP</a>
            </li>
            <li>
                <a href="<?php echo URL_ROOT; ?>/login/login">SIGN IN</a>
            </li>
        <?php } ?>
    </ul>
</nav>