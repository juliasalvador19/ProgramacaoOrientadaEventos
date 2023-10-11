<?php 
    session_start();
    include_once "conexao.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico</title>
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

        <form class="historico-forms" method="POST" action="">
            <label for="protocolo">Protocolo:</label>
            <input class="historico-dados" id="protocolo" type="number" name="protocolo" required>
            <label for="dataInicio">Data Inicio:</label>
            <input class="historico-dados" type="date" name="dataInicio" id="dataInicio" required>   
            <label for="dataFim">Data Fim:</label>
            <input class="historico-dados" type="date" name="dataFim" id="dataFim" required>   
            <input class="historico-pesquisar" type="submit" value="Pesquisar">
        </form>
    </header>

    <article>
        <section class="historico">
            <h3 class="consulta-titulo centraliza">Histórico</h3>
            <p class="centraliza">Dados referente as consultas anteriores do paciente:</p>
            <?php 
             if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $protocolo = $_POST['protocolo'];
                $dataInicio = $_POST['dataInicio'];
                $dataFim = $_POST['dataFim'];

                // Certifique-se de que as datas estejam no formato apropriado para SQL datetime
                $dataInicio = date('Y-m-d H:i:s', strtotime($dataInicio));
                $dataFim = date('Y-m-d H:i:s', strtotime($dataFim));
                
                $query = "SELECT h.id, h.frequenciaCardiaca, h.frequenciaRespiratoria, h.pressaoArterial, h.temperatura, p.nome 
                            FROM historico h
                            JOIN pacientes p on p.id = h.pacienteId
                           WHERE h.pacienteId = $protocolo 
                             AND DATE(h.horario) >= '$dataInicio' 
                             AND DATE(h.horario) <= '$dataFim'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table table-striped '>";
                        echo "<tr><th>#</th><th>Nome</th><th>Frequência Cardíaca</th><th>Frequência Respiratória</th><th>Pressão Arterial</th><th>Temperatura</th></tr>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['nome']."</td>";
                            echo "<td>".$row['frequenciaCardiaca']." BPM</td>";
                            echo "<td>".$row['frequenciaRespiratoria']." IRPM</td>";
                            echo "<td>".$row['pressaoArterial']." mmHg</td>";
                            echo "<td>".$row['temperatura']."ºc </td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "<p class='retornoHistorico'>Nenhum histórico encontrado referente ao paciente $protocolo!</p>";
                    }
                } else {
                    echo "Erro na consulta: " . mysqli_error($conn);
                }
        }
            ?>
        </section>
    </article>

    <footer class="home-rodape centraliza">
        <small>Todos os direitos reservados &copy 2023 &reg Julia Salvador e Mariana Dircksen</small>
    </footer>
</body>
</html>