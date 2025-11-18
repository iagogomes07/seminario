<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Curso - Sistema CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>➕ Cadastrar Novo Curso</h1>
            <p>Preencha os dados do curso abaixo</p>
        </header>

        <nav class="menu">
            <a href="index.html" class="btn">🏠 Início</a>
            <a href="cadastro.php" class="btn">➕ Cadastrar Curso</a>
            <a href="listar.php" class="btn">📋 Listar Cursos</a>
        </nav>

        <div class="form-container">
            <?php
            // Processar formulário se foi enviado
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nome_curso = $_POST['nome_curso'];
                $descricao = $_POST['descricao'];
                $duracao = $_POST['duracao'];
                
                // Inserir no banco
                $sql = "INSERT INTO TB_Curso (nome_curso, descricao, duracao_horas) 
                        VALUES (?, ?, ?)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $nome_curso, $descricao, $duracao);
                
                if ($stmt->execute()) {
                    echo '<div class="message success">✅ Curso cadastrado com sucesso!</div>';
                } else {
                    echo '<div class="message error">❌ Erro ao cadastrar curso: ' . $conn->error . '</div>';
                }
                
                $stmt->close();
            }
            ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nome_curso">Nome do Curso:</label>
                    <input type="text" id="nome_curso" name="nome_curso" required 
                           placeholder="Ex: Programação Web, Banco de Dados...">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" 
                              placeholder="Descreva o conteúdo do curso..."></textarea>
                </div>

                <div class="form-group">
                    <label for="duracao">Duração (horas):</label>
                    <input type="number" id="duracao" name="duracao" 
                           placeholder="Ex: 40" min="1">
                </div>

                <button type="submit" class="btn btn-submit">💾 Cadastrar Curso</button>
            </form>
        </div>

        <footer>
            <p>Seminário de Banco de Dados - © 2025</p>
        </footer>
    </div>
</body>
</html>
<?php $conn->close(); ?>