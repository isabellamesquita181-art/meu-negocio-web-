<?php

session_start();

require_once 'config/database.php';

// ============================================================
// PROTEÇÃO DE LOGIN
// ============================================================

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = (int) $_SESSION['usuario_id'];
$nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';


// ============================================================
// BUSCAR LEADS DO USUÁRIO
// ============================================================

try {

    $sql = "
        SELECT
            leads.id,
            leads.nome,
            leads.email,
            leads.telefone,
            leads.projeto_origem,
            leads.data_cadastro,
            projetos.nome_projeto
        FROM leads
        INNER JOIN projetos
            ON projetos.id = leads.projeto_id
        WHERE projetos.usuario_id = :usuario_id
        ORDER BY leads.data_cadastro DESC
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':usuario_id' => $usuario_id
    ]);

    $leads = $stmt->fetchAll();

    $total_leads = count($leads);

} catch (PDOException $e) {

    $leads = [];
    $total_leads = 0;

    $erro_banco = 'Não foi possível carregar os leads.';
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

    <title>Leads | Meu Negócio Web</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #0f172a;
            color: #f8fafc;
            min-height: 100vh;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        header {
            background: #1e293b;
            border-bottom: 1px solid #334155;
            padding: 18px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #38bdf8;
            text-decoration: none;
        }

        .usuario-area {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .usuario-nome {
            color: #cbd5e1;
            font-size: 14px;
        }

        .btn-voltar {
            text-decoration: none;
            color: #f8fafc;
            background: #334155;
            border: 1px solid #475569;
            padding: 9px 15px;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.2s;
        }

        .btn-voltar:hover {
            background: #475569;
        }


        /* =====================================================
           CONTAINER
        ===================================================== */

        .container {
            width: 100%;
            max-width: 1250px;
            margin: 0 auto;
            padding: 35px 25px 60px;
        }


        /* =====================================================
           TOPO
        ===================================================== */

        .topo-pagina {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .titulo-area h1 {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .titulo-area p {
            color: #94a3b8;
            font-size: 15px;
        }


        /* =====================================================
           CARD TOTAL
        ===================================================== */

        .card-total {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 14px;
            padding: 18px 24px;
            min-width: 150px;
            text-align: center;
        }

        .card-total span {
            display: block;
            color: #94a3b8;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .card-total strong {
            display: block;
            font-size: 30px;
            color: #38bdf8;
        }


        /* =====================================================
           ALERTAS
        ===================================================== */

        .mensagem {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .mensagem-sucesso {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.35);
            color: #86efac;
        }

        .mensagem-erro {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #fca5a5;
        }


        /* =====================================================
           TABELA
        ===================================================== */

        .tabela-container {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 14px;
            overflow: hidden;
        }

        .tabela-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        thead {
            background: #172033;
        }

        th {
            text-align: left;
            padding: 17px 18px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 600;
            border-bottom: 1px solid #334155;
            white-space: nowrap;
        }

        td {
            padding: 17px 18px;
            border-bottom: 1px solid #334155;
            color: #e2e8f0;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr {
            transition: 0.2s;
        }

        tbody tr:hover {
            background: #243247;
        }

        .nome-lead {
            font-weight: bold;
            color: #f8fafc;
        }

        .email-lead {
            color: #cbd5e1;
        }

        .telefone-lead {
            color: #cbd5e1;
            white-space: nowrap;
        }

        .projeto {
            color: #38bdf8;
        }

        .data {
            color: #94a3b8;
            white-space: nowrap;
        }


        /* =====================================================
           AÇÕES
        ===================================================== */

        .acoes {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-whatsapp,
        .btn-excluir {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 7px;
            padding: 8px 11px;
            font-size: 12px;
            font-weight: bold;
            transition: 0.2s;
            border: 1px solid transparent;
        }

        .btn-whatsapp {
            background: rgba(34, 197, 94, 0.12);
            border-color: rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        .btn-whatsapp:hover {
            background: rgba(34, 197, 94, 0.22);
        }

        .btn-excluir {
            background: rgba(239, 68, 68, 0.12);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .btn-excluir:hover {
            background: rgba(239, 68, 68, 0.22);
        }


        /* =====================================================
           ESTADO VAZIO
        ===================================================== */

        .estado-vazio {
            text-align: center;
            padding: 70px 30px;
        }

        .icone-vazio {
            font-size: 50px;
            margin-bottom: 20px;
        }

        .estado-vazio h2 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .estado-vazio p {
            color: #94a3b8;
            max-width: 500px;
            margin: 0 auto;
            line-height: 1.6;
        }


        /* =====================================================
           RODAPÉ
        ===================================================== */

        footer {
            text-align: center;
            color: #64748b;
            font-size: 13px;
            padding: 30px 20px;
        }


        /* =====================================================
           RESPONSIVO
        ===================================================== */

        @media (max-width: 700px) {

            header {
                padding: 16px 18px;
            }

            .usuario-nome {
                display: none;
            }

            .container {
                padding: 25px 15px 50px;
            }

            .topo-pagina {
                flex-direction: column;
                align-items: stretch;
            }

            .titulo-area h1 {
                font-size: 27px;
            }

            .card-total {
                width: 100%;
            }

        }

    </style>

</head>

<body>


<!-- =========================================================
     HEADER
========================================================= -->

<header>

    <a href="dashboard.php" class="logo">
        Meu Negócio Web
    </a>

    <div class="usuario-area">

        <span class="usuario-nome">
            Olá, <?= htmlspecialchars($nome_usuario) ?>
        </span>

        <a href="dashboard.php" class="btn-voltar">
            ← Dashboard
        </a>

    </div>

</header>


<!-- =========================================================
     CONTEÚDO
========================================================= -->

<main class="container">


    <!-- =====================================================
         TÍTULO
    ====================================================== -->

    <div class="topo-pagina">

        <div class="titulo-area">

            <h1>Leads</h1>

            <p>
                Pessoas que entraram em contato através dos seus projetos.
            </p>

        </div>


        <div class="card-total">

            <span>Total de leads</span>

            <strong>
                <?= $total_leads ?>
            </strong>

        </div>

    </div>


    <!-- =====================================================
         MENSAGENS
    ====================================================== -->

    <?php if (isset($_GET['excluido']) && $_GET['excluido'] === 'sucesso'): ?>

        <div class="mensagem mensagem-sucesso">
            Lead excluído com sucesso.
        </div>

    <?php endif; ?>


    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'exclusao'): ?>

        <div class="mensagem mensagem-erro">
            Não foi possível excluir o lead. Tente novamente.
        </div>

    <?php endif; ?>


    <?php if (isset($erro_banco)): ?>

        <div class="mensagem mensagem-erro">
            <?= htmlspecialchars($erro_banco) ?>
        </div>

    <?php endif; ?>


    <!-- =====================================================
         LISTA DE LEADS
    ====================================================== -->

    <div class="tabela-container">

        <?php if (empty($leads)): ?>

            <div class="estado-vazio">

                <div class="icone-vazio">
                    📭
                </div>

                <h2>
                    Nenhum lead ainda
                </h2>

                <p>
                    Quando alguém preencher o formulário de contato
                    em um dos seus projetos, os dados aparecerão aqui.
                </p>

            </div>

        <?php else: ?>

            <div class="tabela-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Nome
                            </th>

                            <th>
                                E-mail
                            </th>

                            <th>
                                Telefone
                            </th>

                            <th>
                                Projeto
                            </th>

                            <th>
                                Data
                            </th>

                            <th>
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach ($leads as $lead): ?>

                            <?php

                            // =================================================
                            // FORMATA TELEFONE PARA WHATSAPP
                            // =================================================

                            $telefone_whatsapp = preg_replace(
                                '/[^0-9]/',
                                '',
                                $lead['telefone']
                            );

                            // Se o telefone não tiver código do Brasil,
                            // adiciona 55.
                            if (
                                strlen($telefone_whatsapp) >= 10 &&
                                substr($telefone_whatsapp, 0, 2) !== '55'
                            ) {
                                $telefone_whatsapp = '55' . $telefone_whatsapp;
                            }

                            $mensagem_whatsapp =
                                'Olá ' .
                                $lead['nome'] .
                                ', recebemos seu contato através do projeto ' .
                                $lead['nome_projeto'] .
                                '.';

                            $link_whatsapp =
                                'https://wa.me/' .
                                $telefone_whatsapp .
                                '?text=' .
                                urlencode($mensagem_whatsapp);

                            ?>


                            <tr>

                                <!-- NOME -->

                                <td>

                                    <div class="nome-lead">
                                        <?= htmlspecialchars($lead['nome']) ?>
                                    </div>

                                </td>


                                <!-- E-MAIL -->

                                <td>

                                    <div class="email-lead">
                                        <?= htmlspecialchars($lead['email']) ?>
                                    </div>

                                </td>


                                <!-- TELEFONE -->

                                <td>

                                    <div class="telefone-lead">
                                        <?= htmlspecialchars($lead['telefone']) ?>
                                    </div>

                                </td>


                                <!-- PROJETO -->

                                <td>

                                    <div class="projeto">

                                        <?= htmlspecialchars(
                                            $lead['nome_projeto']
                                        ) ?>

                                    </div>

                                </td>


                                <!-- DATA -->

                                <td>

                                    <div class="data">

                                        <?php

                                        if (!empty($lead['data_cadastro'])) {

                                            echo date(
                                                'd/m/Y H:i',
                                                strtotime($lead['data_cadastro'])
                                            );

                                        }

                                        ?>

                                    </div>

                                </td>


                                <!-- AÇÕES -->

                                <td>

                                    <div class="acoes">


                                        <!-- WHATSAPP -->

                                        <?php if (!empty($telefone_whatsapp)): ?>

                                            <a
                                                href="<?= htmlspecialchars($link_whatsapp) ?>"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="btn-whatsapp"
                                            >
                                                WhatsApp
                                            </a>

                                        <?php endif; ?>


                                        <!-- EXCLUIR -->

                                        <a
                                            href="excluir_lead.php?id=<?= (int) $lead['id'] ?>"
                                            class="btn-excluir"
                                            onclick="return confirm('Tem certeza que deseja excluir este lead? Esta ação não poderá ser desfeita.');"
                                        >
                                            Excluir
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</main>


<!-- =========================================================
     FOOTER
========================================================= -->

<footer>

    Meu Negócio Web © <?= date('Y') ?>

</footer>


</body>

</html>