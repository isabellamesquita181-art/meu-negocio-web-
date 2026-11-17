<?php

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once 'config/database.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Verifica o ID do projeto
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$projeto_id = (int) $_GET['id'];

$mensagem = '';
$erro = '';


// ======================================================
// BUSCAR PROJETO
// ======================================================

try {

    $sql = "SELECT *
            FROM projetos
            WHERE id = :id
            AND usuario_id = :usuario_id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => $projeto_id,
        ':usuario_id' => $usuario_id
    ]);

    $projeto = $stmt->fetch();

    if (!$projeto) {
        die("Projeto não encontrado ou você não tem permissão para editá-lo.");
    }

} catch (PDOException $e) {

    die("Erro ao buscar projeto: " . $e->getMessage());

}


// ======================================================
// SALVAR ALTERAÇÕES
// ======================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $csrf_token = $_POST['csrf_token'] ?? '';

    if (
        empty($csrf_token) ||
        !hash_equals($_SESSION['csrf_token'], $csrf_token)
    ) {
        die('Token de segurança inválido. Recarregue a página e tente novamente.');
    }

    $nome_projeto = trim($_POST['nome_projeto'] ?? '');
    $url_projeto = trim($_POST['url_projeto'] ?? '');
    $status_projeto = trim($_POST['status_projeto'] ?? 'rascunho');

    $slogan_projeto = trim($_POST['slogan_projeto'] ?? '');
    $descricao_projeto = trim($_POST['descricao_projeto'] ?? '');

    $telefone = trim($_POST['telefone'] ?? '');
    $instagram = trim($_POST['instagram'] ?? '');

    $card1_titulo = trim($_POST['card1_titulo'] ?? '');
    $card1_desc = trim($_POST['card1_desc'] ?? '');

    $card2_titulo = trim($_POST['card2_titulo'] ?? '');
    $card2_desc = trim($_POST['card2_desc'] ?? '');

    $card3_titulo = trim($_POST['card3_titulo'] ?? '');
    $card3_desc = trim($_POST['card3_desc'] ?? '');

    $imagem_enviada = null;


    // ==================================================
    // VALIDAÇÕES
    // ==================================================

    if ($nome_projeto === '') {

        $erro = "Digite o nome do projeto.";

    } elseif ($url_projeto === '') {

        $erro = "Digite a URL do projeto.";

    }


    // ==================================================
    // UPLOAD DA IMAGEM
    // ==================================================

    if (
        $erro === '' &&
        isset($_FILES['imagem_arquivo']) &&
        $_FILES['imagem_arquivo']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        if ($_FILES['imagem_arquivo']['error'] !== UPLOAD_ERR_OK) {

            $erro = "Erro ao enviar a imagem.";

        } else {

            $arquivo = $_FILES['imagem_arquivo'];

            // Limite de 5 MB
            if ($arquivo['size'] > 5 * 1024 * 1024) {

                $erro = "A imagem deve ter no máximo 5 MB.";

            } else {

                // Verifica o tipo real da imagem
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $tipo = finfo_file($finfo, $arquivo['tmp_name']);
                finfo_close($finfo);

                $tipos_permitidos = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp'
                ];

                if (!isset($tipos_permitidos[$tipo])) {

                    $erro = "Formato de imagem inválido. Use JPG, PNG ou WEBP.";

                } else {

                    $extensao = $tipos_permitidos[$tipo];

                    $pasta_upload = __DIR__ . '/uploads/';


                    // Cria a pasta caso não exista
                    if (!is_dir($pasta_upload)) {

                        mkdir($pasta_upload, 0755, true);

                    }


                    // Nome único para o arquivo
                    $nome_arquivo =
                        'projeto_' .
                        $projeto_id .
                        '_' .
                        uniqid() .
                        '.' .
                        $extensao;


                    $caminho_fisico = $pasta_upload . $nome_arquivo;

                    $caminho_banco = 'uploads/' . $nome_arquivo;


                    if (move_uploaded_file(
                        $arquivo['tmp_name'],
                        $caminho_fisico
                    )) {

                        $imagem_enviada = $caminho_banco;

                    } else {

                        $erro = "Não foi possível salvar a imagem.";

                    }
                }
            }
        }
    }


    // ==================================================
    // ATUALIZAR BANCO
    // ==================================================

    if ($erro === '') {

        try {

            if ($imagem_enviada !== null) {

                $sql = "UPDATE projetos SET

                        nome_projeto = :nome_projeto,
                        url_projeto = :url_projeto,
                        status_projeto = :status_projeto,
                        slogan_projeto = :slogan_projeto,
                        descricao_projeto = :descricao_projeto,
                        imagem_hero = :imagem_hero,
                        telefone = :telefone,
                        instagram = :instagram,
                        card1_titulo = :card1_titulo,
                        card1_desc = :card1_desc,
                        card2_titulo = :card2_titulo,
                        card2_desc = :card2_desc,
                        card3_titulo = :card3_titulo,
                        card3_desc = :card3_desc

                        WHERE id = :id
                        AND usuario_id = :usuario_id";


                $stmt = $pdo->prepare($sql);

                $stmt->execute([

                    ':nome_projeto' => $nome_projeto,
                    ':url_projeto' => $url_projeto,
                    ':status_projeto' => $status_projeto,
                    ':slogan_projeto' => $slogan_projeto,
                    ':descricao_projeto' => $descricao_projeto,
                    ':imagem_hero' => $imagem_enviada,
                    ':telefone' => $telefone,
                    ':instagram' => $instagram,

                    ':card1_titulo' => $card1_titulo,
                    ':card1_desc' => $card1_desc,

                    ':card2_titulo' => $card2_titulo,
                    ':card2_desc' => $card2_desc,

                    ':card3_titulo' => $card3_titulo,
                    ':card3_desc' => $card3_desc,

                    ':id' => $projeto_id,
                    ':usuario_id' => $usuario_id

                ]);

            } else {

                $sql = "UPDATE projetos SET

                        nome_projeto = :nome_projeto,
                        url_projeto = :url_projeto,
                        status_projeto = :status_projeto,
                        slogan_projeto = :slogan_projeto,
                        descricao_projeto = :descricao_projeto,
                        telefone = :telefone,
                        instagram = :instagram,
                        card1_titulo = :card1_titulo,
                        card1_desc = :card1_desc,
                        card2_titulo = :card2_titulo,
                        card2_desc = :card2_desc,
                        card3_titulo = :card3_titulo,
                        card3_desc = :card3_desc

                        WHERE id = :id
                        AND usuario_id = :usuario_id";


                $stmt = $pdo->prepare($sql);

                $stmt->execute([

                    ':nome_projeto' => $nome_projeto,
                    ':url_projeto' => $url_projeto,
                    ':status_projeto' => $status_projeto,
                    ':slogan_projeto' => $slogan_projeto,
                    ':descricao_projeto' => $descricao_projeto,
                    ':telefone' => $telefone,
                    ':instagram' => $instagram,

                    ':card1_titulo' => $card1_titulo,
                    ':card1_desc' => $card1_desc,

                    ':card2_titulo' => $card2_titulo,
                    ':card2_desc' => $card2_desc,

                    ':card3_titulo' => $card3_titulo,
                    ':card3_desc' => $card3_desc,

                    ':id' => $projeto_id,
                    ':usuario_id' => $usuario_id

                ]);
            }


            $mensagem = "Alterações salvas com sucesso!";


            // Busca os dados novamente
            $sql = "SELECT *
                    FROM projetos
                    WHERE id = :id
                    AND usuario_id = :usuario_id";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id' => $projeto_id,
                ':usuario_id' => $usuario_id
            ]);

            $projeto = $stmt->fetch();


        } catch (PDOException $e) {

            $erro = "Erro ao salvar as alterações: " . $e->getMessage();

        }
    }
}

