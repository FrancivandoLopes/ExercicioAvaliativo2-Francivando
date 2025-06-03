<?php
// conecatando ao banco de dados mysql ultilizando PDO
// Certifique-se de que o PDO está habilitado no seu PHP.ini
$conn = new PDO("mysql:host=localhost;dbname=exemplobd", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// se a tabela alunos nao existir é automaticamente criada
$conn->exec("CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nome VARCHAR(100), 
    email VARCHAR(100),
    idade INT
)");

// Verifica a ação solicitada via parâmetro GET
switch ($_GET['action']) {
    case 'read':
        // Lê todos os registros da tabela 'alunos'
        $stmt = $conn->query("SELECT id, nome, email, idade FROM alunos");
        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($alunos);
        break;
    case 'create':
        // Cria um novo registro na tabela 'alunos'
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $idade = $_POST['idade'];
        $stmt = $conn->prepare("INSERT INTO alunos (nome, email, idade) VALUES (:nome, :email, :idade)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
        $stmt->execute();
        echo "Aluno criado!";
        break;
}
?>
