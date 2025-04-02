<?php
/**
 * Fonction qui récupère et affiche l'image du jour de la NASA APOD
 * @param string|null $date Format YYYY-MM-DD, si null prend la date du jour
 * @return string HTML affichant l'image ou la vidéo du jour
 */
function display_nasa_apod(string $date = null): string
{
    $api_key = "vlrYEWk4n1dQgXC9Hb9y1YVnPmocbQ6KbJdNBdxA";
    $date = $date ?? date("Y-m-d");
    $url = "https://api.nasa.gov/planetary/apod?api_key=$api_key&date=$date&thumbs=True";

    $response = @file_get_contents($url);
    if ($response === false) {
        return "<p>Erreur : impossible de contacter l'API de la NASA.</p>";
    }

    $data = json_decode($response, true);
    if (!isset($data['url'])) {
        return "<p>Erreur : données invalides reçues de l'API.</p>";
    }

    $title = $data['title'] ?? 'Image du jour';
    $description = $data['explanation'] ?? 'Description non disponible';
    $date_apod = $data['date'] ?? 'Date inconnue';
    $media_type = $data['media_type'] ?? 'image';
    $copyright = $data['copyright'] ?? '© inconnu';
    $mediaUrl = $data['url'] ?? '';
    $thumbnailUrl = $data['thumbnail_url'] ?? '';

    $html = "<section id='apod'>
        <h2>" . htmlspecialchars($title) . "</h2>
        <p><strong>Date :</strong> " . htmlspecialchars($date_apod) . "</p>
        <p><strong>Type :</strong> " . htmlspecialchars($media_type) . "</p>
        <p><strong>Copyright :</strong> " . htmlspecialchars($copyright) . "</p>
        <figure>";

    if ($media_type === "image") {
        $html .= "<img src='" . htmlspecialchars($mediaUrl) . "' alt='Image de la NASA' width='600'/>";
    } elseif ($media_type === "video") {
        if (!empty($thumbnailUrl)) {
            $html .= "<a href='" . htmlspecialchars($mediaUrl) . "' target='_blank'>
                        <img src='" . htmlspecialchars($thumbnailUrl) . "' alt='Miniature vidéo'/>
                      </a>";
        } else {
            $html .= "<iframe width='600' height='400' src='" . htmlspecialchars($mediaUrl) . "' frameborder='0' allowfullscreen></iframe>";
        }
    } else {
        $html .= "<p>Média non pris en charge.</p>";
    }

    $html .= "<figcaption>" . htmlspecialchars($description) . "</figcaption>
        </figure>
    </section>";

    return $html;
}

// Récupérer l'adresse IP de l'utilisateur
/**
 *Fonction qui permet d'afficher la localisation approximative du visiteur json
*@param void
*@return string Les différentes informations de localisation
*/
function ip_location_json(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $url = "https://ipinfo.io/$ip/geo";
    $response = @file_get_contents($url);
    if ($response === false) return "<p>Erreur lors de la récupération via ipinfo.io</p>";

    $data = json_decode($response, true);
    if (!$data) return "<p>Données de localisation introuvables.</p>";

    $loc = explode(',', $data['loc'] ?? ',');
    $dataFormatted = [
        'Adresse IP' => $data['ip'] ?? 'inconnue',
        'Pays' => $data['country'] ?? 'inconnu',
        'Ville' => $data['city'] ?? 'inconnue',
        'Région' => $data['region'] ?? 'inconnue',
        'Code Postal' => $data['postal'] ?? 'inconnu',
        'Fuseau horaire' => $data['timezone'] ?? 'inconnu',
        'Latitude' => $loc[0] ?? 'N/A',
        'Longitude' => $loc[1] ?? 'N/A'
    ];

    $html = "<ul>";
    foreach ($dataFormatted as $key => $value) {
        $html .= "<li><strong>$key :</strong> " . htmlspecialchars($value) . "</li>";
    }
    $html .= "</ul>";

    return $html;
}
/**
 * Fonction qui récupère et affiche la localisation approximative du visiteur via GeoPlugin (XML)
 * @return string HTML affichant les informations de localisation
 */
function ip_location_xml(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $url = "http://www.geoplugin.net/xml.gp?ip=$ip";

    $response = @file_get_contents($url);
    if ($response === false) {
        return "<p>Erreur : impossible de contacter l'API GeoPlugin.</p>";
    }

    // Charger la réponse XML
    $xml = simplexml_load_string($response);
    if (!$xml) {
        return "<p>Erreur : réponse XML invalide.</p>";
    }

    // Extraire les données utiles
    $dataFormatted = [
        'Adresse IP' => $xml->geoplugin_request ?? 'inconnue',
        'Pays' => $xml->geoplugin_countryName ?? 'inconnu',
        'Ville' => $xml->geoplugin_city ?? 'inconnue',
        'Région' => $xml->geoplugin_region ?? 'inconnue',
        'Code Postal' => $xml->geoplugin_areaCode ?? 'inconnu',
        'Latitude' => $xml->geoplugin_latitude ?? 'N/A',
        'Longitude' => $xml->geoplugin_longitude ?? 'N/A'
    ];

    // Générer l'affichage en HTML
    $html = "<ul>";
    foreach ($dataFormatted as $key => $value) {
        $html .= "<li><strong>$key :</strong> " . htmlspecialchars($value) . "</li>";
    }
    $html .= "</ul>";

    return $html;
}

/**
 * Fonction pour récupérer et afficher les prévisions météo pour une ville donnée.
 * 
 * Cette fonction interroge l'API de WeatherAPI pour obtenir les prévisions météorologiques pour la ville spécifiée,
 * puis elle retourne un texte HTML formatté contenant ces informations. 
 * Les prévisions concernent les 3 prochains jours, et incluent la description du temps et la température moyenne.
 *
 * @param string $ville Le nom de la ville pour laquelle récupérer la météo.
 * 
 * @return string Retourne une chaîne HTML contenant les informations météorologiques pour la ville.
 */
function get_weather($ville) {
    $apiKey = "5b7769b4ae7841d0845181554250104"; 
    $url = "http://api.weatherapi.com/v1/forecast.json?key=$apiKey&q=" . urlencode($ville) . "&days=3&lang=fr";

    
    $response = @file_get_contents($url);

    
    if ($response === false) {
        return "<p>Erreur : Impossible de contacter l'API météo.</p>";
    }

    $data = json_decode($response, true);

    if (!isset($data["location"])) {
        return "<p>Erreur : Données météo invalides.</p>";
    }

    $output = "<h2>Météo à {$data["location"]["name"]}, {$data["location"]["country"]}</h2>";
    foreach ($data["forecast"]["forecastday"] as $day) {
        $output .= "<p><strong>{$day["date"]}</strong> : {$day["day"]["condition"]["text"]}, 🌡 {$day["day"]["avgtemp_c"]}°C</p>";
    }
    
    return $output;
}
$weatherOutput = "";
if (isset($_GET['ville']) && !empty($_GET['ville'])) {
    $ville = $_GET['ville'];
    $weatherOutput = get_weather($ville);
}
?>
