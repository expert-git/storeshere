<?php

    $image_data = file_get_contents($_REQUEST['imgData']);

    file_put_contents("photo.jpg",$image_data);

?>