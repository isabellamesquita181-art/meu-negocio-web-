<?php

require_once 'config/database.php';


// ======================================================
// VERIFICA ID DO PROJETO
// ======================================================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Projeto não informado.");
}

$projeto_id = (int) $_GET['id'];


// ======================================================
// BUSCA O PROJETO
// ======================================================

try {

    $sql = "SELECT *
            FROM projetos
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => $projeto_id
    ]);

    $projeto = $stmt->fetch();

    if (!$projeto) {
        die("Projeto não encontrado.");
    }

} catch (PDOException $e) {

    die("Erro ao carregar o projeto: " . $e->getMessage());

}


// ======================================================
// CADASTRO DE LEAD
// ======================================================

$mensagem_lead = '';
$erro_lead = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome_lead = trim($_POST['nome'] ?? '');
    $email_lead = trim($_POST['email'] ?? '');
    $telefone_lead = trim($_POST['telefone'] ?? '');

    if ($nome_lead === '' || $email_lead === '' || $telefone_lead === '') {
        $erro_lead = 'Preencha todos os campos para enviar seus dados.';
    } elseif (!filter_var($email_lead, FILTER_VALIDATE_EMAIL)) {
        $erro_lead = 'Digite um e-mail válido.';
    } elseif (mb_strlen($nome_lead) > 100) {
        $erro_lead = 'O nome deve ter no máximo 100 caracteres.';
    } elseif (mb_strlen($email_lead) > 100) {
        $erro_lead = 'O e-mail deve ter no máximo 100 caracteres.';
    } elseif (mb_strlen($telefone_lead) > 20) {
        $erro_lead = 'O telefone deve ter no máximo 20 caracteres.';
    } else {
        try {
            $stmt_lead = $pdo->prepare(
                "INSERT INTO leads
                (projeto_id, nome, email, telefone, projeto_origem)
                VALUES
                (:projeto_id, :nome, :email, :telefone, :projeto_origem)"
            );

            $stmt_lead->execute([
                ':projeto_id' => $projeto_id,
                ':nome' => $nome_lead,
                ':email' => $email_lead,
                ':telefone' => $telefone_lead,
                ':projeto_origem' => $projeto['nome_projeto'] ?? 'Meu Negócio'
            ]);

            $mensagem_lead = 'Mensagem enviada com sucesso! Entraremos em contato com você.';
            $nome_lead = '';
            $email_lead = '';
            $telefone_lead = '';

        } catch (PDOException $e) {
            $erro_lead = 'Não foi possível enviar seus dados. Tente novamente.';
        }
    }
}


// ======================================================
// INCREMENTA VISITAS
// ======================================================

try {

    $sql = "UPDATE projetos
            SET visitas = COALESCE(visitas, 0) + 1
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => $projeto_id
    ]);

} catch (PDOException $e) {

    // Se houver erro nas visitas, o site continua funcionando.
}


// ======================================================
// DADOS DO PROJETO
// ======================================================

$nome = $projeto['nome_projeto'] ?? 'Meu Negócio';

$slogan = $projeto['slogan_projeto'] ?? '';

$descricao = $projeto['descricao_projeto'] ?? '';

$imagem = $projeto['imagem_hero'] ?? '';

$telefone = $projeto['telefone'] ?? '';

$instagram = $projeto['instagram'] ?? '';


// Cards

$card1_titulo = $projeto['card1_titulo'] ?? '';

$card1_desc = $projeto['card1_desc'] ?? '';

$card2_titulo = $projeto['card2_titulo'] ?? '';

$card2_desc = $projeto['card2_desc'] ?? '';

$card3_titulo = $projeto['card3_titulo'] ?? '';

$card3_desc = $projeto['card3_desc'] ?? '';


// ======================================================
// WHATSAPP
// ======================================================

// Remove tudo que não for número
$numero_whatsapp = preg_replace('/\D/', '', $telefone);


// Adiciona código do Brasil se necessário
if ($numero_whatsapp !== '' && strlen($numero_whatsapp) <= 11) {
    $numero_whatsapp = '55' . $numero_whatsapp;
}


// Link do WhatsApp

$link_whatsapp = '';

if ($numero_whatsapp !== '') {

    $mensagem_whatsapp = "Olá! Vim pelo site " . $nome;

    $link_whatsapp =
        "https://wa.me/" .
        $numero_whatsapp .
        "?text=" .
        urlencode($mensagem_whatsapp);
}


// ======================================================
// INSTAGRAM
// ======================================================

$link_instagram = '';

