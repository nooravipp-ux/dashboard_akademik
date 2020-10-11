<?php
session_start();
session_unset();
session_destroy();
header("Location: /sistemik_dashboard_mobile");
?>