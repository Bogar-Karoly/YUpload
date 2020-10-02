<nav>
    <ul>
        <li>
            <a href="<?php echo URL_ROOT; ?>/home">HOME</a>
        </li>
        <li>
            <a href="<?php echo URL_ROOT; ?>/registration">More</a>
        </li>
        <li>
            <a href="<?php echo URL_ROOT; ?>/registration">More</a>
        </li>
        <?php if(isset($_SESSION['userId'])) { ?>
            <li class="btn-right">
                <a href="<?php echo URL_ROOT; ?>/upload"><i class="fas fa-file-upload fa-1x">Upload</i></a>
                <a href="<?php echo URL_ROOT; ?>/profile"><i class="fas fa-user-circle fa-1x"><?php echo $_SESSION['username']; ?></i></a>
                <a href="<?php echo URL_ROOT; ?>/login/logout"><i class="far fa-times-circle fa-1x"></i></a>
            </li>
        <?php } else { ?>
            <li class="btn-right">
                <a href="<?php echo URL_ROOT; ?>/login/registration">SIGN UP</a>
            </li>
            <li class="btn-right">
                <form action="<?php echo URL_ROOT; ?>/login/login" method="POST">
                    <input type="text" name="email" placeholder="Email" oninvalid="this.setCustomValidity('<?php echo $data['email']; ?>')" oninput="setCustomValidity('')" required="">
                    <input type="password" name="password" placeholder="Password">
                    <button id="submit" type="submit" value="submit">SIGN IN</button>
                </form>
            </li>
        <?php } ?>
    </ul>
</nav>