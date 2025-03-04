<?php
include 'functions.php';

$page = isset($_GET['page']) ? validateInput($_GET['page']) : 1;

if ($page === false) {
    echo "<script>var invalidPage = true;</script>";
} else {
    echo "<script>var invalidPage = false;</script>";
}

$entreprises = [
    ['nom' => 'TechCorp', 'secteur' => 'Technologie', 'ville' => 'Paris'],
    ['nom' => 'FinSoft', 'secteur' => 'Finance', 'ville' => 'Londres'],
    ['nom' => 'HealthPlus', 'secteur' => 'Santé', 'ville' => 'Berlin'],
    ['nom' => 'EduSmart', 'secteur' => 'Éducation', 'ville' => 'Madrid'],
    ['nom' => 'AutoDrive', 'secteur' => 'Automobile', 'ville' => 'Rome'],
    ['nom' => 'Foodies', 'secteur' => 'Alimentation', 'ville' => 'Bruxelles'],
    ['nom' => 'GreenEnergy', 'secteur' => 'Énergie', 'ville' => 'Amsterdam'],
    ['nom' => 'BuildIt', 'secteur' => 'Construction', 'ville' => 'Lisbonne'],
    ['nom' => 'TravelNow', 'secteur' => 'Tourisme', 'ville' => 'Athènes'],
    ['nom' => 'MediaWorks', 'secteur' => 'Médias', 'ville' => 'Stockholm'],
    ['nom' => 'TechSolutions', 'secteur' => 'Technologie', 'ville' => 'Helsinki'],
    ['nom' => 'FinTech', 'secteur' => 'Finance', 'ville' => 'Oslo'],
    ['nom' => 'HealthCare', 'secteur' => 'Santé', 'ville' => 'Copenhague'],
    ['nom' => 'EduLearn', 'secteur' => 'Éducation', 'ville' => 'Dublin'],
    ['nom' => 'AutoMotive', 'secteur' => 'Automobile', 'ville' => 'Prague'],
    ['nom' => 'FoodMarket', 'secteur' => 'Alimentation', 'ville' => 'Vienne'],
    ['nom' => 'EnergySave', 'secteur' => 'Énergie', 'ville' => 'Budapest'],
    ['nom' => 'BuildPro', 'secteur' => 'Construction', 'ville' => 'Varsovie'],
    ['nom' => 'TravelEasy', 'secteur' => 'Tourisme', 'ville' => 'Sofia'],
    ['nom' => 'MediaHouse', 'secteur' => 'Médias', 'ville' => 'Bucarest'],
];

$entreprises_par_page = 10;
$total_entreprises = count($entreprises);
$total_pages = ceil($total_entreprises / $entreprises_par_page);    

$page = isset($_GET['page']) && ctype_digit($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max(1, min($page, $total_pages));

$start_index = ($page - 1) * $entreprises_par_page;
$entreprises_page = array_slice($entreprises, $start_index, $entreprises_par_page);
?>