<?php
include 'config.php';

// Processa exclusão
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM TB_Curso WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: listar.php?msg-deleted');
        exit;
    } else {
        header('Location: listar.php?msg-error');
        exit;
    }
    $stmt->close();
    $conn->close(); // Fechar conexão
} else {
    // Só redireciona se não houver ID
    header('Location: listar.php');
    exit;
}
?>