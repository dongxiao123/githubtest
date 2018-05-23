<?php
session_start();
session_unset();
session_destroy();
echo "<script type='text/javascript'>window.open('./','_top');</script>";
exit;

?>