<?php
// Verificando se o formulário foi enviado com o método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // obtendo os dados do formulário
    if (!isset($_POST['nome']) || !isset($_POST['idade']) || !isset($_POST['email'])) {
        die("Dados incompletos.");
    }
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $email = $_POST['email'];
    try {
        // criando uma conexão com o banco de dados MySQL usando PDO
        $conn = new PDO("mysql:host=localhost;dbname=exemplobd", "root", "");
        // definindo o modo de erro do PDO para exceção
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        // caso não exista, cria a tabela alunos
        // (Certifique-se de que o banco de dados 'exemplobd' já exista)
        $conn->exec("CREATE TABLE IF NOT EXISTS alunos (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            nome VARCHAR(100), 
            idade INT, 
            email VARCHAR(100)
        )");
        // preparando uma instrução SQL para inserir os dados
        $stmt = $conn->prepare("INSERT INTO alunos (nome, idade, email) VALUES (:nome, :idade, :email)");
        // fazendo o bind dos parâmetros para evitar SQL Injection
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':email', $email);
        // Executa a instrução preparada
        $stmt->execute();
        // Exibe mensagem de sucesso
        echo "Dados inseridos com sucesso!";
    } catch (PDOException $e) {
        // Exibe mensagem de erro caso ocorra uma exceção
        echo "Erro: " . $e->getMessage();
    }
}
?>