if ($instagram !== '') {

    $instagram_limpo = trim($instagram);


    // Se já for um link
    if (
        strpos($instagram_limpo, 'http://') === 0 ||
        strpos($instagram_limpo, 'https://') === 0
    ) {

        $link_instagram = $instagram_limpo;

    } else {

        // Remove @
        $instagram_limpo = ltrim($instagram_limpo, '@');

        $link_instagram =
            'https://instagram.com/' .
            $instagram_limpo;
    }
}

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($nome) ?></title>


<style>

* {
    box-sizing: border-box;
}


html {
    scroll-behavior: smooth;
}


body {

    margin: 0;

    font-family: Arial, Helvetica, sans-serif;

    background: #0b0b0f;

    color: #ffffff;

    line-height: 1.6;

}


/* =====================================================
   BARRA DE DEMONSTRAÇÃO
===================================================== */

.demo-bar {

    position: sticky;

    top: 0;

    z-index: 1000;

    background: #15151c;

    border-bottom: 1px solid #292933;

    padding: 10px 20px;

    text-align: center;

    font-size: 13px;

    color: #aaaaaa;

}


.demo-bar strong {
    color: #ff3b30;
}


/* =====================================================
   HERO
===================================================== */

.hero {

    min-height: 620px;

    display: flex;

    align-items: center;

    justify-content: center;

    position: relative;

    overflow: hidden;

    background: #111116;

}


.hero::before {

    content: "";

    position: absolute;

    inset: 0;

    background:
        radial-gradient(
            circle at center,
            rgba(255, 59, 48, 0.15),
            transparent 55%
        );

}


.hero-conteudo {

    position: relative;

    z-index: 2;

    width: 90%;

    max-width: 1100px;

    margin: auto;

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 60px;

    align-items: center;

}


.hero-texto h1 {

    font-size: clamp(40px, 6vw, 72px);

    line-height: 1.05;

    margin: 0 0 20px;

}


.hero-texto h1 span {

    color: #ff3b30;

}


.hero-texto p {

    font-size: 20px;

    color: #c5c5cc;

    max-width: 550px;

}


.hero-imagem {

    display: flex;

    justify-content: center;

}


.hero-imagem img {

    width: 100%;

    max-width: 500px;

    max-height: 420px;

    object-fit: cover;

    border-radius: 20px;

    border: 1px solid #33333d;

}


.sem-imagem {

    width: 100%;

    max-width: 500px;

    height: 350px;

    border-radius: 20px;

    background: #18181f;

    border: 1px solid #30303a;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #777782;

}


/* =====================================================
   BOTÕES
===================================================== */

.botoes {

    display: flex;

    gap: 12px;

    flex-wrap: wrap;

    margin-top: 30px;

}


.botao {

    display: inline-block;

    padding: 14px 22px;

    border-radius: 9px;

    text-decoration: none;

    font-weight: bold;

    transition: 0.2s;

}


.botao-principal {

    background: #ff3b30;

    color: white;

}


.botao-principal:hover {

    background: #e32e25;

    transform: translateY(-2px);

}


.botao-secundario {

    background: #25252e;

    color: white;

    border: 1px solid #383842;

}


.botao-secundario:hover {

    background: #32323d;

}


/* =====================================================
   SEÇÕES
===================================================== */

.secao {

    padding: 90px 20px;

}


.container {

    width: 90%;

    max-width: 1100px;

    margin: auto;

}


.secao-titulo {

    text-align: center;

    margin-bottom: 50px;

}


.secao-titulo h2 {

    font-size: 38px;

    margin: 0 0 12px;

}


.secao-titulo p {

    color: #9999a4;

    margin: 0;

}


/* =====================================================
   SOBRE
===================================================== */

.sobre {

    background: #101016;

}


.sobre-texto {

    max-width: 800px;

    margin: auto;

    text-align: center;

    color: #c8c8d0;

    font-size: 18px;

}


/* =====================================================
   CARDS
===================================================== */

.cards {

    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 20px;

}


.card {

    background: #15151c;

    border: 1px solid #292933;

    border-radius: 16px;

    padding: 30px;

    transition: 0.2s;

}


.card:hover {

    transform: translateY(-5px);

    border-color: #ff3b30;

}


.card-numero {

    color: #ff3b30;

    font-size: 14px;

    font-weight: bold;

}


.card h3 {

    margin: 12px 0;

    font-size: 22px;

}


.card p {

    color: #9999a4;

    margin: 0;

}


/* =====================================================
   CONTATO
===================================================== */

.contato {

    background: #15151c;

    text-align: center;

}


.contato-botoes {

    display: flex;

    justify-content: center;

    gap: 15px;

    flex-wrap: wrap;

}


.botao-whatsapp {

    background: #25D366;

    color: #ffffff;

}


