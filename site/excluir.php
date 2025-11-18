<?php
include 'config.php';

// Processar exclusão
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM TB_Curso WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header('Location: listar.php?msg=deleted');
        exit;
    } else {
        header('Location: listar.php?msg=error');
        exit;
    }
    
    $stmt->close();
}

header('Location: listar.php');
exit;
?>