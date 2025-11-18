<?php
include 'config.php';

// Buscar dados do curso para edição
$id = $_GET['id'] ?? 0;
$curso = null;

if ($id) {
    $sql = "SELECT * FROM TB_Curso WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $curso = $result->fetch_assoc();
    $stmt->close();
}

// Processar atualização
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome_curso = $_POST['nome_curso'];
    $descricao = $_POST['descricao'];
    $duracao = $_POST['duracao'];
    
    $sql = "UPDATE TB_Curso SET nome_curso = ?, descricao = ?, duracao_horas = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $nome_curso, $descricao, $duracao, $id);
    
    if ($stmt->execute()) {
        header('Location: listar.php?msg=updated');
        exit;
    } else {
        $error = "Erro ao atualizar: " . $conn->error;
    }
    
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso - Sistema CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>✏️ Editar Curso</h1>
            <p>Atualize os dados do curso selecionado</p>
        </header>

        <nav class="menu">
            <a href="index.html" class="btn">🏠 Início</a>
            <a href="cadastro.php" class="btn">➕ Cadastrar Curso</a>
            <a href="listar.php" class="btn">📋 Listar Cursos</a>
        </nav>

        <div class="form-container">
            <?php if ($curso): ?>
                <?php if (isset($error)) echo '<div class="message error">' . $error . '</div>'; ?>
                
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $curso['id']; ?>">
                    
                    <div class="form-group">
                        <label for="nome_curso">Nome do Curso:</label>
                        <input type="text" id="nome_curso" name="nome_curso" required 
                               value="<?php echo htmlspecialchars($curso['nome_curso']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição:</label>
                        <textarea id="descricao" name="descricao"><?php echo htmlspecialchars($curso['descricao']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="duracao">Duração (horas):</label>
                        <input type="number" id="duracao" name="duracao" 
                               value="<?php echo $curso['duracao_horas']; ?>" min="1">
                    </div>

                    <button type="submit" class="btn btn-submit">💾 Atualizar Curso</button>
                </form>
            <?php else: ?>
                <div class="message error">❌ Curso não encontrado!</div>
                <a href="listar.php" class="btn">← Voltar para a lista</a>
            <?php endif; ?>
        </div>

        <footer>
            <p>Seminário de Banco de Dados - © 2025</p>
        </footer>
    </div>
</body>
</html>
<?php $conn->close(); ?>