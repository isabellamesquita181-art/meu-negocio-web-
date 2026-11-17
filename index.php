<?php
// ============================================================
// MEU NEGÓCIO WEB - PÁGINA INICIAL
// ============================================================
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description"
          content="Meu Negócio Web - Crie seu site profissional de forma simples, rápida e moderna.">

    <title>Meu Negócio Web | Crie seu site</title>


    <!-- ======================================================
         FONTES
    ======================================================= -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">


    <!-- ======================================================
         ÍCONES
    ======================================================= -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


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


        html {
            scroll-behavior: smooth;
        }


        body {

            font-family: 'Inter', Arial, sans-serif;

            background:
                radial-gradient(
                    circle at 80% 10%,
                    rgba(76, 55, 255, 0.13),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 10% 35%,
                    rgba(0, 132, 255, 0.08),
                    transparent 30%
                ),
                #050914;

            color: #ffffff;

            line-height: 1.6;

            overflow-x: hidden;
        }


        a {
            text-decoration: none;
            color: inherit;
        }


        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }


        /* ====================================================
           VARIÁVEIS
        ==================================================== */

        :root {

            --primary: #7047ff;

            --primary-light: #8c5cff;

            --blue: #168cff;

            --text: #ffffff;

            --muted: #9ca8bd;

            --border: rgba(255,255,255,0.09);

            --card: rgba(12,18,32,0.72);

            --container: 1180px;
        }


        /* ====================================================
           FUNDO DECORATIVO
        ==================================================== */

        .background-glow {

            position: fixed;

            width: 500px;
            height: 500px;

            border-radius: 50%;

            filter: blur(120px);

            opacity: 0.16;

            pointer-events: none;

            z-index: -1;
        }


        .glow-one {

            background: #633cff;

            top: -250px;
            right: -150px;
        }


        .glow-two {

            background: #007bff;

            bottom: -250px;
            left: -200px;
        }


        /* ====================================================
           CONTAINER
        ==================================================== */

        .container {

            width: min(
                var(--container),
                calc(100% - 40px)
            );

            margin: auto;
        }


        /* ====================================================
           HEADER
        ==================================================== */

        header {

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;

            z-index: 1000;

            background: rgba(5,9,20,0.72);

            backdrop-filter: blur(20px);

            border-bottom: 1px solid var(--border);
        }


        .header-content {

            height: 72px;

            display: flex;

            align-items: center;

            justify-content: space-between;
        }


        /* ====================================================
           LOGO
        ==================================================== */

        .logo {

            display: flex;

            align-items: center;

            gap: 10px;

            font-size: 18px;

            font-weight: 800;

            letter-spacing: -0.5px;
        }


        .logo-symbol {

            width: 32px;
            height: 32px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 9px;

            background:
                linear-gradient(
                    135deg,
                    #743dff,
                    #087eff
                );

            box-shadow:
                0 0 25px rgba(104,68,255,0.45);

            font-size: 15px;
        }


        .logo span {

            background:
                linear-gradient(
                    90deg,
                    #ffffff,
                    #8e75ff
                );

            -webkit-background-clip: text;

            -webkit-text-fill-color: transparent;
        }


        /* ====================================================
           NAV
        ==================================================== */

        nav {

            display: flex;

            align-items: center;

            gap: 34px;
        }


        nav a {

            font-size: 13px;

            font-weight: 500;

            color: #aab4c8;

            transition: 0.3s;
        }


        nav a:hover {

            color: #ffffff;
        }


        /* ====================================================
           BOTÃO LOGIN
        ==================================================== */

        .btn-login {

            padding: 10px 22px;

            border-radius: 25px;

            border: 1px solid rgba(125,78,255,0.8);

            background: rgba(77,42,180,0.08);

            color: #ffffff;

            transition: 0.3s;
        }


        .btn-login:hover {

            background: rgba(102,67,255,0.16);

            box-shadow:
                0 0 25px rgba(106,65,255,0.2);
        }


        /* ====================================================
           HERO
        ==================================================== */

        .hero {

            min-height: 760px;

            padding-top: 150px;

            position: relative;

            display: flex;

            align-items: center;
        }


        .hero-grid {

            display: grid;

            grid-template-columns: 1fr 1fr;

            align-items: center;

            gap: 50px;
        }


        /* ====================================================
           HERO TEXTO
        ==================================================== */

        .hero-content {

            position: relative;

            z-index: 2;
        }


        .hero-badge {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 7px 14px;

            margin-bottom: 22px;

            border-radius: 30px;

            border: 1px solid rgba(112,71,255,0.5);

            background: rgba(75,45,170,0.10);

            color: #b7a6ff;

            font-size: 12px;

            font-weight: 600;
        }


        .hero-badge i {

            color: #8b6aff;

            font-size: 11px;
        }


        .hero h1 {

            font-size: clamp(
                44px,
                5vw,
                67px
            );

            line-height: 1.02;

            letter-spacing: -3px;

            margin-bottom: 25px;

            max-width: 700px;
        }


        .hero h1 .gradient {

            display: block;

            background:
                linear-gradient(
                    90deg,
                    #168cff,
                    #6847ff,
                    #a252ff
                );

            -webkit-background-clip: text;

            -webkit-text-fill-color: transparent;
        }


        .hero-description {

            max-width: 560px;

            color: #a6b1c5;

            font-size: 16px;

            line-height: 1.8;

            margin-bottom: 34px;
        }


        /* ====================================================
           BOTÕES HERO
        ==================================================== */

        .hero-buttons {

            display: flex;

            align-items: center;

            gap: 14px;

            flex-wrap: wrap;
        }


        .btn-primary {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            padding: 14px 23px;

            border-radius: 30px;

            background:
                linear-gradient(
                    90deg,
                    #793cff,
                    #168cff
                );

            color: white;

            font-size: 13px;

            font-weight: 700;

            border: 1px solid rgba(255,255,255,0.08);

            box-shadow:
                0 10px 35px rgba(74,54,255,0.25);

            transition: 0.3s;
        }


        .btn-primary:hover {

            transform: translateY(-3px);

            box-shadow:
                0 15px 45px rgba(74,54,255,0.38);
        }


        .btn-secondary {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            padding: 14px 23px;

            border-radius: 30px;

            border: 1px solid rgba(112,71,255,0.65);

            background: rgba(20,20,40,0.4);

            color: white;

            font-size: 13px;

            font-weight: 600;

            transition: 0.3s;
        }


        .btn-secondary:hover {

            background: rgba(91,65,190,0.14);

            transform: translateY(-3px);
        }


        /* ====================================================
           MOCKUP DO CELULAR
        ==================================================== */

        .hero-visual {

            position: relative;

            height: 580px;

            display: flex;

            align-items: center;

            justify-content: center;
        }


        .phone-glow {

            position: absolute;

            width: 340px;
            height: 340px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(73,70,255,0.5),
                    rgba(20,110,255,0.15),
                    transparent 70%
                );

            filter: blur(25px);
        }


        .phone-floor {

            position: absolute;

            bottom: 30px;

            width: 430px;
            height: 100px;

            border-radius: 50%;

            border: 1px solid rgba(84,74,255,0.5);

            box-shadow:
                0 0 50px rgba(61,67,255,0.45),
                inset 0 0 30px rgba(61,67,255,0.2);

            transform: perspective(300px) rotateX(60deg);
        }


        .phone {

            position: relative;

            width: 270px;

            height: 535px;

            padding: 8px;

            border-radius: 40px;

            background:
                linear-gradient(
                    145deg,
                    #252a3c,
                    #090c14
                );

            border: 2px solid rgba(110,103,255,0.75);

            box-shadow:
                0 0 0 2px rgba(255,255,255,0.04),
                0 0 35px rgba(76,65,255,0.65),
                25px 35px 70px rgba(0,0,0,0.65);

            transform:
                perspective(1000px)
                rotateY(-7deg)
                rotateX(2deg);

            z-index: 3;
        }


        .phone::before {

            content: "";

            position: absolute;

            left: -3px;

            top: 115px;

            width: 3px;

            height: 60px;

            border-radius: 5px;

            background: #777;
        }


        .phone::after {

            content: "";

            position: absolute;

            right: -3px;

            top: 150px;

            width: 3px;

            height: 90px;

            border-radius: 5px;

            background: #777;
        }


        .phone-screen {

            width: 100%;

            height: 100%;

            border-radius: 33px;

            overflow: hidden;

            background: #080b13;

            border: 1px solid rgba(255,255,255,0.05);

            position: relative;
        }


        .phone-notch {

            position: absolute;

            top: 8px;

            left: 50%;

            transform: translateX(-50%);

            width: 92px;

            height: 23px;

            background: #020308;

            border-radius: 20px;

            z-index: 10;
        }


        .phone-site-header {

            height: 65px;

            padding: 22px 17px 10px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            background:
                linear-gradient(
                    180deg,
                    rgba(20,28,48,0.95),
                    rgba(11,15,25,0.95)
                );

            border-bottom: 1px solid rgba(255,255,255,0.05);
        }


        .mini-logo {

            display: flex;

            align-items: center;

            gap: 5px;

            font-size: 9px;

            font-weight: 700;
        }


        .mini-logo-icon {

            width: 18px;
            height: 18px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 5px;

            background:
                linear-gradient(
                    135deg,
                    #793cff,
                    #148cff
                );

            font-size: 8px;
        }


        .menu-icon {

            width: 27px;
            height: 27px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 7px;

            background: rgba(255,255,255,0.05);

            color: #b8c0d0;

            font-size: 11px;
        }


        /* ====================================================
           CONTEÚDO DO CELULAR
        ==================================================== */

        .phone-content {

            padding: 22px 15px;
        }


        .phone-hero-image {

            height: 120px;

            border-radius: 15px;

            margin-bottom: 15px;

            background:
                linear-gradient(
                    135deg,
                    rgba(100,70,255,0.8),
                    rgba(9,106,230,0.55)
                );

            position: relative;

            overflow: hidden;
        }


        .phone-hero-image::before {

            content: "";

            position: absolute;

            width: 170px;

            height: 170px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(255,255,255,0.2),
                    transparent 70%
                );

            top: -90px;
            right: -30px;
        }


        .phone-hero-text {

            position: absolute;

            left: 15px;
            bottom: 13px;

            font-size: 15px;

            font-weight: 800;

            line-height: 1.1;
        }


        .phone-hero-small {

            display: block;

            margin-top: 5px;

            color: rgba(255,255,255,0.65);

            font-size: 7px;

            font-weight: 400;
        }


        .phone-card {

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 11px;

            margin-bottom: 9px;

            border-radius: 12px;

            background:
                rgba(18,24,39,0.95);

            border: 1px solid rgba(255,255,255,0.06);

            box-shadow:
                0 5px 20px rgba(0,0,0,0.15);
        }


        .phone-card-icon {

            width: 31px;
            height: 31px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 9px;

            background:
                linear-gradient(
                    135deg,
                    #4832b9,
                    #096fca
                );

            font-size: 11px;
        }


        .phone-card-info {

            flex: 1;
        }


        .phone-card-title {

            display: block;

            font-size: 9px;

            font-weight: 700;

            margin-bottom: 2px;
        }


        .phone-card-text {

            display: block;

            font-size: 7px;

            color: #7f899e;
        }


        .phone-card-arrow {

            color: #77829b;

            font-size: 9px;
        }


        /* ====================================================
           CARDS FLUTUANTES
        ==================================================== */

        .floating-card {

            position: absolute;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 13px 17px;

            border-radius: 14px;

            background:
                rgba(10,16,30,0.78);

            backdrop-filter: blur(16px);

            border: 1px solid rgba(86,74,255,0.45);

            box-shadow:
                0 15px 40px rgba(0,0,0,0.3),
                0 0 25px rgba(77,60,255,0.08);

            font-size: 11px;

            font-weight: 600;

            z-index: 5;
        }


        .floating-icon {

            width: 33px;
            height: 33px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #5837e8,
                    #137fe2
                );

            font-size: 13px;
        }


        .float-left {

            left: 0;

            top: 155px;
        }


        .float-right-top {

            right: -10px;

            top: 105px;
        }


        .float-right-bottom {

            right: -35px;

            bottom: 145px;
        }


        /* ====================================================
           LINHA DECORATIVA
        ==================================================== */

        .hero-line {

            position: absolute;

            bottom: 0;

            left: 0;

            width: 100%;

            height: 1px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(91,76,255,0.45),
                    transparent
                );
        }


        /* ====================================================
           SEÇÃO BENEFÍCIOS
        ==================================================== */

        .features {

            padding: 85px 0;

            border-bottom: 1px solid var(--border);
        }


        .features-grid {

            display: grid;

            grid-template-columns: 1fr 2fr;

            gap: 50px;

            align-items: center;
        }


        .section-label {

            color: #8e7cff;

            font-size: 12px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 1.5px;

            margin-bottom: 12px;
        }


        .section-title {

            font-size: 36px;

            line-height: 1.15;

            letter-spacing: -1.5px;

            margin-bottom: 12px;
        }


        .section-description {

            color: #8f9aae;

            font-size: 14px;

            max-width: 430px;
        }


        .feature-cards {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 16px;
        }


        .feature-card {

            padding: 24px 20px;

            border-radius: 15px;

            background:
                linear-gradient(
                    145deg,
                    rgba(18,25,42,0.9),
                    rgba(8,13,24,0.8)
                );

            border: 1px solid var(--border);

            transition: 0.3s;
        }


        .feature-card:hover {

            transform: translateY(-5px);

            border-color:
                rgba(108,79,255,0.4);

            box-shadow:
                0 15px 40px rgba(0,0,0,0.2);
        }


        .feature-icon {

            width: 42px;
            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    rgba(76,52,220,0.3),
                    rgba(0,130,255,0.18)
                );

            color: #8b76ff;

            margin-bottom: 18px;
        }


        .feature-card h3 {

            font-size: 14px;

            margin-bottom: 7px;
        }


        .feature-card p {

            color: #8290a8;

            font-size: 12px;

            line-height: 1.6;
        }


        /* ====================================================
           COMO FUNCIONA
        ==================================================== */

        .how {

            padding: 90px 0;

            border-bottom: 1px solid var(--border);
        }


        .how-header {

            margin-bottom: 50px;
        }


        .steps {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 25px;
        }


        .step {

            position: relative;

            padding: 15px 15px 15px 70px;
        }


        .step-number {

            position: absolute;

            left: 0;
            top: 8px;

            width: 43px;
            height: 43px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #168cff,
                    #6546ff
                );

            box-shadow:
                0 0 25px rgba(79,76,255,0.3);

            font-weight: 800;

            font-size: 14px;
        }


        .step h3 {

            font-size: 15px;

            margin-bottom: 7px;
        }


        .step p {

            color: #8390a6;

            font-size: 12px;
        }


        /* ====================================================
           EXEMPLO
        ==================================================== */

        .example {

            padding: 90px 0;
        }


        .example-box {

            position: relative;

            min-height: 400px;

            padding: 55px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 50px;

            border-radius: 22px;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at 80% 50%,
                    rgba(75,55,220,0.2),
                    transparent 40%
                ),
                linear-gradient(
                    135deg,
                    #0c1426,
                    #080d19
                );

            border: 1px solid rgba(83,77,255,0.28);
        }


        .example-content {

            max-width: 480px;

            position: relative;

            z-index: 2;
        }


        .example-content h2 {

            font-size: 34px;

            letter-spacing: -1px;

            margin-bottom: 12px;
        }


        .example-content p {

            color: #8e9bb1;

            font-size: 14px;

            margin-bottom: 25px;
        }


        /* ====================================================
           NOTEBOOK
        ==================================================== */

        .laptop-area {

            position: relative;

            width: 500px;

            height: 280px;
        }


        .laptop {

            position: absolute;

            width: 380px;

            height: 230px;

            right: 20px;

            top: 10px;

            padding: 8px;

            border-radius: 10px;

            background: #111827;

            border: 2px solid #3944a2;

            box-shadow:
                0 20px 50px rgba(0,0,0,0.5);
        }


        .laptop-screen {

            width: 100%;
            height: 100%;

            background:
                linear-gradient(
                    135deg,
                    #12182a,
                    #070a11
                );

            border-radius: 5px;

            overflow: hidden;
        }


        .laptop-top {

            height: 25px;

            padding: 7px 10px;

            display: flex;

            align-items: center;

            gap: 5px;

            background: #0b0f19;

            font-size: 7px;
        }


        .browser-dot {

            width: 5px;
            height: 5px;

            border-radius: 50%;

            background: #667085;
        }


        .fake-site {

            padding: 25px;

            height: calc(100% - 25px);

            background:
                linear-gradient(
                    135deg,
                    #14111a,
                    #090b12
                );
        }


        .fake-site h3 {

            font-size: 22px;

            margin-bottom: 5px;
        }


        .fake-site p {

            font-size: 9px;

            color: #9ca3af;

            margin-bottom: 15px;
        }


        .fake-button {

            display: inline-block;

            padding: 6px 12px;

            border-radius: 15px;

            font-size: 8px;

            background:
                linear-gradient(
                    90deg,
                    #653dff,
                    #147fe8
                );
        }


        .cake-image {

            position: absolute;

            width: 130px;
            height: 100px;

            right: 30px;

            bottom: 30px;

            border-radius: 12px;

            background:
                radial-gradient(
                    circle at 50% 70%,
                    #8b3d29,
                    #321b1a 50%,
                    #12131a
                );

            box-shadow:
                0 15px 40px rgba(0,0,0,0.5);

            border: 2px solid rgba(255,255,255,0.1);
        }


        .phone-small {

            position: absolute;

            width: 110px;

            height: 210px;

            right: -5px;

            bottom: 5px;

            padding: 5px;

            border-radius: 18px;

            background: #151a29;

            border: 2px solid #5152bc;

            box-shadow:
                0 15px 35px rgba(0,0,0,0.5);
        }


        .phone-small-screen {

            width: 100%;
            height: 100%;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #18121c,
                    #080a11
                );

            padding: 25px 8px 8px;
        }


        .phone-small-screen h4 {

            font-size: 9px;

            margin-bottom: 5px;
        }


        .phone-small-screen p {

            font-size: 6px;

            color: #8b94a7;
        }


        /* ====================================================
           CTA
        ==================================================== */

        .cta {

            padding: 25px;

            margin-bottom: 80px;

            border-radius: 18px;

            background:
                linear-gradient(
                    90deg,
                    rgba(52,36,170,0.5),
                    rgba(24,96,194,0.38)
                );

            border: 1px solid rgba(92,78,255,0.55);

            box-shadow:
                0 0 45px rgba(68,60,255,0.08);

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 30px;
        }


        .cta-left {

            display: flex;

            align-items: center;

            gap: 18px;
        }


        .cta-icon {

            width: 48px;
            height: 48px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #4c39dd,
                    #146ed0
                );

            font-size: 18px;
        }


        .cta h2 {

            font-size: 20px;

            margin-bottom: 3px;
        }


        .cta p {

            color: #a4b0c5;

            font-size: 12px;
        }


        /* ====================================================
           FOOTER
        ==================================================== */

        footer {

            padding: 28px 0;

            border-top: 1px solid var(--border);

            color: #69758a;

            font-size: 11px;
        }


        .footer-content {

            display: flex;

            align-items: center;

            justify-content: space-between;
        }


        .footer-logo {

            display: flex;

            align-items: center;

            gap: 8px;

            color: #ffffff;

            font-weight: 700;
        }


        .footer-logo span {

            color: #8268ff;
        }


        /* ====================================================
           ANIMAÇÕES
        ==================================================== */

        @keyframes float {

            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }


        .floating-card {

            animation:
                float 4s ease-in-out infinite;
        }


        .float-right-top {

            animation-delay: 0.8s;
        }


        .float-right-bottom {

            animation-delay: 1.5s;
        }


        /* ====================================================
           RESPONSIVO - TABLET
        ==================================================== */

        @media (max-width: 1000px) {

            .hero-grid {

                grid-template-columns: 1fr;

                text-align: center;
            }


            .hero-content {

                display: flex;

                flex-direction: column;

                align-items: center;
            }


            .hero-description {

                margin-left: auto;
                margin-right: auto;
            }


            .hero-visual {

                height: 570px;
            }


            .features-grid {

                grid-template-columns: 1fr;
            }


            .feature-cards {

                grid-template-columns:
                    repeat(3, 1fr);
            }


            .example-box {

                flex-direction: column;

                text-align: center;
            }


            .example-content {

                margin: auto;
            }
        }


        /* ====================================================
           RESPONSIVO - CELULAR
        ==================================================== */

        @media (max-width: 700px) {

            .container {

                width: min(
                    var(--container),
                    calc(100% - 28px)
                );
            }


            nav {

                gap: 10px;
            }


            nav > a:not(.btn-login) {

                display: none;
            }


            .header-content {

                height: 65px;
            }


            .hero {

                padding-top: 110px;

                min-height: auto;
            }


            .hero h1 {

                font-size: 43px;

                letter-spacing: -2px;
            }


            .hero-description {

                font-size: 14px;
            }


            .hero-buttons {

                width: 100%;

                flex-direction: column;
            }


            .btn-primary,
            .btn-secondary {

                width: 100%;
            }


            .hero-visual {

                height: 540px;
            }


            .phone {

                width: 240px;

                height: 480px;
            }


            .phone-floor {

                width: 330px;
            }


            .floating-card {

                font-size: 9px;

                padding: 9px;
            }


            .float-left {

                left: -5px;

                top: 120px;
            }


            .float-right-top {

                right: -5px;

                top: 75px;
            }


            .float-right-bottom {

                right: -5px;

                bottom: 100px;
            }


            .features,
            .how,
            .example {

                padding: 65px 0;
            }


            .section-title {

                font-size: 29px;
            }


            .feature-cards {

                grid-template-columns: 1fr;
            }


            .steps {

                grid-template-columns: 1fr;

                gap: 10px;
            }


            .example-box {

                padding: 35px 20px;

                min-height: auto;
            }


            .laptop-area {

                transform: scale(0.7);

                transform-origin: center;

                width: 100%;

                margin: -30px 0;
            }


            .cta {

                flex-direction: column;

                text-align: center;

                padding: 25px 18px;
            }


            .cta-left {

                flex-direction: column;
            }


            .cta .btn-primary {

                width: auto;
            }


            .footer-content {

                flex-direction: column;

                gap: 12px;

                text-align: center;
            }

        }

    </style>

