<?php 
  session_start();  
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical - Paciente</title>
    <link rel="shortcut icon" href="assets/logo.png" type="image/png">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header class="home-logo centraliza">
        <a href="index.php">
        <img src="assets/logo-semfundo2.png" alt="Logotipo do site">
        </a>

        <nav class="paciente-menu centraliza">
            <a class="paciente-menu-opcao" href="index.php">Home</a>
            <a class="paciente-menu-opcao" href="cadastraPaciente.php">Paciente</a>
            <a class="paciente-menu-opcao" href="cadastraConsulta.php">Consulta</a>
            <a class="paciente-menu-opcao" href="consultaHistorico.php">Histórico</a>
        </nav>
    </header>

    <section class="paciente">
        <article>
            <form class="paciente-forms" method="POST" action="processa.php">
                <h3 class="paciente-titulo centraliza">Cadastro de Pacientes</h3>

                <label for="nome">Nome: </label>
                <input id="nome" name="nome" class="paciente-dados" type="text" autocomplete="off" title="Informe o nome neste campo" required>

                <label for="sexo">Sexo: </label>
                <select class="paciente-sexo" name="sexo" title="Informe o sexo neste campo" required>
                    <option value="" autodisabled selected></option>
                    <option value="Feminino">Feminino</option>
                    <option value="Masculino">Masculino</option>
                </select>

                <label for="idade">Idade: </label>
                <input id="idade" name="idade" class="paciente-dados" type="number" min="1" max="200" autocomplete="off" title="Informe a idade neste campo" required>

                <label for="cidade">Cidade: </label>
                <input id="cidade" name="cidade" class="paciente-dados" type="text" autocomplete="off" title="Informe a cidade neste campo" required>

                <input class="paciente-cadastrar" type="submit" value="Cadastrar">

                <?php 
                if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </form>
        </article>
    </section>

    <footer class="home-rodape centraliza">
        <small>Todos os direitos reservados &copy 2023 &reg Julia Salvador e Mariana Dircksen</small>
    </footer>
    
</body>
</html>