<html>
<body>
    <p>Hi, Your password has been changed.</p>
    <p>Please use this password for login to application .</p>
    <p>
        User Name : <?php echo $identity;?>
    </p>
    <p>
        Password : <?php echo $new_password;?>
    </p>    
    
    <p>
        Or click this button for Instant Access
    </p>
    <form  method="post" role="form" action="<?=site_url('access/login');?>">
        <input type="hidden" name="username" id="username" value="<?php echo $identity;?>">
        <input type="hidden" name="password" id="password" value="<?php echo $new_password;?>">
        <button style="width: 100px;height: 45px;
                            background-color: #1ab394;
                            border-color: #1ab394;
                            color: #fff;border: 1px solid transparent;" type="submit">
            <strong>Log in</strong>
        </button>
    </form>
    <p> Any problem's, contact your administrator </p>
    <hr>
    <p><?php echo $this->apps->companyname;?></p>
    <p><?php echo $this->apps->companyaddr;?></p>
    <p><?php echo $this->apps->companyinfo;?></p>
    <br><br><br><br>
</body>
</html>