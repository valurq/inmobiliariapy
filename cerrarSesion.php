<?php
    session_unset();
    session_destroy();
    session_write_close();
    echo "<script>window.location='loginTest.php'</script>";

?>