?>


<!DOCTYPE html>

<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Editar Projeto - Meu Negócio Web</title>


<style>

* {
    box-sizing: border-box;
}

body {

    margin: 0;

    font-family: Arial, Helvetica, sans-serif;

    background: #0b0b0f;

    color: #ffffff;
}


.container {

    width: 90%;

    max-width: 1000px;

    margin: 40px auto;

}


.topo {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 30px;

}


.topo h1 {

    margin: 0;

    font-size: 30px;

}


.voltar {

    color: #ffffff;

    text-decoration: none;

    background: #1d1d25;

    padding: 12px 18px;

    border-radius: 8px;

}


.voltar:hover {

    background: #292933;

}


.card {

    background: #15151c;

    border: 1px solid #292933;

    border-radius: 14px;

    padding: 25px;

    margin-bottom: 25px;

}


.card h2 {

    margin-top: 0;

    margin-bottom: 20px;

    font-size: 20px;

}


.campo {

    margin-bottom: 18px;

}


label {

    display: block;

    margin-bottom: 8px;

    font-weight: bold;

    color: #dddddd;

}


input,
textarea,
select {

    width: 100%;

    padding: 13px;

    background: #0d0d12;

    color: #ffffff;

    border: 1px solid #353541;

    border-radius: 8px;

    outline: none;

    font-size: 15px;

}


input:focus,
textarea:focus,
select:focus {

    border-color: #ff3b30;

}


textarea {

    min-height: 120px;

    resize: vertical;

}


