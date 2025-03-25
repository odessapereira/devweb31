<?php 
    require_once __DIR__ . '/include/config.inc.php';
    $title = "Accueil MétéoSmart";
    $css_file = ($style === 'alternatif') ? 'style_alternatif.css' : 'style.css';
    require __DIR__ . '/include/header.inc.php';
?>

<body>
    <main>
        <h1>🌤️ Découvrez la météo du jour !</h1>
        <p>Bienvenue sur MétéoSmart, votre site météo intelligent.</p>
    </main>
</body>

<?php 
    require __DIR__ . '/include/footer.inc.php';
?>