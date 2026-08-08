<?php
// Backwards-compatible root shim: include the login view in `app/views/home`.
// This lets existing links to /login.php continue to work after moving the view file.
include __DIR__ . '/app/views/home/login.php';
?>
