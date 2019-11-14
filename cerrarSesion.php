<?php
    session_start();
    session_unset();
    session_write_close();
    session_destroy();
    echo "<script>window.location='loginTest.php'</script>";

?>
