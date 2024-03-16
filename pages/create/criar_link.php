<?php
session_start();
// Inclui o arquivo de conexão
include '../../conexao.php';

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../../index.php");
    exit;
}

// Recupera todas as categorias do banco de dados
$categorias = [];
$subcategorias = [];
try {
  // Consulta para obter as categorias
  $stmt_categoria = $conexao->query("SELECT id_categoria, nome_categoria FROM categoria");
  $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);

  // Consulta para obter as subcategorias
  $stmt_subcategoria = $conexao->query("SELECT id_sub_categoria, nome, id_categoria FROM sub_categoria");
  $subcategorias = $stmt_subcategoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Erro ao buscar categorias e subcategorias: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <title>AjudaQui - Criar Link</title>
  <!-- Meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="coderdocs-logo.ico">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
  <!-- FontAwesome JS-->
  <script defer src="../../assets/fontawesome/js/all.min.js"></script>
  <!-- Theme CSS -->
  <link id="theme-style" rel="stylesheet" href="../../assets/css/theme.css">
</head>

<body>
  <?php include '../../partials/header.php'; ?>

  <h2>Criar Link</h2>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="id_categoria">Escolha a categoria que vai criar o link:</label><br>
    <select id="id_categoria" name="id_categoria" required>
      <option value="">Selecione...</option>
      <?php foreach ($categorias as $categoria) : ?>
        <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nome_categoria']; ?></option>
      <?php endforeach; ?>
    </select><br><br>

    <label for="id_sub_categoria" id="subcategoria-label" style="display: none;">Escolha a sub-categoria que vai criar o link:</label><br>
    <select id="id_sub_categoria" name="id_sub_categoria" style="display: none;">
      <option value="">Selecione...</option>
      <?php foreach ($subcategorias as $subcategoria) : ?>
        <option value="<?php echo $subcategoria['id_sub_categoria']; ?>" class="subcategoria-<?php echo $subcategoria['id_categoria']; ?>"><?php echo $subcategoria['nome']; ?></option>
      <?php endforeach; ?>
    </select><br><br>

    <label for="imagem">Imagem:</label><br>
    <input type="text" id="imagem" name="imagem" required><br><br>

    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome" required><br><br>

    <label for="descricao">Descrição:</label><br>
    <textarea id="descricao" name="descricao" required></textarea><br><br>

    <label for="link">Link:</label><br>
    <input type="text" id="link" name="link" required><br><br>

    <input type="submit" value="Enviar">
  </form>

  <script>
    document.getElementById('id_categoria').addEventListener('change', function() {
      var categoriaSelecionada = this.value;
      var subcategoriaSelect = document.getElementById('id_sub_categoria');
      var subcategoriaLabel = document.getElementById('subcategoria-label');
      var subcategorias = subcategoriaSelect.querySelectorAll('option');

      subcategorias.forEach(function(subcategoria) {
        subcategoria.style.display = 'none';
        if (subcategoria.classList.contains('subcategoria-' + categoriaSelecionada) || subcategoria.value === '') {
          subcategoria.style.display = 'block';
        }
      });

      subcategoriaLabel.style.display = 'block';
      subcategoriaSelect.style.display = 'block';
    });
  </script>

  <?php
  // Verifica se o formulário foi enviado
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos obrigatórios do formulário estão preenchidos
    if (!empty($_POST['id_categoria']) && !empty($_POST['imagem']) && !empty($_POST['nome']) && !empty($_POST['descricao']) && !empty($_POST['link'])) {
      // Prepara a instrução SQL para inserir dados na tabela link
      $sql = "INSERT INTO link (id_categoria, id_sub_categoria, imagem, nome, descricao, link) VALUES (:id_categoria, :id_sub_categoria, :imagem, :nome, :descricao, :link)";

      try {
        // Prepara a consulta
        $stmt = $conexao->prepare($sql);

        // Vincula os parâmetros
        $stmt->bindParam(':id_categoria', $_POST['id_categoria']);

        // Verifica se o campo de subcategoria está vazio antes de vinculá-lo
        if (!empty($_POST['id_sub_categoria'])) {
          $stmt->bindParam(':id_sub_categoria', $_POST['id_sub_categoria']);
        } else {
          // Se estiver vazio, vincula NULL à coluna id_sub_categoria
          $id_sub_categoria = null;
          $stmt->bindParam(':id_sub_categoria', $id_sub_categoria, PDO::PARAM_NULL);
        }

        $stmt->bindParam(':imagem', $_POST['imagem']);
        $stmt->bindParam(':nome', $_POST['nome']);
        $stmt->bindParam(':descricao', $_POST['descricao']);
        $stmt->bindParam(':link', $_POST['link']);

        // Executa a consulta
        if ($stmt->execute()) {
          echo "Link criado com sucesso!";
        } else {
          echo "Erro ao criar o link.";
        }
      } catch (PDOException $e) {
        echo "Erro ao criar o link: " . $e->getMessage();
      }
    } else {
      echo "Todos os campos obrigatórios do formulário devem ser preenchidos.";
    }
  }
  ?>


</body>

</html>