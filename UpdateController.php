<?php
// Backwards-compatible shim: include the controller from `app/controllers`
// so forms posting to /logincontroller.php continue to work after refactor.
include __DIR__ . '/app/controllers/UpdateController.php';
?>