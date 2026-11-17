<?php

session_start();

require_once 'config/database.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = (int) $_SESSION['usuario_id'];

// Verifica se recebeu o ID do lead
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: leads.php');
    exit;
}

$lead_id = (int) $_GET['id'];

try {

    /*
     * Só permite excluir o lead se ele pertencer
     * a um projeto pertencente ao usuário logado.
     */
    $sql = "
        DELETE leads
        FROM leads
        INNER JOIN projetos
            ON projetos.id = leads.projeto_id
        WHERE leads.id = :lead_id
        AND projetos.usuario_id = :usuario_id
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':lead_id' => $lead_id,
        ':usuario_id' => $usuario_id
    ]);

    header('Location: leads.php?excluido=sucesso');
    exit;

} catch (PDOException $e) {

    header('Location: leads.php?erro=exclusao');
    exit;
}