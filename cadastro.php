<?php

require_once 'config/database.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    // ============================
    // VALIDAÇÕES
    // ============================

    if ($nome === '' || $email === '' || $senha === '' || $confirmar_senha === '') {

        $erro = 'Preencha todos os campos.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $erro = 'Digite um e-mail válido.';

    } elseif (strlen($senha) < 6) {

        $erro = 'A senha deve ter pelo menos 6 caracteres.';

    } elseif ($senha !== $confirmar_senha) {

        $erro = 'As senhas não são iguais.';

    } else {

        try {

            // ============================
            // VERIFICA SE O E-MAIL EXISTE
            // ============================

            $sql = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':email' => $email
            ]);

            $usuario_existente = $stmt->fetch();

            if ($usuario_existente) {

                $erro = 'Este e-mail já está cadastrado.';

            } else {

                // ============================
                // CRIPTOGRAFA A SENHA
                // ============================

                $senha_hash = password_hash(
                    $senha,
                    PASSWORD_DEFAULT
                );


                // ============================
                // CADASTRA O USUÁRIO
                // ============================

                $sql = "INSERT INTO usuarios
                        (nome, email, senha)
                        VALUES
                        (:nome, :email, :senha)";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    ':nome' => $nome,
                    ':email' => $email,
                    ':senha' => $senha_hash
                ]);


                // ============================
                // REDIRECIONA PARA LOGIN
                // ============================

                header('Location: login.php?cadastro=sucesso');

                exit;
            }

        } catch (PDOException $e) {

            $erro = 'Ocorreu um erro ao criar sua conta. Tente novamente.';
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

    <title>
        Criar conta | Meu Negócio Web
    </title>


    <!-- FONTES -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- ÍCONES -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            min-height: 100vh;

            font-family: 'Inter', Arial, sans-serif;

            color: #ffffff;

            background:
                radial-gradient(
                    circle at 85% 10%,
                    rgba(102, 64, 255, 0.18),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 10% 90%,
                    rgba(0, 130, 255, 0.12),
                    transparent 30%
                ),
                #050914;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px;

            overflow-x: hidden;
        }


        /* =====================================================
           EFEITOS DE FUNDO
        ===================================================== */

        .glow {

            position: fixed;

            width: 400px;
            height: 400px;

            border-radius: 50%;

            filter: blur(120px);

            opacity: 0.15;

            pointer-events: none;

            z-index: 0;
        }


        .glow-purple {

            background: #663cff;

            top: -200px;

            right: -150px;
        }


        .glow-blue {

            background: #007bff;

            bottom: -200px;

            left: -150px;
        }


        /* =====================================================
           CONTAINER
        ===================================================== */

        .page {

            width: 100%;

            max-width: 1100px;

            min-height: 650px;

            display: grid;

            grid-template-columns: 1fr 1fr;

            position: relative;

            z-index: 2;

            border: 1px solid rgba(255,255,255,0.08);

            border-radius: 25px;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    rgba(15,23,41,0.92),
                    rgba(6,11,22,0.96)
                );

            box-shadow:
                0 30px 100px rgba(0,0,0,0.45);
        }


        /* =====================================================
           LADO ESQUERDO
        ===================================================== */

        .presentation {

            padding: 60px;

            display: flex;

            flex-direction: column;

            justify-content: center;

            position: relative;

            overflow: hidden;

            border-right: 1px solid rgba(255,255,255,0.07);

            background:
                radial-gradient(
                    circle at 80% 20%,
                    rgba(90,62,255,0.16),
                    transparent 35%
                );
        }


        .presentation::before {

            content: "";

            position: absolute;

            width: 300px;
            height: 300px;

            border-radius: 50%;

            border: 1px solid rgba(100,75,255,0.16);

            right: -130px;

            bottom: -120px;
        }


        .presentation::after {

            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            border-radius: 50%;

            border: 1px solid rgba(20,130,255,0.12);

            right: 50px;

            bottom: -80px;
        }


        /* =====================================================
           LOGO
        ===================================================== */

        .logo {

            display: flex;

            align-items: center;

            gap: 10px;

            font-size: 19px;

            font-weight: 800;

            margin-bottom: 60px;
        }


        .logo-icon {

            width: 36px;
            height: 36px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #793cff,
                    #118cff
                );

            box-shadow:
                0 0 25px rgba(99,64,255,0.4);
        }


        .logo span {

            color: #8b70ff;
        }


        /* =====================================================
           TEXTO
        ===================================================== */

        .presentation h1 {

            font-size: 43px;

            line-height: 1.08;

            letter-spacing: -2px;

            margin-bottom: 20px;
        }


        .presentation h1 span {

            display: block;

            background:
                linear-gradient(
                    90deg,
                    #168cff,
                    #7446ff
                );

            -webkit-background-clip: text;

            -webkit-text-fill-color: transparent;
        }


        .presentation-description {

            color: #909db4;

            font-size: 14px;

            line-height: 1.8;

            max-width: 430px;

            margin-bottom: 35px;
        }


        /* =====================================================
           BENEFÍCIOS
        ===================================================== */

        .mini-features {

            display: flex;

            flex-direction: column;

            gap: 14px;
        }


        .mini-feature {

            display: flex;

            align-items: center;

            gap: 12px;

            color: #9ba8bd;

            font-size: 12px;
        }


        .mini-feature-icon {

            width: 30px;
            height: 30px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 9px;

            background:
                rgba(88,65,220,0.14);

            color: #8870ff;

            border: 1px solid rgba(100,75,255,0.16);
        }


        /* =====================================================
           FORMULÁRIO
        ===================================================== */

        .form-area {

            padding: 50px;

            display: flex;

            flex-direction: column;

            justify-content: center;

            background:
                rgba(4,9,18,0.42);
        }


        .form-header {

            margin-bottom: 30px;
        }


        .form-header h2 {

            font-size: 28px;

            letter-spacing: -1px;

            margin-bottom: 7px;
        }


        .form-header p {

            color: #7f8ba0;

            font-size: 13px;
        }


        /* =====================================================
           ERRO
        ===================================================== */

        .alert-error {

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 13px 15px;

            margin-bottom: 20px;

            border-radius: 10px;

            background:
                rgba(239,68,68,0.08);

            border: 1px solid rgba(239,68,68,0.2);

            color: #ff8c8c;

            font-size: 12px;
        }


        /* =====================================================
           CAMPOS
        ===================================================== */

        .form-group {

            margin-bottom: 17px;
        }


        .form-group label {

            display: block;

            margin-bottom: 7px;

            color: #b5bfd0;

            font-size: 12px;

            font-weight: 600;
        }


        .input-wrapper {

            position: relative;
        }


        .input-icon {

            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            color: #626f87;

            font-size: 13px;

            pointer-events: none;
        }


        .form-group input {

            width: 100%;

            height: 48px;

            padding: 0 15px 0 43px;

            border-radius: 10px;

            outline: none;

            border: 1px solid rgba(255,255,255,0.08);

            background:
                rgba(13,20,34,0.85);

            color: #ffffff;

            font-family: inherit;

            font-size: 13px;

            transition: 0.25s;
        }


        .form-group input::placeholder {

            color: #536077;
        }


        .form-group input:focus {

            border-color: #6948ff;

            background:
                rgba(17,24,42,0.95);

            box-shadow:
                0 0 0 3px rgba(105,72,255,0.08);
        }


        /* =====================================================
           BOTÃO
        ===================================================== */

        .btn-submit {

            width: 100%;

            height: 50px;

            border: none;

            border-radius: 10px;

            margin-top: 8px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            cursor: pointer;

            color: #ffffff;

            font-family: inherit;

            font-size: 13px;

            font-weight: 700;

            background:
                linear-gradient(
                    90deg,
                    #743dff,
                    #168cff
                );

            box-shadow:
                0 10px 30px rgba(84,61,255,0.22);

            transition: 0.3s;
        }


        .btn-submit:hover {

            transform: translateY(-2px);

            box-shadow:
                0 15px 35px rgba(84,61,255,0.35);
        }


        /* =====================================================
           LOGIN
        ===================================================== */

        .login-link {

            text-align: center;

            margin-top: 25px;

            color: #717d92;

            font-size: 12px;
        }


        .login-link a {

            color: #917cff;

            font-weight: 600;

            transition: 0.3s;
        }


        .login-link a:hover {

            color: #b2a2ff;
        }


        /* =====================================================
           SEGURANÇA
        ===================================================== */

        .security {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            margin-top: 22px;

            color: #566176;

            font-size: 10px;
        }


        .security i {

            color: #6571a0;
        }


        /* =====================================================
           RESPONSIVO
        ===================================================== */

        @media (max-width: 850px) {

            body {

                padding: 15px;
            }


            .page {

                grid-template-columns: 1fr;

                max-width: 550px;
            }


            .presentation {

                display: none;
            }


            .form-area {

                padding: 45px 35px;
            }
        }


        @media (max-width: 500px) {

            .form-area {

                padding: 35px 22px;
            }


            .form-header h2 {

                font-size: 25px;
            }
        }

    </style>

