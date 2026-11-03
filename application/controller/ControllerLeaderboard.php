<?php

namespace controller;
use model\ModelGameDAO;

/**
 * Contrôler des leaderboards (route 'index.php?page=leaderboard).
 */

class ControllerLeaderboard extends Controller
{
    public function index(): void
    {
        $filter = $_GET['filter'] ?? 'daily';
        $dao = new ModelGameDAO();

        if ($filter === 'global') {
            $this->render('ViewLeaderboardGlobal', ['rows' => $dao->getGlobalLeaderboard()]);
            return;
        }

        $this->render('ViewLeaderboardDaily', ['rows' => $dao->getDailyLeaderboard()]);
    }
}