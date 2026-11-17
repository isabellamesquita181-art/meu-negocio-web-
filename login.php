<?php

session_start();

require_once 'config/database.php';

$erro = '';


// ============================================================
// LOGIN
// ============================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';


    // ========================================================
    // VALIDAÇÕES
    // ========================================================

    if ($email === '' || $senha === '') {

        $erro = 'Preencha seu e-mail e sua senha.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $erro = 'Digite um e-mail válido.';

    } else {

        try {

            // =================================================
            // BUSCAR USUÁRIO
            // =================================================

            $sql = "SELECT *
                    FROM usuarios
                    WHERE email = :email
                    LIMIT 1";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':email' => $email
            ]);

            $usuario = $stmt->fetch();


            // =================================================
            // VERIFICAR USUÁRIO E SENHA
            // =================================================

            if ($usuario && password_verify($senha, $usuario['senha'])) {

                // Regenera a sessão por segurança
                session_regenerate_id(true);

                $_SESSION['usuario_id'] = $usuario['id'];

                $_SESSION['usuario_nome'] = $usuario['nome'];

                $_SESSION['usuario_email'] = $usuario['email'];


                // =================================================
                // REDIRECIONAR PARA DASHBOARD
                // =================================================

                header('Location: dashboard.php');

                exit;

            } else {

                $erro = 'E-mail ou senha incorretos.';

            }

        } catch (PDOException $e) {

            $erro = 'Ocorreu um erro ao entrar. Tente novamente.';

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

    <meta
        name="description"
        content="Entre na sua conta do Meu Negócio Web."
    >

    <title>
        Entrar | Meu Negócio Web
    </title>


    <!-- ======================================================
         FONTES
    ======================================================= -->

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


    <!-- ======================================================
         ÍCONES
    ======================================================= -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <!-- ======================================================
         CSS
    ======================================================= -->

    <style>

        /* ====================================================
           RESET
        ==================================================== */

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


        /* ====================================================
           EFEITOS DE FUNDO
        ==================================================== */

        .glow {

            position: fixed;

            width: 420px;
            height: 420px;

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

            bottom: -220px;

            left: -170px;
        }


        /* ====================================================
           PÁGINA PRINCIPAL
        ==================================================== */

        .page {

            width: 100%;

            max-width: 1100px;

            min-height: 620px;

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


        /* ====================================================
           LADO ESQUERDO
        ==================================================== */

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

            width: 350px;
            height: 350px;

            border-radius: 50%;

            border: 1px solid rgba(100,75,255,0.14);

            right: -180px;

            bottom: -150px;
        }


        .presentation::after {

            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            border-radius: 50%;

            border: 1px solid rgba(20,130,255,0.10);

            right: 20px;

            bottom: -100px;
        }


        /* ====================================================
           LOGO
        ==================================================== */

        .logo {

            display: flex;

            align-items: center;

            gap: 10px;

            font-size: 19px;

            font-weight: 800;

            margin-bottom: 55px;
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


        /* ====================================================
           TEXTO
        ==================================================== */

        .presentation h1 {

            font-size: 43px;

            line-height: 1.08;

            letter-spacing: -2px;

            margin-bottom: 20px;

            max-width: 480px;
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


        /* ====================================================
           CARDS DE BENEFÍCIOS
        ==================================================== */

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


        /* ====================================================
           ÁREA DO FORMULÁRIO
        ==================================================== */

        .form-area {

            padding: 55px;

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

            font-size: 29px;

            letter-spacing: -1px;

            margin-bottom: 7px;
        }


        .form-header p {

            color: #7f8ba0;

            font-size: 13px;
        }


        /* ====================================================
           MENSAGEM DE SUCESSO
        ==================================================== */

        .alert-success {

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 13px 15px;

            margin-bottom: 20px;

            border-radius: 10px;

            background:
                rgba(34,197,94,0.08);

            border: 1px solid rgba(34,197,94,0.20);

            color: #73e69a;

            font-size: 12px;
        }


        /* ====================================================
           MENSAGEM DE ERRO
        ==================================================== */

        .alert-error {

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 13px 15px;

            margin-bottom: 20px;

            border-radius: 10px;

            background:
                rgba(239,68,68,0.08);

            border: 1px solid rgba(239,68,68,0.20);

            color: #ff8c8c;

            font-size: 12px;
        }


        /* ====================================================
           CAMPOS
        ==================================================== */

        .form-group {

            margin-bottom: 19px;
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

            height: 50px;

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


        /* ====================================================
           BOTÃO LOGIN
        ==================================================== */

        .btn-submit {

            width: 100%;

            height: 50px;

            border: none;

            border-radius: 10px;

            margin-top: 5px;

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


        /* ====================================================
           CADASTRO
        ==================================================== */

        .register-link {

            text-align: center;

            margin-top: 25px;

            color: #717d92;

            font-size: 12px;
        }


        .register-link a {

            color: #917cff;

            font-weight: 600;

            transition: 0.3s;
        }


        .register-link a:hover {

            color: #b2a2ff;
        }


        /* ====================================================
           SEGURANÇA
        ==================================================== */

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


        /* ====================================================
           VOLTAR PARA HOME
        ==================================================== */

        .back-home {

            display: flex;

            justify-content: center;

            margin-top: 18px;
        }


        .back-home a {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            color: #626e83;

            font-size: 11px;

            transition: 0.3s;
        }


        .back-home a:hover {

            color: #ffffff;
        }


        /* ====================================================
           RESPONSIVO
        ==================================================== */

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


    <!-- =====================================================
         EFEITOS
    ====================================================== -->

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

                Bem-vindo de
                <span>volta.</span>

            </h1>


            <p class="presentation-description">

                Acesse sua conta para continuar
                gerenciando seus projetos e
                construindo a presença online
                do seu negócio.

            </p>



            <div class="mini-features">


                <div class="mini-feature">

                    <div class="mini-feature-icon">

                        <i class="fa-solid fa-layer-group"></i>

                    </div>

                    Gerencie seus projetos

                </div>



                <div class="mini-feature">

                    <div class="mini-feature-icon">

                        <i class="fa-solid fa-chart-line"></i>

                    </div>

                    Acompanhe suas visitas

                </div>



                <div class="mini-feature">

                    <div class="mini-feature-icon">

                        <i class="fa-solid fa-pen-to-square"></i>

                    </div>

                    Edite seu site quando quiser

                </div>


            </div>


        </section>



        <!-- =================================================
             FORMULÁRIO
        ================================================== -->

        <section class="form-area">


            <div class="form-header">

                <h2>
                    Entrar na conta
                </h2>

                <p>
                    Informe seus dados para continuar.
                </p>

            </div>



            <!-- =================================================
                 MENSAGEM DE CADASTRO
            ================================================== -->

            <?php if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'sucesso'): ?>

                <div class="alert-success">

                    <i class="fa-solid fa-circle-check"></i>

                    Conta criada com sucesso! Agora faça login.

                </div>

            <?php endif; ?>



            <!-- =================================================
                 ERRO
            ================================================== -->

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
                            autocomplete="email"
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
                            placeholder="Digite sua senha"
                            autocomplete="current-password"
                            required
                        >

                    </div>

                </div>



                <!-- BOTÃO -->

                <button
                    type="submit"
                    class="btn-submit"
                >

                    <i class="fa-solid fa-right-to-bracket"></i>

                    Entrar

                </button>


            </form>



            <!-- =================================================
                 CADASTRO
            ================================================== -->

            <div class="register-link">

                Ainda não possui uma conta?

                <a href="cadastro.php">
                    Criar minha conta
                </a>

            </div>



            <!-- =================================================
                 SEGURANÇA
            ================================================== -->

            <div class="security">

                <i class="fa-solid fa-shield-halved"></i>

                Acesso protegido com segurança.

            </div>



            <!-- =================================================
                 VOLTAR
            ================================================== -->

            <div class="back-home">

                <a href="index.php">

                    <i class="fa-solid fa-arrow-left"></i>

                    Voltar para página inicial

                </a>

            </div>


        </section>


    </div>


</body>

</html>