.ajuda {

    color: #888894;

    font-size: 13px;

    margin-top: 6px;

}


.grid {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 20px;

}


.imagem-atual {

    margin-top: 15px;

}


.imagem-atual img {

    max-width: 350px;

    max-height: 220px;

    object-fit: cover;

    border-radius: 10px;

    border: 1px solid #33333d;

}


.mensagem {

    background: #12351e;

    border: 1px solid #236c3a;

    color: #7ff09c;

    padding: 15px;

    border-radius: 8px;

    margin-bottom: 20px;

}


.erro {

    background: #3a1515;

    border: 1px solid #7a2929;

    color: #ff8c8c;

    padding: 15px;

    border-radius: 8px;

    margin-bottom: 20px;

}


.botoes {

    display: flex;

    gap: 12px;

    margin-top: 25px;

    flex-wrap: wrap;

}


button,
.botao-visualizar {

    border: none;

    padding: 14px 22px;

    border-radius: 8px;

    font-size: 15px;

    font-weight: bold;

    cursor: pointer;

    text-decoration: none;

}


button {

    background: #ff3b30;

    color: #ffffff;

}


button:hover {

    background: #e32e25;

}


.botao-visualizar {

    background: #25252e;

    color: #ffffff;

}


.botao-visualizar:hover {

    background: #33333e;

}


.card-numero {

    color: #ff3b30;

    margin-right: 5px;

}


@media (max-width: 700px) {

    .grid {

        grid-template-columns: 1fr;

    }


    .topo {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }


    .container {

        width: 94%;

    }

}

</style>

</head>


<body>


