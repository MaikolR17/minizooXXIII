<?php
    function setError(string $msg, string $location) {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = $msg;
        header("Location: ".$location);
        exit;
    }

    function setSuccess(string $msg, string $location) {
        $_SESSION['status'] = "success";
        $_SESSION['message'] = $msg;
        header("Location: ".$location);
        exit;
    }
?>