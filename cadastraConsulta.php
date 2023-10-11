<?php 
    include_once("conexao.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Pacientes</title>
    <link rel="shortcut icon" href="assets/logo.png" type="image/png">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

    <section class="consulta">
        <article>
            <h3 class="consulta-titulo centraliza">Pacientes</h3>
            <?php 
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }

            $pagina_atual = filter_input(INPUT_GET,'pagina', FILTER_SANITIZE_NUMBER_INT);
            $pagina = (!empty($pagina_atual))?$pagina_atual : 1;

            $quantidade_result_pagina = 5;

            $inicio = ($quantidade_result_pagina * $pagina ) - $quantidade_result_pagina;

            $result_pacientes = "SELECT * FROM pacientes LIMIT $inicio, $quantidade_result_pagina";
            $resultado_pacientes = mysqli_query($conn, $result_pacientes);
                echo "<table class='table table-striped'>
                <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Sexo</th>
                <th>Idade</th>
                <th>Cidade</th>
                <th>Ação</th>
            </tr>";

            while($row_paciente = mysqli_fetch_assoc($resultado_pacientes)){
            echo "<tr>
                        <td>"
                                . $row_paciente['id'] .
                        "</td>     
                        <td>"
                            . $row_paciente['nome'] .
                        "</td>   
                        <td>"
                            . $row_paciente['sexo'] .
                        "</td>   
                        <td>"
                            . $row_paciente['idade'] .
                        "</td>   
                        <td>"
                        . $row_paciente['cidade'] .
                        "</td>   
                        <td>
                            <a class='atendePaciente' href='atenderPaciente.php?pacienteId=" . $row_paciente['id'] . "'>Atender</a>
                        </td>   
                 </tr>";             
            }

            echo "</table>";

            $result_pagina = "SELECT COUNT(id) AS num_result FROM pacientes";       
            $resultado_pagina = mysqli_query($conn, $result_pagina);     
            $row_pagina = mysqli_fetch_assoc($resultado_pagina);

            $quantidade_pagina = ceil($row_pagina['num_result'] / $quantidade_result_pagina);

            $max_links = 2;
            echo "<a class='paginacao' href='cadastraConsulta.php?pagina=1'>Primeira</a>";

            for($pagina_anterior = $pagina - $max_links; $pagina_anterior <= $pagina - 1; $pagina_anterior++){
                if($pagina_anterior >= 1){
                    echo "<a class='paginacao' href='cadastraConsulta.php?pagina=$pagina_anterior'>$pagina_anterior</a>";  
                }
            };

            echo "<a class='paginacao' href='cadastraConsulta.php?pagina=$pagina'>$pagina</a>";

            for($pagina_depois = $pagina + 1; $pagina_depois <= $pagina + $max_links; $pagina_depois++){
                if($pagina_depois <= $quantidade_pagina){
                    echo "<a class='paginacao' href='cadastraConsulta.php?pagina=$pagina_depois'>$pagina_depois</a>";  
                }
            };

            echo "<a class='paginacao' href='cadastraConsulta.php?pagina=$quantidade_pagina'>Última</a>";


            ?>

            </form>
        </article>
    </section>

    <footer class="home-rodape centraliza">
        <small>Todos os direitos reservados &copy 2023 &reg Julia Salvador e Mariana Dircksen </small>
    </footer>
    
</body>
</html>