<div class="container">


    <div class="topo">

        <h1>Editar projeto</h1>

        <a href="dashboard.php" class="voltar">
            ← Voltar ao painel
        </a>

    </div>


    <?php if ($mensagem): ?>

        <div class="mensagem">

            <?= htmlspecialchars($mensagem) ?>

        </div>

    <?php endif; ?>


    <?php if ($erro): ?>

        <div class="erro">

            <?= htmlspecialchars($erro) ?>

        </div>

    <?php endif; ?>


    <form
        method="POST"
        enctype="multipart/form-data"
    >


    <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
    >

    
        <!-- ============================================== -->
        <!-- INFORMAÇÕES PRINCIPAIS -->
        <!-- ============================================== -->

        <div class="card">

            <h2>Informações do projeto</h2>


            <div class="campo">

                <label for="nome_projeto">
                    Nome do projeto
                </label>

                <input
                    type="text"
                    id="nome_projeto"
                    name="nome_projeto"
                    value="<?= htmlspecialchars($projeto['nome_projeto'] ?? '') ?>"
                    required
                >

            </div>


            <div class="grid">


                <div class="campo">

                    <label for="url_projeto">
                        URL do projeto
                    </label>

                    <input
                        type="text"
                        id="url_projeto"
                        name="url_projeto"
                        value="<?= htmlspecialchars($projeto['url_projeto'] ?? '') ?>"
                        required
                    >

                    <div class="ajuda">
                        Exemplo: doceria-da-ana
                    </div>

                </div>


                <div class="campo">

                    <label for="status_projeto">
                        Status
                    </label>

                    <select
                        id="status_projeto"
                        name="status_projeto"
                    >

                        <option
                            value="rascunho"
                            <?= (($projeto['status_projeto'] ?? '') === 'rascunho') ? 'selected' : '' ?>
                        >
                            Rascunho
                        </option>


                        <option
                            value="online"
                            <?= (($projeto['status_projeto'] ?? '') === 'online') ? 'selected' : '' ?>
                        >
                            Online
                        </option>

                    </select>

                </div>

            </div>

        </div>


        <!-- ============================================== -->
        <!-- APRESENTAÇÃO -->
        <!-- ============================================== -->

        <div class="card">

            <h2>Apresentação do site</h2>


            <div class="campo">

                <label for="slogan_projeto">
                    Slogan
                </label>

                <input
                    type="text"
                    id="slogan_projeto"
                    name="slogan_projeto"
                    value="<?= htmlspecialchars($projeto['slogan_projeto'] ?? '') ?>"
                    placeholder="Ex: Doces feitos com carinho"
                >

            </div>


            <div class="campo">

                <label for="descricao_projeto">
                    Descrição
                </label>

                <textarea
                    id="descricao_projeto"
                    name="descricao_projeto"
                    placeholder="Conte um pouco sobre o negócio..."
                ><?= htmlspecialchars($projeto['descricao_projeto'] ?? '') ?></textarea>

            </div>


            <div class="campo">

                <label for="imagem_arquivo">
                    Imagem principal
                </label>

                <input
                    type="file"
                    id="imagem_arquivo"
                    name="imagem_arquivo"
                    accept="image/jpeg,image/png,image/webp"
                >

                <div class="ajuda">
                    JPG, PNG ou WEBP — máximo 5 MB.
                </div>

            </div>


            <?php if (!empty($projeto['imagem_hero'])): ?>

                <div class="imagem-atual">

                    <p>Imagem atual:</p>

                    <img
                        src="<?= htmlspecialchars($projeto['imagem_hero']) ?>"
                        alt="Imagem atual do projeto"
                    >

                </div>

            <?php endif; ?>

        </div>


        <!-- ============================================== -->
        <!-- CONTATO -->
        <!-- ============================================== -->

        <div class="card">

            <h2>Contato e redes sociais</h2>


            <div class="grid">


                <div class="campo">

                    <label for="telefone">
                        📱 WhatsApp
                    </label>

                    <input
                        type="text"
                        id="telefone"
                        name="telefone"
                        value="<?= htmlspecialchars($projeto['telefone'] ?? '') ?>"
                        placeholder="Ex: (11) 99999-9999"
                    >

                    <div class="ajuda">
                        Número de WhatsApp do negócio.
                    </div>

                </div>


                <div class="campo">

                    <label for="instagram">
                        📸 Instagram
                    </label>

                    <input
                        type="text"
                        id="instagram"
                        name="instagram"
                        value="<?= htmlspecialchars($projeto['instagram'] ?? '') ?>"
                        placeholder="Ex: @doceriadaana"
                    >

                    <div class="ajuda">
                        Informe @usuario ou o link completo.
                    </div>

                </div>


            </div>

        </div>


        <!-- ============================================== -->
        <!-- CARD 1 -->
        <!-- ============================================== -->

        <div class="card">

            <h2>
                <span class="card-numero">01.</span>
                Primeiro destaque
            </h2>


            <div class="campo">

                <label for="card1_titulo">
                    Título
                </label>

                <input
                    type="text"
                    id="card1_titulo"
                    name="card1_titulo"
                    value="<?= htmlspecialchars($projeto['card1_titulo'] ?? '') ?>"
                    placeholder="Ex: Produtos artesanais"
                >

            </div>


            <div class="campo">

                <label for="card1_desc">
                    Descrição
                </label>

                <textarea
                    id="card1_desc"
                    name="card1_desc"
                    placeholder="Descreva esse destaque..."
                ><?= htmlspecialchars($projeto['card1_desc'] ?? '') ?></textarea>

            </div>

        </div>


        <!-- ============================================== -->
        <!-- CARD 2 -->
        <!-- ============================================== -->

        <div class="card">

            <h2>
                <span class="card-numero">02.</span>
                Segundo destaque
            </h2>


            <div class="campo">

                <label for="card2_titulo">
                    Título
                </label>

                <input
                    type="text"
                    id="card2_titulo"
                    name="card2_titulo"
                    value="<?= htmlspecialchars($projeto['card2_titulo'] ?? '') ?>"
                    placeholder="Ex: Entrega rápida"
                >

            </div>


            <div class="campo">

                <label for="card2_desc">
                    Descrição
                </label>

                <textarea
                    id="card2_desc"
                    name="card2_desc"
                    placeholder="Descreva esse destaque..."
                ><?= htmlspecialchars($projeto['card2_desc'] ?? '') ?></textarea>

            </div>

        </div>


        <!-- ============================================== -->
        <!-- CARD 3 -->
        <!-- ============================================== -->

        <div class="card">

            <h2>
                <span class="card-numero">03.</span>
                Terceiro destaque
            </h2>


            <div class="campo">

                <label for="card3_titulo">
                    Título
                </label>

                <input
                    type="text"
                    id="card3_titulo"
                    name="card3_titulo"
                    value="<?= htmlspecialchars($projeto['card3_titulo'] ?? '') ?>"
                    placeholder="Ex: Atendimento personalizado"
                >

            </div>


            <div class="campo">

                <label for="card3_desc">
                    Descrição
                </label>

                <textarea
                    id="card3_desc"
                    name="card3_desc"
                    placeholder="Descreva esse destaque..."
                ><?= htmlspecialchars($projeto['card3_desc'] ?? '') ?></textarea>

            </div>

        </div>


        <!-- ============================================== -->
        <!-- BOTÕES -->
        <!-- ============================================== -->

        <div class="botoes">

            <button type="submit">
                💾 Salvar alterações
            </button>


            <a
                href="rascunho.php?id=<?= $projeto_id ?>"
                target="_blank"
                class="botao-visualizar"
            >
                👁️ Visualizar site
            </a>

        </div>


    </form>


</div>


</body>

</html>