<?php 
    session_start();
    include("conexao.php");
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados Paciente</title>
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

    <article class="dados">
        <section class="dadosPaciente">
        <?php

            function nomePaciente($conn, $pacienteId){
                $result_nome = "SELECT nome FROM pacientes WHERE id = '$pacienteId'";
                $resultado_nome = mysqli_query($conn, $result_nome);  
                
                if ($resultado_nome && mysqli_num_rows($resultado_nome) > 0) {
                    $row = mysqli_fetch_assoc($resultado_nome);
                    return $row['nome'];
                } else {
                    return "Paciente não encontrado";
                }
            }

            function idadePaciente($conn, $pacienteId){
                $result_idade = "SELECT idade FROM pacientes WHERE id = '$pacienteId'";
                $resultado_idade = mysqli_query($conn, $result_idade);
            
                if ($resultado_idade && mysqli_num_rows($resultado_idade) > 0) {
                    $row = mysqli_fetch_assoc($resultado_idade);
                    return $row['idade'];
                } else {
                    return "Idade não encontrada";
                }
            }

            function dadosPaciente($conn, $pacienteId) {
                $frequenciaCardiaca = rand(60, 171);
                $frequenciaRespiratoria = rand(12, 61);
                $pressaoArterial1 = rand(90, 150);
                $pressaoArterial2 = rand(60,120);
                $temperatura = rand(32, 42);
                date_default_timezone_set('America/Sao_Paulo');
                $horario = date("Y-m-d H:i:s");
                $pressaoArterial = $pressaoArterial1 . "x" . $pressaoArterial2;
                $nomePaciente = nomePaciente($conn, $pacienteId);
                $idadePaciente = idadePaciente($conn, $pacienteId);

                echo "<span id='pacienteId'>Protocolo: $pacienteId</span> <br>";
                echo "<span id='nomePaciente'>Nome do Paciente: $nomePaciente</span> <br>";
                echo "<span id='idadePaciente'>Idade do Paciente: $idadePaciente</span> <br>";
                echo "<span id='frequenciaCardiaca'>Frequência Cardíaca: $frequenciaCardiaca BPM</span> <br>";
                echo "<span id='frequenciaRespiratoria'>Frequência Respiratória: $frequenciaRespiratoria IRPM</span> <br>";
                echo "<span id='pressaoArterial'>Pressão Arterial: $pressaoArterial mmHg</span> <br>";
                echo "<span id='temperatura'>Temperatura: $temperatura ºC</span> <br>";
                echo "<span class='separador-alertas' id='horario'>Data atual: $horario</span> <br>";

                $result_historico = "INSERT INTO historico (pacienteId, frequenciaCardiaca, frequenciaRespiratoria, pressaoArterial, temperatura, horario) VALUES ('$pacienteId', '$frequenciaCardiaca', '$frequenciaRespiratoria', '$pressaoArterial', '$temperatura', '$horario')";
                $resultado_historico = mysqli_query($conn, $result_historico);
                
                // Validação da Frequência Cardiaca 
                if ($idadePaciente < 2) {
                    if($frequenciaCardiaca < 100 || $frequenciaCardiaca > 170){
                        echo "<span class='alerta-ruim'>A frequência cardiaca não está boa! (60-100 BPM)</span>"; 
                    } else {
                        echo "<span class='alerta-bom'>A frequência cardiaca está boa! (100-170 BPM)</span>";  
                    };
                }   

                if ($idadePaciente >= 2 && $idadePaciente <= 10){
                    if($frequenciaCardiaca < 70 || $frequenciaCardiaca > 120){
                        echo "<span class='alerta-ruim'>A frequência cardiaca não está boa! (60-100 BPM)</span>"; 
                    } else {
                        echo "<span class='alerta-bom'>A frequência cardiaca está boa! (100-170 BPM)</span>";  
                    }
                };

                if ($idadePaciente > 10){
                    if($frequenciaCardiaca < 60 || $frequenciaCardiaca > 100) {
                    echo  "<span class='alerta-ruim'>A frequência cardiaca não está boa! (60-100 BPM)</span>"; 
                } else {
                    echo "<span class='alerta-bom'>A frequência cardiaca está boa! (100-170 BPM)</span>";  
                }
                };

                // Validação da Frequência Respiratória 
                if ($idadePaciente < 2){ 
                    if($frequenciaRespiratoria < 30 || $frequenciaRespiratoria > 60){
                        echo "<span class='alerta-ruim'>A frequência respiratória não está boa! (30-60 IRPM)</span>"; 
                    } else {
                        echo "<span class='alerta-bom'>A frequência respiratória está boa! (30-60 IRPM)</span>";  
                    };
                };    


                if ($idadePaciente >= 2 && $idadePaciente <= 10){
                        if($frequenciaRespiratoria < 20 || $frequenciaRespiratoria > 30) {
                        echo "<span class='alerta-ruim'>A frequência respiratória não está boa! (20-30 IRPM)</span>"; 
                    } else {
                        echo "<span class='alerta-bom'>A frequência respiratória está boa! (20-30 IRPM)</span>";  
                    }
                };

                if ($idadePaciente > 10){ 
                    if($frequenciaRespiratoria < 12 || $frequenciaRespiratoria > 20) {
                        echo  "<span class='alerta-ruim'>A frequência respiratória não está boa! (12-20 IRPM)</span>"; 
                    } else {
                        echo "<span class='alerta-bom'>A frequência respiratória está boa! (12-20 IRPM)</span>";  
                    }
                };

                // Validação da Pressão Arterial
                if($pressaoArterial1 < 120){
                    echo "<span class='alerta-bom'>A pressão arterial está ótima!</span>";   
                }

                if($pressaoArterial1 >= 120 && $pressaoArterial1 <= 129){
                    echo "<span class='alerta-bom'>A pressão arterial está normal!</span>";   
                }
                if($pressaoArterial1 >= 130 && $pressaoArterial1 <= 139){
                    echo "<span class='alerta-ruim'>Pré Hipertensão!</span>";   
                }
                if($pressaoArterial1 >= 140 && $pressaoArterial1 <= 179){
                    echo "<span class='alerta-ruim'>Hipertensão!</span>";   
                }
                if($pressaoArterial1 >= 180){
                    echo "<span class='alerta-ruim'>Crise Hipertensiva!</span>";   
                }
                
                // Validação da Temperatura
                if($temperatura <= 35){
                    echo "<span class='alerta-ruim'>Hiportermia!</span>";   
                }
                if($temperatura > 35 && $temperatura <= 37){
                    echo "<span class='alerta-bom'>A temperatura está normal!</span>";   
                }
                if($temperatura > 37 && $temperatura <= 39){
                    echo "<span class='alerta-ruim'>Febre!</span>";   
                }
                if($temperatura > 39 && $temperatura <= 43 ){
                    echo "<span class='alerta-ruim'>Febre Alta!</span>";   
                }

            }

            $pacienteId = isset($_GET['pacienteId']) ? $_GET['pacienteId'] : '1';

            dadosPaciente($conn, $pacienteId);
        ?>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>">
        <input class="atualizaDados" type="submit" value="Atualizar">
    </form>
        </section>
    </article>

    <footer class="home-rodape centraliza">
        <small>Todos os direitos reservados &copy 2023 &reg Julia Salvador e Mariana Dircksen</small>
    </footer>
    
</body>
</html>