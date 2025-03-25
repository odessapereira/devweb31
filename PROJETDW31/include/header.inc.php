<!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?= $title ?? "Projet de Développement Web" ?></title>
        <meta charset="utf-8"/>
        <meta name="author" content="Nassim Chader & Odessa Triollet-Pereira" />
        <meta name="class" content="L2 Informatique"/>
        <meta name="group" content="B"/>
        <meta name="date" content="2025-03-19"/>
        <meta name="lieu" content="Université de Cergy"/>
        <meta name="description" content="Projet de développement web"/>
        <meta name="keywords" content="projet météo 2025 dev web"/>
        <link rel="icon" type="image/png" href="./images/meteo.png"/>
        <!-- Feuille de style dynamique -->
        <link rel="stylesheet" href="<?= $css_file ?>"/>
    </head>
    </header>
        <a href="index.php?style=<?= $style ?>"><img src="./images/meteo.png" alt="logo site" width="100"/></a>
        <!-- Changement du mode clair/sombre -->
        <div class="mode-switch">
            <a href="index.php?style=<?= ($style === 'alternatif') ? 'standard' : 'alternatif'; ?>">
                <?= ($style === 'alternatif') ? "🌞 Mode clair" : "🌙 Mode sombre"; ?>
            </a>
        </div>
         <!-- Menu de navigation -->
        <nav>
            <ul>
                <li><a href="index.php?style=<?= $style ?>">Accueil</a></li>
                <li><a href="tech.php?style=<?= $style ?>">Tech</a></li>
            </ul>
        </nav>