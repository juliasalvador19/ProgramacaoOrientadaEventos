<?php

session_start();
include_once("conexao.php");


$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING);
$idade = filter_input(INPUT_POST, 'idade', FILTER_SANITIZE_NUMBER_INT);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);

// echo "Nome: $nome <br>";
// echo "Sexo: $sexo <br>";
// echo "Idade: $idade <br>";
// echo "Cidade: $cidade <br>";

$result_paciente = "INSERT INTO pacientes (nome, sexo, idade, cidade) VALUES ('$nome', '$sexo', '$idade', '$cidade')";
$resultado_paciente = mysqli_query($conn, $result_paciente);

if(mysqli_insert_id($conn)){
    $_SESSION['msg'] = "<p class='pacienteCadastrado'>Paciente cadastrado com sucesso!</p>";
    header("Location: cadastraPaciente.php");
} else {
    header("Location: cadastraPaciente.php");
}

