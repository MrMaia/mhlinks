<?php
// Inclui o arquivo de conexão
include 'conexao.php';

// Recupera todas as categorias do banco de dados
$categorias = [];
try {
  $stmt = $conexao->query("SELECT id_categoria, nome_categoria FROM categoria");
  $stmt2 = $conexao->query("SELECT id_sub_categoria, nome FROM sub_categoria");
  $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $sub_categorias = $stmt2->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Erro ao buscar categorias: " . $e->getMessage();
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
  <script defer src="assets/fontawesome/js/all.min.js"></script>
  <!-- Theme CSS -->
  <link id="theme-style" rel="stylesheet" href="assets/css/theme.css">
</head>

<body>
  <?php include 'partials/header.php'; ?>

  <h2>Criar Link</h2>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="id_categoria">Escolha a categoria que vai criar o link:</label><br>
    <select id="id_categoria" name="id_categoria" required>
      <option value="">Selecione uma categoria</option>
      <?php foreach ($categorias as $categoria) : ?>
        <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nome_categoria']; ?></option>
      <?php endforeach; ?>
    </select><br><br>

    <div id="subcategoria_container" style="display: none;">
      <label for="id_sub_categoria">Escolha a sub-categoria que vai criar o link:</label><br>
      <select id="id_sub_categoria" name="id_sub_categoria">
        <option value="">Selecione uma sub-categoria</option>
		<?php foreach ($sub_categorias as $sub_categoria) : ?>
        	<option value="<?php echo $sub_categoria['id_sub_categoria']; ?>"><?php echo $sub_categoria['nome']; ?></option>
      	<?php endforeach; ?>
      </select><br><br>
    </div>

    <label for="imagem">Imagem:</label><br>
    <input type="text" id="imagem" name="imagem" required><br><br>

    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome" required><br><br>

    <label for="descricao">Descrição:</label><br>
    <textarea id="descricao" name="descricao" required></textarea><br><br>

    <input type="submit" value="Enviar">
  </form>

  <script>
    // Function to fetch subcategories based on selected category
    function fetchSubcategories(categoryId) {
      if (categoryId !== "") {
        document.getElementById("subcategoria_container").style.display = "block";
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("id_sub_categoria").innerHTML = this.responseText;
          }
        };
        xhttp.open("GET", "<?php echo $_SERVER['PHP_SELF']; ?>?categoria_id=" + categoryId, true);
        xhttp.send();
      } else {
        document.getElementById("subcategoria_container").style.display = "none";
        document.getElementById("id_sub_categoria").innerHTML = "<option value=''>Selecione uma sub-categoria</option>";
      }
    }

    // Event listener for category selection
    document.getElementById("id_categoria").addEventListener("change", function() {
      fetchSubcategories(this.value);
    });

    // Call fetchSubcategories on page load if a category is already selected
    fetchSubcategories(document.getElementById("id_categoria").value);
  </script>

  <?php
  // Verifica se o formulário foi enviado
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos do formulário estão preenchidos
    if (!empty($_POST['id_categoria']) && !empty($_POST['imagem']) && !empty($_POST['nome']) && !empty($_POST['descricao'])) {
      // Verifica se a subcategoria foi selecionada (caso visível)
      if ($_POST['id_sub_categoria'] || !isset($_POST['id_sub_categoria'])) {
        // Prepara a instrução SQL para inserir dados na tabela link
        $sql = "INSERT INTO link (id_categoria, id_sub_categoria, imagem, nome, descricao) VALUES (:id_categoria, :id_sub_categoria, :imagem, :nome, :descricao)";

        try {
          // Prepara a consulta
          $stmt = $conexao->prepare($sql);

          // Vincula os parâmetros
          $stmt->bindParam(':id_categoria', $_POST['id_categoria']);
          $stmt->bindParam(':id_sub_categoria', $_POST['id_sub_categoria']);
          $stmt->bindParam(':imagem', $_POST['imagem']);
          $stmt->bindParam(':nome', $_POST['nome']);
          $stmt->bindParam(':descricao', $_POST['descricao']);

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
        echo "Selecione uma sub-categoria.";
      }
    } else {
      echo "Todos os campos do formulário devem ser preenchidos.";
    }
  }

  // Verifica se foi feita uma solicitação para buscar sub-categorias
  if(isset($_GET['categoria_id'])) {
    $categoria_id = $_GET['categoria_id'];

    // Recupera as sub-categorias correspondentes à categoria selecionada
    $subcategorias = [];
    try {
      $stmt = $conexao->prepare("SELECT id_sub_categoria, nome_sub_categoria FROM sub_categoria WHERE id_categoria = :categoria_id");
      $stmt->bindParam(':categoria_id', $categoria_id);
      $stmt->execute();
      $subcategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Erro ao buscar sub-categorias: " . $e->getMessage();
    }
  }
  ?>

</body>

</html>
