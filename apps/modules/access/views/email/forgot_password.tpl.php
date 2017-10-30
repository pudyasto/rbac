<html>
<body>
    <p>Click link below to reset your password</p>
    <p>
        <?php echo anchor('access/reset?token='.$forgotten_password_code, 'Reset Password Here');?>
    </p>
    <p>Or copy this url to your address bar</p>
    <p><?=anchor('access/reset?token='.$forgotten_password_code);?></p>
    <p> <strong>Link expired for 1 Hour</strong> </p>
    <hr>
    <p> Any problem's, contact your administrator </p>
    <hr>
    <p><?php echo $this->apps->companyname;?></p>
    <p><?php echo $this->apps->companyaddr;?></p>
    <p><?php echo $this->apps->companyinfo;?></p>
    <br><br><br><br>
    <p> Terima Kasih </p>
</body>
</html>