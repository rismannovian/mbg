<?php

class PetugasController extends Controller
{
    private $petugasModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'petugas') {
            header('Location: index.php?url=auth/login');
            exit;
        }

        $this->petugasModel = $this->model('PetugasModel');
    }

    public function dashboard()
    {
        // Ambil data petugas berdasarkan user login
        $user_id = $_SESSION['user']['id'];

        $petugas = $this->petugasModel->getByUserId($user_id);

        $this->view('petugas/dashboard', [
            'petugas' => $petugas
        ]);
    }
}