</head>


<body>


    <!-- ======================================================
         ELEMENTOS DECORATIVOS
    ======================================================= -->

    <div class="background-glow glow-one"></div>

    <div class="background-glow glow-two"></div>



    <!-- ======================================================
         HEADER
    ======================================================= -->

    <header>

        <div class="container header-content">


            <a href="index.php" class="logo">

                <div class="logo-symbol">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                </div>

                <div>
                    Meu Negócio <span>Web</span>
                </div>

            </a>


            <nav>

                <a href="#como-funciona">
                    Como funciona
                </a>

                <a href="#exemplo">
                    Exemplo
                </a>

                <!-- SOMENTE LOGIN -->
                <a href="login.php" class="btn-login">
                    Entrar
                </a>

            </nav>


        </div>

    </header>



    <!-- ======================================================
         HERO
    ======================================================= -->

    <main>

        <section class="hero">

            <div class="container hero-grid">


                <!-- TEXTO -->

                <div class="hero-content">


                    <div class="hero-badge">

                        <i class="fa-solid fa-bolt"></i>

                        Crie sua presença online

                    </div>


                    <h1>

                        Crie seu site.

                        <span class="gradient">
                            Divulgue seu negócio.
                        </span>

                    </h1>


                    <p class="hero-description">

                        O Meu Negócio Web permite que pequenos
                        empreendedores criem sua própria página
                        na internet de forma simples, rápida
                        e profissional.

                    </p>


                    <div class="hero-buttons">

                        <!-- CADASTRO -->

                        <a href="cadastro.php"
                           class="btn-primary">

                            <i class="fa-solid fa-user-plus"></i>

                            Criar minha conta

                        </a>


                        <!-- LOGIN -->

                        <a href="login.php"
                           class="btn-secondary">

                            <i class="fa-solid fa-right-to-bracket"></i>

                            Já tenho uma conta

                        </a>

                    </div>


                </div>



                <!-- ==================================================
                     CELULAR
                =================================================== -->

                <div class="hero-visual">


                    <div class="phone-glow"></div>


                    <div class="phone-floor"></div>


                    <!-- CARD ESQUERDO -->

                    <div class="floating-card float-left">

                        <div class="floating-icon">

                            <i class="fa-solid fa-mobile-screen-button"></i>

                        </div>

                        <div>

                            Design moderno<br>
                            e responsivo

                        </div>

                    </div>


                    <!-- CARD SUPERIOR DIREITO -->

                    <div class="floating-card float-right-top">

                        <div class="floating-icon">

                            <i class="fa-solid fa-rocket"></i>

                        </div>

                        <div>

                            Seu site no ar<br>
                            em minutos

                        </div>

                    </div>


                    <!-- CARD INFERIOR DIREITO -->

                    <div class="floating-card float-right-bottom">

                        <div class="floating-icon">

                            <i class="fa-solid fa-globe"></i>

                        </div>

                        <div>

                            Acesso em todos<br>
                            os dispositivos

                        </div>

                    </div>



                    <!-- CELULAR -->

                    <div class="phone">

                        <div class="phone-screen">


                            <div class="phone-notch"></div>


                            <!-- HEADER CELULAR -->

                            <div class="phone-site-header">


                                <div class="mini-logo">

                                    <div class="mini-logo-icon">

                                        M

                                    </div>

                                    Meu Negócio

                                </div>


                                <div class="menu-icon">

                                    <i class="fa-solid fa-bars"></i>

                                </div>


                            </div>



                            <!-- CONTEÚDO CELULAR -->

                            <div class="phone-content">


                                <div class="phone-hero-image">


                                    <div class="phone-hero-text">

                                        Bem-vindo!

                                        <span class="phone-hero-small">
                                            Conheça nossos produtos e serviços.
                                        </span>

                                    </div>


                                </div>



                                <!-- CARD -->

                                <div class="phone-card">

                                    <div class="phone-card-icon">

                                        <i class="fa-solid fa-bag-shopping"></i>

                                    </div>


                                    <div class="phone-card-info">

                                        <span class="phone-card-title">
                                            Produtos
                                        </span>

                                        <span class="phone-card-text">
                                            Qualidade e variedade
                                        </span>

                                    </div>


                                    <div class="phone-card-arrow">

                                        <i class="fa-solid fa-chevron-right"></i>

                                    </div>

                                </div>



                                <!-- CARD -->

                                <div class="phone-card">

                                    <div class="phone-card-icon">

                                        <i class="fa-solid fa-gear"></i>

                                    </div>


                                    <div class="phone-card-info">

                                        <span class="phone-card-title">
                                            Serviços
                                        </span>

                                        <span class="phone-card-text">
                                            Atendimento especializado
                                        </span>

                                    </div>


                                    <div class="phone-card-arrow">

                                        <i class="fa-solid fa-chevron-right"></i>

                                    </div>

                                </div>



                                <!-- CARD -->

                                <div class="phone-card">

                                    <div class="phone-card-icon">

                                        <i class="fa-solid fa-comments"></i>

                                    </div>


                                    <div class="phone-card-info">

                                        <span class="phone-card-title">
                                            Contato
                                        </span>

                                        <span class="phone-card-text">
                                            Tire suas dúvidas
                                        </span>

                                    </div>


                                    <div class="phone-card-arrow">

                                        <i class="fa-solid fa-chevron-right"></i>

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                </div>

            </div>


            <div class="hero-line"></div>

        </section>



        <!-- ======================================================
             BENEFÍCIOS
        ======================================================= -->

        <section class="features">

            <div class="container features-grid">


                <div>

                    <div class="section-label">
                        Recursos
                    </div>

                    <h2 class="section-title">
                        Tudo que seu negócio precisa
                    </h2>

                    <p class="section-description">

                        Uma maneira simples e moderna de
                        colocar sua empresa na internet.

                    </p>

                </div>



                <div class="feature-cards">


                    <div class="feature-card">

                        <div class="feature-icon">

                            <i class="fa-solid fa-bolt"></i>

                        </div>

                        <h3>
                            Fácil de usar
                        </h3>

                        <p>
                            Crie e personalize seu projeto
                            sem precisar entender de programação.
                        </p>

                    </div>



                    <div class="feature-card">

                        <div class="feature-icon">

                            <i class="fa-solid fa-mobile-screen"></i>

                        </div>

                        <h3>
                            Responsivo
                        </h3>

                        <p>
                            Seu site pode ser acessado pelo
                            celular, tablet ou computador.
                        </p>

                    </div>



                    <div class="feature-card">

                        <div class="feature-icon">

                            <i class="fa-solid fa-palette"></i>

                        </div>

                        <h3>
                            Personalizável
                        </h3>

                        <p>
                            Adicione informações, contatos,
                            imagens e conteúdos do seu negócio.
                        </p>

                    </div>


                </div>

            </div>

        </section>



        <!-- ======================================================
             COMO FUNCIONA
        ======================================================= -->

        <section class="how" id="como-funciona">

            <div class="container">


                <div class="how-header">

                    <div class="section-label">
                        Processo
                    </div>

                    <h2 class="section-title">
                        Como funciona?
                    </h2>

                    <p class="section-description">
                        Começar é simples.
                    </p>

                </div>



                <div class="steps">


                    <div class="step">

                        <div class="step-number">
                            1
                        </div>

                        <h3>
                            Crie sua conta
                        </h3>

                        <p>
                            Faça seu cadastro gratuitamente
                            na plataforma.
                        </p>

                    </div>



                    <div class="step">

                        <div class="step-number">
                            2
                        </div>

                        <h3>
                            Crie seu projeto
                        </h3>

                        <p>
                            Adicione as informações e conteúdos
                            do seu negócio.
                        </p>

                    </div>



                    <div class="step">

                        <div class="step-number">
                            3
                        </div>

                        <h3>
                            Divulgue
                        </h3>

                        <p>
                            Tenha uma página para apresentar
                            seu negócio na internet.
                        </p>

                    </div>


                </div>

            </div>

        </section>



        <!-- ======================================================
             EXEMPLO
        ======================================================= -->

        <section class="example" id="exemplo">

            <div class="container">


                <div class="example-box">


                    <div class="example-content">


                        <div class="section-label">
                            Seu próximo projeto
                        </div>


                        <h2>
                            Veja um exemplo
                        </h2>


                        <p>

                            Seu negócio pode ter uma página
                            moderna para apresentar produtos,
                            serviços e informações de contato.

                        </p>


                        <!-- CADASTRO -->

                        <a href="cadastro.php"
                           class="btn-primary">

                            <i class="fa-solid fa-rocket"></i>

                            Quero criar meu site

                        </a>


                    </div>



                    <!-- MOCKUP NOTEBOOK -->

                    <div class="laptop-area">


                        <div class="laptop">


                            <div class="laptop-screen">


                                <div class="laptop-top">

                                    <div class="browser-dot"></div>
                                    <div class="browser-dot"></div>
                                    <div class="browser-dot"></div>

                                    Doceria da Ana

                                </div>


                                <div class="fake-site">

                                    <h3>
                                        Doceria da Ana
                                    </h3>

                                    <p>
                                        Bolos, doces e sobremesas
                                        feitos com carinho.
                                    </p>

                                    <span class="fake-button">
                                        Ver produtos
                                    </span>

                                </div>


                            </div>

                        </div>


                        <div class="cake-image"></div>


                        <!-- CELULAR PEQUENO -->

                        <div class="phone-small">

                            <div class="phone-small-screen">

                                <h4>
                                    Doceria da Ana
                                </h4>

                                <p>
                                    Bolos e doces feitos
                                    especialmente para você.
                                </p>

                            </div>

                        </div>


                    </div>


                </div>


                <!-- ==================================================
                     CTA
                =================================================== -->

                <div class="cta">


                    <div class="cta-left">


                        <div class="cta-icon">

                            <i class="fa-solid fa-rocket"></i>

                        </div>


                        <div>

                            <h2>
                                Pronto para começar?
                            </h2>

                            <p>
                                Crie sua conta e comece a construir
                                sua presença online.
                            </p>

                        </div>


                    </div>


                    <!-- CADASTRO -->

                    <a href="cadastro.php"
                       class="btn-primary">

                        <i class="fa-solid fa-user-plus"></i>

                        Criar minha conta

                    </a>


                </div>


            </div>

        </section>


    </main>



    <!-- ======================================================
         FOOTER
    ======================================================= -->

    <footer>

        <div class="container footer-content">


            <div class="footer-logo">

                <div class="logo-symbol">

                    <i class="fa-solid fa-wand-magic-sparkles"></i>

                </div>

                Meu Negócio <span>Web</span>

            </div>


            <div>

                © <?= date('Y') ?> Meu Negócio Web.
                Todos os direitos reservados.

            </div>


            <div>

                Plataforma para criação de sites

            </div>


        </div>

    </footer>


</body>

</html>