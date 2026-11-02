<?php
namespace controller;

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/ModelRoomDAO.php';
require_once __DIR__ . '/../model/ModelWordDAO.php';

use model\ModelRoomDAO $roomDAO;
use model\ModelWordDAO $wordDAO;

class ControllerMultiplayer extends Controller
{
    private ModelRoomDAO $roomDAO;
    private ModelWordDAO $wordDAO;

    public function __construct()
    {
        $this->roomDAO = new ModelRoomDAO();
        $this->wordDAO = new ModelWordDAO();
    }

    private function jsonResponse(array $data, int $statusCode = 200): void //pour ne pas renvoyer de HTML et renvoyer du JSON
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    private function getUsername(): string //pour vérifier si le joueur est bien connecté
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
    }
        if (empty($_SESSION['username'])) {
        $this->jsonResponse(['error' => 'Tu dois être connecté pour jouer.'], 401);
        }
        return $_SESSION['username'];
    }
}
