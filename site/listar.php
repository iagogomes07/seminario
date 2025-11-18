<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Cursos - Sistema CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📋 Lista de Cursos Cadastrados</h1>
            <p>Visualize, edite ou exclua cursos do sistema</p>
        </header>

        <nav class="menu">
            <a href="index.html" class="btn">🏠 Início</a>
            <a href="cadastro.php" class="btn">➕ Cadastrar Curso</a>
            <a href="listar.php" class="btn">📋 Listar Cursos</a>
        </nav>

        <div class="table-container">
            <?php
            // Buscar cursos do banco
            $sql = "SELECT * FROM TB_Curso ORDER BY data_cadastro DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome do Curso</th>
                            <th>Descrição</th>
                            <th>Duração (h)</th>
                            <th>Data Cadastro</th>
                            <th>Ações</th>
                        </tr>
                      </thead>';
                echo '<tbody>';
                
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td><strong>' . $row['nome_curso'] . '</strong></td>';
                    echo '<td>' . ($row['descricao'] ?: 'Sem descrição') . '</td>';
                    echo '<td>' . $row['duracao_horas'] . 'h</td>';
                    echo '<td>' . date('d/m/Y H:i', strtotime($row['data_cadastro'])) . '</td>';
                    echo '<td>
                            <a href="editar.php?id=' . $row['id'] . '" class="btn btn-edit">✏️ Editar</a>
                            <a href="excluir.php?id=' . $row['id'] . '" class="btn btn-delete" 
                               onclick="return confirm(\'Tem certeza que deseja excluir este curso?\')">🗑️ Excluir</a>
                          </td>';
                    echo '</tr>';
                }
                
                echo '</tbody></table>';
            } else {
                echo '<div class="no-courses">
                        <h3>📭 Nenhum curso cadastrado</h3>
                        <p>Clique em "Cadastrar Curso" para adicionar o primeiro curso!</p>
                      </div>';
            }
            ?>
        </div>

        <footer>
            <p>Seminário de Banco de Dados - © 2025</p>
        </footer>
    </div>
</body>
</html>
<?php $conn->close(); ?>