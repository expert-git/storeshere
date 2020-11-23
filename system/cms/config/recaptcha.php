<html>
<head>
    <title>reCAPTCHA Example</title>
</head>
<body>
<form action="/a/test" method="post">
<?php echo $widget;?>
<?php echo $script;?>
<?php
$config['recaptcha_site_key'] = '6LdX41UUAAAAAF3Sz_ZPslF3iJ86u9TEkZ46u_Q9';
$config['recaptcha_secret_key'] = '6LdX41UUAAAAAPI4zOhivXXomUgbV3TWHwnkA9N1';
?>
<br />
<input type="submit" value="submit" />
</form>
</body>
</html>