<?php
    require '../util/utilities.php';

    // Get available restaurants from db
    $stmt = "SELECT * FROM restaurant WHERE user = ?";
    Database::run_statement($stmt, [$user]);
?>