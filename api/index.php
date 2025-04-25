<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

// Exemple de stockage des alertes (remplacez par une base de données dans un vrai projet)
$file = 'alerts.json';
if (!file_exists($file)) {
    file_put_contents($file, json_encode([]));
}
$alerts = json_decode(file_get_contents($file), true);

switch ($method) {
    case 'GET':
        // Lire toutes les alertes ou une alerte spécifique
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $alert = $alerts[$id] ?? null;
            echo json_encode($alert);
        } else {
            echo json_encode($alerts);
        }
        break;

    case 'POST':
        // Créer une nouvelle alerte
        $newAlert = $data;
        $alerts[] = $newAlert;
        file_put_contents($file, json_encode($alerts));
        echo json_encode(['message' => 'Alerte créée avec succès']);
        break;

    case 'PUT':
        // Mettre à jour une alerte existante
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if (isset($alerts[$id])) {
                $alerts[$id] = $data;
                file_put_contents($file, json_encode($alerts));
                echo json_encode(['message' => 'Alerte mise à jour avec succès']);
            } else {
                echo json_encode(['error' => 'Alerte non trouvée']);
            }
        }
        break;

    case 'DELETE':
        // Supprimer une alerte
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if (isset($alerts[$id])) {
                unset($alerts[$id]);
                file_put_contents($file, json_encode(array_values($alerts)));
                echo json_encode(['message' => 'Alerte supprimée avec succès']);
            } else {
                echo json_encode(['error' => 'Alerte non trouvée']);
            }
        }
        break;

    default:
        echo json_encode(['error' => 'Méthode non supportée']);
        break;
}
?>