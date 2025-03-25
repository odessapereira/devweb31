<?php

function display_nasa_apod(string $date = null): string
{
    $api_key = "aYu1IdzIojH4KnNHJ2Yeafq9kEM1nMjo3ip7IrbF";
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


function ip_location_geoplugin_json(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $url = "http://www.geoplugin.net/json.gp?ip=$ip";
    $response = @file_get_contents($url);
    if ($response === false) return "<p>Erreur lors de la récupération via GeoPlugin</p>";

    $data = json_decode($response, true);
    if (!$data) return "<p>Données GeoPlugin introuvables.</p>";

    $html = "<ul>";
    $html .= "<li><strong>Adresse IP :</strong> " . htmlspecialchars($ip) . "</li>";
    $html .= "<li><strong>Pays :</strong> " . htmlspecialchars($data['geoplugin_countryName'] ?? 'inconnu') . "</li>";
    $html .= "<li><strong>Ville :</strong> " . htmlspecialchars($data['geoplugin_city'] ?? 'inconnue') . "</li>";
    $html .= "<li><strong>Région :</strong> " . htmlspecialchars($data['geoplugin_region'] ?? 'inconnue') . "</li>";
    $html .= "<li><strong>Latitude :</strong> " . htmlspecialchars($data['geoplugin_latitude'] ?? 'N/A') . "</li>";
    $html .= "<li><strong>Longitude :</strong> " . htmlspecialchars($data['geoplugin_longitude'] ?? 'N/A') . "</li>";
    $html .= "<li><strong>Fuseau horaire :</strong> " . htmlspecialchars($data['geoplugin_timezone'] ?? 'N/A') . "</li>";
    $html .= "</ul>";

    return $html;
}
?>
