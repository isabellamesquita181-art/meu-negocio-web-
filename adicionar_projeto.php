<?php

session_start();

require_once 'config/database.php';

/*
|--------------------------------------------------------------------------
| VERIFICA LOGIN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$erro = '';
$sucesso = '';

/*
|--------------------------------------------------------------------------
| CADASTRAR PROJETO
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome_projeto = trim($_POST['nome_projeto'] ?? '');
    $url_projeto = trim($_POST['url_projeto'] ?? '');

    if ($nome_projeto === '') {

        $erro = 'Digite o nome do projeto.';

    } elseif ($url_projeto === '') {

        $erro = 'Digite a URL do projeto.';

    } else {

        try {

            $sql = "
                INSERT INTO projetos
                (
                    usuario_id,
                    nome_projeto,
                    url_projeto,
                    status_projeto,
                    visitas
                )
                VALUES
                (
                    :usuario_id,
                    :nome_projeto,
                    :url_projeto,
                    'Online',
                    0
                )
            ";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':usuario_id' => $usuario_id,
                ':nome_projeto' => $nome_projeto,
                ':url_projeto' => $url_projeto
            ]);

            $sucesso = 'Projeto criado com sucesso!';

            /*
            | Depois de salvar, limpamos os campos.
            */

            $nome_projeto = '';
            $url_projeto = '';

        } catch (PDOException $e) {

            $erro = 'Erro ao salvar o projeto: ' . $e->getMessage();

        }
    }
}

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Novo Projeto — Meu Negócio Web</title>


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {

            font-family: Arial, sans-serif;

            background: #0f172a;

            color: white;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 20px;

        }


        .container {

            width: 100%;

            max-width: 600px;

            background: #1e293b;

            border: 1px solid #334155;

            border-radius: 16px;

            padding: 35px;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.4);

        }


        h1 {

            font-size: 28px;

            margin-bottom: 8px;

        }


        .subtitulo {

            color: #94a3b8;

            margin-bottom: 30px;

        }


        .campo {

            margin-bottom: 22px;

        }


        label {

            display: block;

            margin-bottom: 8px;

            font-weight: bold;

        }


        input {

            width: 100%;

            padding: 14px;

            border-radius: 8px;

            border: 1px solid #475569;

            background: #0f172a;

            color: white;

            font-size: 15px;

        }


        input:focus {

            outline: none;

            border-color: #38bdf8;

        }


        .ajuda {

            display: block;

            margin-top: 7px;

            color: #64748b;

            font-size: 13px;

        }


        .botao {

            width: 100%;

            padding: 14px;

            border: none;

            border-radius: 8px;

            background: #0ea5e9;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

        }


        .botao:hover {

            background: #0284c7;

        }


        .erro {

            background: #7f1d1d;

            color: #fecaca;

            padding: 13px;

            border-radius: 8px;

            margin-bottom: 20px;

        }


        .sucesso {

            background: #14532d;

            color: #bbf7d0;

            padding: 13px;

            border-radius: 8px;

            margin-bottom: 20px;

        }


        .voltar {

            display: block;

            text-align: center;

            margin-top: 25px;

            color: #94a3b8;

            text-decoration: none;

        }


        .voltar:hover {

            color: #38bdf8;

        }

    </style>

</head>


<body>


<div class="container">


    <h1>

        Novo projeto

    </h1>


    <p class="subtitulo">

        Cadastre um novo site no Meu Negócio Web.

    </p>


    <?php if ($erro !== ''): ?>

        <div class="erro">

            <?= htmlspecialchars($erro) ?>

        </div>

    <?php endif; ?>


    <?php if ($sucesso !== ''): ?>

        <div class="sucesso">

            <?= htmlspecialchars($sucesso) ?>

        </div>

    <?php endif; ?>


    <form method="POST">


        <div class="campo">

            <label for="nome_projeto">

                Nome do projeto

            </label>


            <input
                type="text"
                id="nome_projeto"
                name="nome_projeto"
                placeholder="Ex.: Doceria da Ana"
                value="<?= htmlspecialchars($nome_projeto ?? '') ?>"
                required
            >

        </div>


        <div class="campo">

            <label for="url_projeto">

                URL do projeto

            </label>


            <input
                type="url"
                id="url_projeto"
                name="url_projeto"
                placeholder="Ex.: http://localhost/meu_negocio_web/rascunho.php?id=1"
                value="<?= htmlspecialchars($url_projeto ?? '') ?>"
                required
            >


            <span class="ajuda">

                Por enquanto, coloque uma URL de teste.
                Depois vamos fazer o sistema gerar essa página automaticamente.

            </span>

        </div>


        <button
            type="submit"
            class="botao"
        >

            Criar projeto

        </button>


    </form>


    <a
        href="dashboard.php"
        class="voltar"
    >

        ← Voltar para o Dashboard

    </a>


</div>


</body>

</html>