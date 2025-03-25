<?php 
    require_once __DIR__ . '/include/config.inc.php';
    $title = "Page Tech - MétéoSmart";
    $css_file = ($style === 'alternatif') ? 'style_alternatif.css' : 'style.css';
    require_once __DIR__ . '/include/functions.inc.php';
    require __DIR__ . '/include/header.inc.php';
?>

<body>
    <main>
        <h1>🔬 Page Technique</h1>

        <section>
            <h2>🛰️ Image du Jour - NASA APOD</h2>
            <?= display_nasa_apod(); ?>
        </section>

        <section>
            <h2>📍 Localisation de l'utilisateur (via ipinfo.io)</h2>
            <?= ip_location_json(); ?>
        </section>

        <section>
            <h2>🌍 Localisation via GeoPlugin</h2>
            <?= ip_location_geoplugin_json(); ?>
        </section>
        <section>
            <h2>🌄 Image météo aléatoire</h2>
            <?= display_random_weather_image(); ?>
        </section>
    </main>
</body>

<?php 
    require __DIR__ . '/include/footer.inc.php';
?>
