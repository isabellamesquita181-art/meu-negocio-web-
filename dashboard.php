<?php

session_start();

require_once 'config/database.php';

/*
|--------------------------------------------------------------------------
| PROTEÇÃO DO DASHBOARD
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$nome_usuario = $_SESSION['usuario_nome'];


/*
|--------------------------------------------------------------------------
| TOTAL DE PROJETOS DO USUÁRIO
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM projetos
    WHERE usuario_id = ?
");

$stmt->execute([$usuario_id]);

$total_projetos = (int) $stmt->fetchColumn();


/*
|--------------------------------------------------------------------------
| PROJETOS ONLINE
|--------------------------------------------------------------------------
|
| Sua tabela utiliza "status_projeto".
| O valor padrão atualmente é "Online".
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM projetos
    WHERE usuario_id = ?
    AND status_projeto = 'Online'
");

$stmt->execute([$usuario_id]);

$projetos_online = (int) $stmt->fetchColumn();


/*
|--------------------------------------------------------------------------
| TOTAL DE VISITAS
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT COALESCE(SUM(visitas), 0)
    FROM projetos
    WHERE usuario_id = ?
");

$stmt->execute([$usuario_id]);

$total_visitas = (int) $stmt->fetchColumn();


/*
|--------------------------------------------------------------------------
| TOTAL DE LEADS
|--------------------------------------------------------------------------
|
| IMPORTANTE:
| A tabela leads atual não possui usuario_id ou projeto_id.
| Portanto, não é possível relacionar um lead diretamente
| ao usuário através do banco atual.
|
| Por enquanto mostramos o total existente na tabela leads.
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM leads
");

$total_leads = (int) $stmt->fetchColumn();


/*
|--------------------------------------------------------------------------
| PROJETOS DO USUÁRIO
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        id,
        nome_projeto,
        url_projeto,
        status_projeto,
        visitas,
        atualizado_em
    FROM projetos
    WHERE usuario_id = ?
    ORDER BY atualizado_em DESC
");

$stmt->execute([$usuario_id]);

$projetos = $stmt->fetchAll();

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard — Meu Negócio Web</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: #ffffff;
            min-height: 100vh;
        }

        /* HEADER */

        header {
            background: #1e293b;
            border-bottom: 1px solid #334155;

            padding: 20px 40px;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        .usuario {
            color: #cbd5e1;
        }

        .logout {
            margin-left: 20px;

            color: #38bdf8;

            text-decoration: none;
            font-weight: bold;
        }

        .logout:hover {
            text-decoration: underline;
        }

        /* CONTEÚDO */

        main {
            max-width: 1200px;

            margin: auto;

            padding: 40px 20px;
        }

        .titulo {
            margin-bottom: 30px;
        }

        .titulo h1 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .titulo p {
            color: #94a3b8;
        }

        /* CARDS */

        .cards {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;

            margin-bottom: 30px;
        }

        .card {

            background: #1e293b;

            border: 1px solid #334155;

            border-radius: 14px;

            padding: 25px;
        }

        .card-titulo {

            color: #94a3b8;

            font-size: 14px;
        }

        .card-valor {

            display: block;

            font-size: 32px;

            font-weight: bold;

            margin-top: 10px;
        }

        /* AÇÕES */

        .acoes {

            display: flex;

            gap: 15px;

            margin-bottom: 30px;
        }

        .botao {

            display: inline-block;

            padding: 13px 20px;

            border-radius: 8px;

            background: #0ea5e9;

            color: white;

            text-decoration: none;

            font-weight: bold;
        }

        .botao:hover {

            background: #0284c7;

        }

        .botao-secundario {

            background: #334155;

        }

        .botao-secundario:hover {

            background: #475569;

        }

        /* PROJETOS */

        .secao {

            background: #1e293b;

            border: 1px solid #334155;

            border-radius: 14px;

            overflow: hidden;
        }

        .secao-titulo {

            padding: 20px;

            border-bottom: 1px solid #334155;

        }

        .secao-titulo h2 {

            font-size: 20px;

        }

        table {

            width: 100%;

            border-collapse: collapse;

        }

        th,
        td {

            padding: 16px 20px;

            text-align: left;

            border-bottom: 1px solid #334155;

        }

        th {

            color: #94a3b8;

            font-size: 13px;

        }

        td {

            color: #e2e8f0;

        }

        .status {

            display: inline-block;

            padding: 6px 10px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: bold;

        }

        .online {

            background: #14532d;

            color: #bbf7d0;

        }

        .outro-status {

            background: #713f12;

            color: #fef3c7;

        }

        .projeto-link {

            color: #38bdf8;

            text-decoration: none;

            font-weight: bold;

        }

        .projeto-link:hover {

            text-decoration: underline;

        }

        .vazio {

            padding: 40px;

            text-align: center;

            color: #94a3b8;

        }

        /* RESPONSIVIDADE */

        @media (max-width: 900px) {

            .cards {

                grid-template-columns:
                    repeat(2, 1fr);

            }

        }

        @media (max-width: 600px) {

            header {

                padding: 20px;

            }

            .usuario {

                display: none;

            }

            .cards {

                grid-template-columns: 1fr;

            }

            .acoes {

                flex-direction: column;

            }

            .botao {

                text-align: center;

            }

            .secao {

                overflow-x: auto;

            }

            table {

                min-width: 700px;

            }

        }

    </style>

</head>

<body>


<header>

    <div class="logo">

        Meu Negócio Web

    </div>


    <div>

        <span class="usuario">

            Olá,
            <?= htmlspecialchars($nome_usuario) ?>

        </span>


        <a
            href="logout.php"
            class="logout"
        >
            Sair
        </a>

    </div>

</header>


<main>


    <div class="titulo">

        <h1>

            Visão Geral

        </h1>


        <p>

            Gerencie seus projetos e acompanhe seus resultados.

        </p>

    </div>


    <!-- CARDS -->

    <div class="cards">


        <div class="card">

            <span class="card-titulo">

                Total de projetos

            </span>


            <strong class="card-valor">

                <?= $total_projetos ?>

            </strong>

        </div>


        <div class="card">

            <span class="card-titulo">

                Projetos online

            </span>


            <strong class="card-valor">

                <?= $projetos_online ?>

            </strong>

        </div>


        <div class="card">

            <span class="card-titulo">

                Visitas acumuladas

            </span>


            <strong class="card-valor">

                <?= $total_visitas ?>

            </strong>

        </div>


        <div class="card">

            <span class="card-titulo">

                Leads

            </span>


            <strong class="card-valor">

                <?= $total_leads ?>

            </strong>

        </div>


    </div>


    <!-- BOTÕES -->

    <div class="acoes">


        <a
            href="adicionar_projeto.php"
            class="botao"
        >

            + Novo projeto

        </a>


        <a
            href="leads.php"
            class="botao botao-secundario"
        >

            Ver leads

        </a>


    </div>


    <!-- LISTA DE PROJETOS -->

    <div class="secao">


        <div class="secao-titulo">

            <h2>

                Meus projetos

            </h2>

        </div>


        <?php if (count($projetos) > 0): ?>


            <table>

                <thead>

                    <tr>

                        <th>
                            Projeto
                        </th>

                        <th>
                            URL
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Visitas
                        </th>

                        <th>
                            Atualizado em
                        </th>

                        <th>
                             Ações
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php foreach ($projetos as $projeto): ?>


                    <tr>


                        <td>

                            <?= htmlspecialchars(
                                $projeto['nome_projeto']
                            ) ?>

                        </td>


                        <td>

                            <?php if (!empty($projeto['url_projeto'])): ?>

                                <a
                                    class="projeto-link"
                                    href="<?= htmlspecialchars($projeto['url_projeto']) ?>"
                                    target="_blank"
                                >

                                    Ver site

                                </a>

                            <?php else: ?>

                                —

                            <?php endif; ?>

                        </td>


                        <td>


                            <?php if (
                                strtolower($projeto['status_projeto']) === 'online'
                            ): ?>


                                <span class="status online">

                                    Online

                                </span>


                            <?php else: ?>


                                <span class="status outro-status">

                                    <?= htmlspecialchars(
                                        $projeto['status_projeto']
                                    ) ?>

                                </span>


                            <?php endif; ?>


                        </td>


                        <td>

                            <?= (int) $projeto['visitas'] ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                date(
                                    'd/m/Y H:i',
                                    strtotime($projeto['atualizado_em'])
                                )
                            ) ?>

                        </td>


                        <td>

                            <a
                                 href="editar_projeto.php?id=<?= $projeto['id'] ?>"
                                 class="projeto-link"
                            >

                                 Editar

                              </a>

                        </td>

                    </tr>


                <?php endforeach; ?>


                </tbody>

            </table>


        <?php else: ?>


            <div class="vazio">

                <p>

                    Você ainda não possui projetos.

                </p>


                <br>


                <p>

                    Clique em
                    <strong>+ Novo projeto</strong>
                    para começar.

                </p>

            </div>


        <?php endif; ?>


    </div>


</main>

</body>

</html>