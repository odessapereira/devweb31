<?php
// Gestion du style (par défaut : standard)
$style = isset($_GET['style']) && in_array($_GET['style'], ['standard', 'alternatif']) ? $_GET['style'] : 'standard';
?>