.botao-whatsapp:hover {

    filter: brightness(0.9);

}


.botao-instagram {

    background: #833AB4;

    color: #ffffff;

}


.botao-instagram:hover {

    filter: brightness(0.9);

}


/* =====================================================
   FORMULÁRIO DE CONTATO
===================================================== */

.formulario-contato {
    max-width: 650px;
    margin: 35px auto 0;
    padding: 30px;
    background: #101016;
    border: 1px solid #292933;
    border-radius: 16px;
    text-align: left;
}

.formulario-contato h3 {
    margin: 0 0 8px;
    font-size: 24px;
}

.formulario-contato .subtitulo-formulario {
    margin: 0 0 25px;
    color: #9999a4;
}

.campo-formulario {
    margin-bottom: 18px;
}

.campo-formulario label {
    display: block;
    margin-bottom: 7px;
    font-weight: bold;
}

.campo-formulario input {
    width: 100%;
    padding: 13px 14px;
    border-radius: 9px;
    border: 1px solid #383842;
    background: #18181f;
    color: #ffffff;
    font-size: 16px;
    outline: none;
}

.campo-formulario input:focus {
    border-color: #ff3b30;
}

.mensagem-sucesso,
.mensagem-erro {
    padding: 13px 15px;
    border-radius: 9px;
    margin-bottom: 20px;
}

.mensagem-sucesso {
    background: rgba(37, 211, 102, 0.12);
    border: 1px solid rgba(37, 211, 102, 0.35);
    color: #8ff0b5;
}

.mensagem-erro {
    background: rgba(255, 59, 48, 0.12);
    border: 1px solid rgba(255, 59, 48, 0.35);
    color: #ffaaa5;
}


/* =====================================================
   RODAPÉ
===================================================== */

footer {

    padding: 35px 20px;

    text-align: center;

    background: #09090d;

    color: #777782;

    border-top: 1px solid #202028;

}


footer strong {

    color: #ffffff;

}


/* =====================================================
   RESPONSIVO
===================================================== */

@media (max-width: 800px) {


    .hero {

        min-height: auto;

        padding: 70px 0;

    }


    .hero-conteudo {

        grid-template-columns: 1fr;

        gap: 40px;

    }


    .hero-texto {

        text-align: center;

    }


    .hero-texto p {

        margin-left: auto;

        margin-right: auto;

    }


    .botoes {

        justify-content: center;

    }


    .cards {

        grid-template-columns: 1fr;

    }


    .secao {

        padding: 65px 20px;

    }

}

</style>

</head>


<body>


<!-- =====================================================
     BARRA DE DEMONSTRAÇÃO
===================================================== -->

<div class="demo-bar">

    Você está visualizando o site de demonstração de

    <strong>
        <?= htmlspecialchars($nome) ?>
    </strong>

</div>


<!-- =====================================================
     HERO
===================================================== -->

<section class="hero">

    <div class="hero-conteudo">


        <div class="hero-texto">

            <h1>

                <?= htmlspecialchars($nome) ?>

                <?php if ($slogan !== ''): ?>

                    <br>

                    <span>
                        <?= htmlspecialchars($slogan) ?>
                    </span>

                <?php endif; ?>

            </h1>


            <?php if ($descricao !== ''): ?>

                <p>
                    <?= nl2br(htmlspecialchars($descricao)) ?>
                </p>

            <?php endif; ?>


            <div class="botoes">


                <?php if ($link_whatsapp !== ''): ?>

                    <a
                        href="<?= htmlspecialchars($link_whatsapp) ?>"
                        target="_blank"
                        class="botao botao-principal"
                    >
                        📱 Falar pelo WhatsApp
                    </a>

                <?php endif; ?>


                <?php if ($link_instagram !== ''): ?>

                    <a
                        href="<?= htmlspecialchars($link_instagram) ?>"
                        target="_blank"
                        class="botao botao-secundario"
                    >
                        📸 Instagram
                    </a>

                <?php endif; ?>


            </div>

        </div>


        <div class="hero-imagem">

            <?php if ($imagem !== ''): ?>

                <img
                    src="<?= htmlspecialchars($imagem) ?>"
                    alt="<?= htmlspecialchars($nome) ?>"
                >

            <?php else: ?>

                <div class="sem-imagem">
                    Imagem do negócio
                </div>

            <?php endif; ?>

        </div>


    </div>

</section>


<!-- =====================================================
     SOBRE
===================================================== -->

