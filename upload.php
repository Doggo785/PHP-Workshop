<?php
// Vérifier si un fichier a été envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    $uploadDir = "uploads/";
    $file = $_FILES["fileToUpload"];
    $fileName = basename($file["name"]);
    $fileType = mime_content_type($file["tmp_name"]);
    $fileSize = $file["size"];
    $maxSize = 2 * 1024 * 1024; // 2 Mo

    // attaques XSS
    $safeFileName = htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8');

    // Vérifier le type MIME et la taille
    if ($fileType !== "application/pdf") {
        echo "Erreur : Seuls les fichiers PDF sont autorisés.";
        exit;
    }

    if ($fileSize > $maxSize) {
        echo "Erreur : La taille du fichier dépasse 2 Mo.";
        exit;
    }

    // Créer le dossier uploads s'il n'existe pas
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            error_log("Erreur : Impossible de créer le dossier de téléchargement.");
            echo "Erreur : Impossible de créer le dossier de téléchargement.";
            exit;
        }
    }

    // Vérifier si le dossier est accessible en écriture
    if (!is_writable($uploadDir)) {
        error_log("Erreur : Le dossier de téléchargement n'est pas accessible en écriture.");
        echo "Erreur : Le dossier de téléchargement n'est pas accessible en écriture.";
        exit;
    }

    // Générer un nom unique pour éviter les conflits
    $uniqueName = uniqid("pdf_", true) . ".pdf";
    $targetFile = $uploadDir . $uniqueName;

    // Déplacer le fichier téléchargé vers le dossier sécurisé
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        echo "Le fichier <strong>$safeFileName</strong> a été téléversé avec succès.";
    } else {
        // Ajout de messages d'erreur détaillés
        switch ($file['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $error = "Le fichier dépasse la taille maximale autorisée par php.ini.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $error = "Le fichier dépasse la taille maximale autorisée par le formulaire.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $error = "Le fichier n'a été que partiellement téléchargé.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $error = "Aucun fichier n'a été téléchargé.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $error = "Le dossier temporaire est manquant.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $error = "Échec de l'écriture du fichier sur le disque.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $error = "Une extension PHP a arrêté le téléchargement du fichier.";
                break;
            default:
                $error = "Erreur inconnue lors du téléchargement du fichier.";
                break;
        }
        error_log("Erreur de téléversement de fichier: " . $error . " (Code d'erreur: " . $file['error'] . ")");
        echo "Erreur : Impossible de téléverser le fichier. $error";
    }
} else {
    echo "Aucun fichier envoyé.";
}
?>