<?php 
    require_once __DIR__ . '/include/config.inc.php';
    $title = "Page Tech - MétéoSmart";
    $css_file = ($style === 'alternatif') ? 'style_alternatif.css' : 'style.css';
    require_once __DIR__ . '/include/functions.inc.php';
    require __DIR__ . '/include/header.inc.php';
?>

<body>
    <main>
        <h1> Page Tech</h1>

        <section>
            <h2> Image du Jour - NASA APOD</h2>
            <?= display_nasa_apod(); ?>
        </section>

        <section>
            <h2> Localisation de l'utilisateur (via ipinfo.io)</h2>
            <?php echo ip_location_json(); ?>
        </section>

        <section>
            <h2> Localisation via GeoPlugin</h2>
            <?php echo ip_location_xml(); ?>
        </section>
    
        <h1> Sélectionnez votre ville pour voir la météo</h1>
        <h3>Carte de la France</h3>
        <img src="images/france.png" alt="Carte de la France" width="600" height="auto">

  
        <label for="departement">Choisissez un département :</label>
        <select id="departement" onchange="loadCities()">
            <option value="">-- Sélectionnez un département --</option>
            <option value="75">Paris</option>
            <option value="77">Seine-et-Marne</option>
            <option value="78">Yvelines</option>
            <option value="91">Essonne</option>
            <option value="92">Hauts-de-Seine</option>
            <option value="93">Seine-Saint-Denis</option>
            <option value="94">Val-de-Marne</option>
            <option value="95">Val-d'Oise</option>
        </select>

        <!-- Sélectionner une ville -->
        <label for="ville">Choisissez une ville :</label>
        <select id="ville">
            <option value="">-- Sélectionnez une ville --</option>
        </select>

        <button onclick="fetchWeather()">Voir la météo</button>

        <!-- Affichage des résultats météo -->
        <div id="meteo"><?php echo $weatherOutput; ?></div>

        <script>
            // Liste des villes par département
            const villesParDepartement = {
                "75": ["Paris"],
                "77": ["Melun", "Meaux", "Fontainebleau"],
                "78": ["Versailles", "Rambouillet", "Mantes-la-Jolie"],
                "91": ["Évry", "Corbeil-Essonnes", "Massy"],
                "92": ["Nanterre", "Boulogne-Billancourt", "Courbevoie"],
                "93": ["Saint-Denis", "Montreuil", "Aubervilliers"],
                "94": ["Créteil", "Vitry-sur-Seine", "Ivry-sur-Seine"],
                "95": ["Pontoise", "Argenteuil", "Cergy"]
            };

            // Fonction pour charger les villes selon le département sélectionné
            function loadCities() {
                const departement = document.getElementById('departement').value;
                const villeSelect = document.getElementById('ville');

                villeSelect.innerHTML = "<option value=''>-- Sélectionnez une ville --</option>";

                if (villesParDepartement[departement]) {
                    villesParDepartement[departement].forEach(function(ville) {
                        villeSelect.innerHTML += `<option value="${ville}">${ville}</option>`;
                    });
                }
            }

            // Fonction pour récupérer la météo via la ville sélectionnée
            function fetchWeather() {
                const ville = document.getElementById('ville').value;
                if (ville === "") {
                    alert("Veuillez sélectionner une ville !");
                    return;
                }

                // Créer l'URL avec la ville sélectionnée
                const url = window.location.pathname + "?ville=" + encodeURIComponent(ville);

                // Effectuer la requête pour afficher la météo
                window.location.href = url;
            }
        </script>

    </main>
</body>

<?php 
    require __DIR__ . '/include/footer.inc.php';
?>