</head>


<body>


    <!-- EFEITOS -->

    <div class="glow glow-purple"></div>

    <div class="glow glow-blue"></div>



    <!-- =====================================================
         PÁGINA
    ====================================================== -->

    <div class="page">


        <!-- =================================================
             APRESENTAÇÃO
        ================================================== -->

        <section class="presentation">


            <div class="logo">

                <div class="logo-icon">

                    <i class="fa-solid fa-wand-magic-sparkles"></i>

                </div>

                <div>
                    Meu Negócio <span>Web</span>
                </div>

            </div>



            <h1>

                Sua presença online
                <span>começa aqui.</span>

            </h1>


            <p class="presentation-description">

                Crie sua conta no Meu Negócio Web e
                tenha acesso a uma plataforma simples
                para criar e divulgar o site do seu negócio.

            </p>



            <div class="mini-features">


                <div class="mini-feature">

                    <div class="mini-feature-icon">

                        <i class="fa-solid fa-bolt"></i>

                    </div>

                    Criação simples e rápida

                </div>



                <div class="mini-feature">

                    <div class="mini-feature-icon">

                        <i class="fa-solid fa-mobile-screen"></i>

                    </div>

                    Sites responsivos

                </div>



                <div class="mini-feature">

                    <div class="mini-feature-icon">

                        <i class="fa-solid fa-palette"></i>

                    </div>

                    Personalização do seu projeto

                </div>


            </div>


        </section>



        <!-- =================================================
             FORMULÁRIO
        ================================================== -->

        <section class="form-area">


            <div class="form-header">

                <h2>
                    Criar sua conta
                </h2>

                <p>
                    Preencha os dados abaixo para começar.
                </p>

            </div>



            <!-- ERRO -->

            <?php if ($erro !== ''): ?>

                <div class="alert-error">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <?= htmlspecialchars($erro) ?>

                </div>

            <?php endif; ?>



            <!-- =================================================
                 FORM
            ================================================== -->

            <form method="POST">


                <!-- NOME -->

                <div class="form-group">

                    <label for="nome">
                        Nome
                    </label>

                    <div class="input-wrapper">

                        <i class="fa-solid fa-user input-icon"></i>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            placeholder="Digite seu nome"
                            value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                            required
                        >

                    </div>

                </div>



                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        E-mail
                    </label>

                    <div class="input-wrapper">

                        <i class="fa-solid fa-envelope input-icon"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="seuemail@exemplo.com"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            required
                        >

                    </div>

                </div>



                <!-- SENHA -->

                <div class="form-group">

                    <label for="senha">
                        Senha
                    </label>

                    <div class="input-wrapper">

                        <i class="fa-solid fa-lock input-icon"></i>

                        <input
                            type="password"
                            id="senha"
                            name="senha"
                            placeholder="Mínimo de 6 caracteres"
                            required
                        >

                    </div>

                </div>



                <!-- CONFIRMAR SENHA -->

                <div class="form-group">

                    <label for="confirmar_senha">
                        Confirmar senha
                    </label>

                    <div class="input-wrapper">

                        <i class="fa-solid fa-shield-halved input-icon"></i>

                        <input
                            type="password"
                            id="confirmar_senha"
                            name="confirmar_senha"
                            placeholder="Digite a senha novamente"
                            required
                        >

                    </div>

                </div>



                <!-- BOTÃO -->

                <button
                    type="submit"
                    class="btn-submit"
                >

                    <i class="fa-solid fa-user-plus"></i>

                    Criar minha conta

                </button>


            </form>



            <!-- LOGIN -->

            <div class="login-link">

                Já possui uma conta?

                <a href="login.php">
                    Entrar
                </a>

            </div>



            <!-- SEGURANÇA -->

            <div class="security">

                <i class="fa-solid fa-lock"></i>

                Seus dados são protegidos com segurança.

            </div>


        </section>


    </div>


</body>

</html>