<section class="secao sobre">

    <div class="container">


        <div class="secao-titulo">

            <h2>
                Sobre o negócio
            </h2>

            <p>
                Conheça um pouco mais
            </p>

        </div>


        <div class="sobre-texto">

            <?php if ($descricao !== ''): ?>

                <p>
                    <?= nl2br(htmlspecialchars($descricao)) ?>
                </p>

            <?php else: ?>

                <p>
                    Bem-vindo ao nosso negócio!
                </p>

            <?php endif; ?>

        </div>


    </div>

</section>


<!-- =====================================================
     DESTAQUES
===================================================== -->

<section class="secao">

    <div class="container">


        <div class="secao-titulo">

            <h2>
                Nossos destaques
            </h2>

            <p>
                Conheça o que temos para oferecer
            </p>

        </div>


        <div class="cards">


            <!-- CARD 1 -->

            <div class="card">

                <span class="card-numero">
                    01
                </span>


                <h3>

                    <?= htmlspecialchars(
                        $card1_titulo !== ''
                            ? $card1_titulo
                            : 'Qualidade'
                    ) ?>

                </h3>


                <p>

                    <?= nl2br(htmlspecialchars(
                        $card1_desc !== ''
                            ? $card1_desc
                            : 'Produtos e serviços feitos com atenção aos detalhes.'
                    )) ?>

                </p>

            </div>


            <!-- CARD 2 -->

            <div class="card">

                <span class="card-numero">
                    02
                </span>


                <h3>

                    <?= htmlspecialchars(
                        $card2_titulo !== ''
                            ? $card2_titulo
                            : 'Atendimento'
                    ) ?>

                </h3>


                <p>

                    <?= nl2br(htmlspecialchars(
                        $card2_desc !== ''
                            ? $card2_desc
                            : 'Atendimento pensado para oferecer uma ótima experiência.'
                    )) ?>

                </p>

            </div>


            <!-- CARD 3 -->

            <div class="card">

                <span class="card-numero">
                    03
                </span>


                <h3>

                    <?= htmlspecialchars(
                        $card3_titulo !== ''
                            ? $card3_titulo
                            : 'Confiança'
                    ) ?>

                </h3>


                <p>

                    <?= nl2br(htmlspecialchars(
                        $card3_desc !== ''
                            ? $card3_desc
                            : 'Um negócio preparado para atender você.'
                    )) ?>

                </p>

            </div>


        </div>

    </div>

</section>


<!-- =====================================================
     CONTATO
===================================================== -->

<section class="secao contato">

    <div class="container">


        <div class="secao-titulo">

            <h2>
                Entre em contato
            </h2>

            <p>
                Estamos prontos para atender você.
            </p>

        </div>


        <div class="contato-botoes">


            <?php if ($link_whatsapp !== ''): ?>

                <a
                    href="<?= htmlspecialchars($link_whatsapp) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="botao botao-whatsapp"
                >
                    📱 WhatsApp
                </a>

            <?php endif; ?>


            <?php if ($link_instagram !== ''): ?>

                <a
                    href="<?= htmlspecialchars($link_instagram) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="botao botao-instagram"
                >
                    📸 Instagram
                </a>

            <?php endif; ?>


        </div>


        <div class="formulario-contato">

            <h3>Entre em contato</h3>

            <p class="subtitulo-formulario">
                Deixe seus dados e o responsável pelo negócio poderá entrar em contato com você.
            </p>

            <?php if ($mensagem_lead !== ''): ?>
                <div class="mensagem-sucesso">
                    <?= htmlspecialchars($mensagem_lead) ?>
                </div>
            <?php endif; ?>

            <?php if ($erro_lead !== ''): ?>
                <div class="mensagem-erro">
                    <?= htmlspecialchars($erro_lead) ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="campo-formulario">
                    <label for="nome">Nome</label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        maxlength="100"
                        value="<?= htmlspecialchars($nome_lead ?? '') ?>"
                        required
                    >
                </div>

                <div class="campo-formulario">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        maxlength="100"
                        value="<?= htmlspecialchars($email_lead ?? '') ?>"
                        required
                    >
                </div>

                <div class="campo-formulario">
                    <label for="telefone">Telefone / WhatsApp</label>
                    <input
                        type="tel"
                        id="telefone"
                        name="telefone"
                        maxlength="20"
                        value="<?= htmlspecialchars($telefone_lead ?? '') ?>"
                        required
                    >
                </div>

                <button
                    type="submit"
                    class="botao botao-principal"
                    style="border: 0; cursor: pointer;"
                >
                    Enviar meus dados
                </button>

            </form>

        </div>


    </div>

</section>


<!-- =====================================================
     RODAPÉ
===================================================== -->

<footer>

    <p>

        <strong>
            <?= htmlspecialchars($nome) ?>
        </strong>

        <br>

        Site criado com Meu Negócio Web.

    </p>

</footer>


</body>

</html>