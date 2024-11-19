<?php
$background = "https://server-app.mtapp.ao/storage/photo/8TAa6TVI5BaKxojiYrBmC5mSsbA2wK4jw3n4iQYX.png";
$teacher = strtoupper($documentSetting->name_director);
$admin = strtoupper($documentSetting->name_director);

// HTML a ser renderizado
$html = <<<HTML
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <title>CERTIFICADO DE CURSO</title>
</head>
<body>
    <img src="{$background}" alt="{$background}" class="bg-img">
    <div class="content">
        <div class="title" >Certificado</div>
        <div class="subtitle">
            De Participação 
        </div>

        <p class="subtitle-2">ESTE CERTIFICADO É ORGULHOSAMENTE ATRIBUÍDO A</p>
        <h1 class="fullname" >MARCELO SETULA JOSÉ</h1>
        <br>
        <p class="text-content">
            <strong>A Sociedade de Formação Financeira e Seguros (SFFS), <br> </strong>
            certifica que <span class="negritar">MARCELO SETULA JOSÉ (NOME DO ALUNO)</span>   <br> 
            portadora do <strong>B.I nº XXXXXXXXXXXXX  concluiu o Curso de <span class="negritar">NOME DO CURSO</span> </strong> realizado de <strong>DATA DE INÍCIO</strong> a <strong>DATA DO FIM</strong>, demostrando <br>
            dedicação e empenhos exemplares. Parabéns e votos de muito sucesso na sua 
            carreira<br>
        </p>
        <p class="date-local ">Certificado emitido em DATA DE EMISSÃO </p>
        <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
        <div class="footer">
           <div class="signatures">
            <img src="https://server-app.mtapp.ao/qrcode.png" style="width: 90px;" alt="">
           </div>
        </div>
    </div>
    <style>
        /* CSS Reset */
        *,
        *::before,
        *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        font: inherit;
        vertical-align: baseline;
        }

        html, body {
        height: 100%;
        line-height: 1;
        }

        body {
        font-family: Arial, sans-serif; /* Altere para sua fonte preferida */
        }

        ol, ul {
        list-style: none;
        }

        a {
        text-decoration: none;
        color: inherit;
        }

        img, video {
        max-width: 100%;
        height: auto;
        }

        /* Tabelas */
        table {
        border-collapse: collapse;
        border-spacing: 0;
        }

        button, input, textarea, select {
        font: inherit;
        }


       @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');
       
       body, html {
            font-family: "Open Sans";
            font-optical-sizing: auto;
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
         }
         
         .bg-img {
             position: absolute;
             top: 0;
             left: 0;
             width: 100%;
             height: 100%;
             object-fit: cover;
             z-index: -1;
         }
         *{
             font-family: opens sanrs;
         }
         .content {
             z-index: 1;
             text-align: center;
             margin: 60px;
             margin-top: 230px;
         }
         .signatures {
             display: flex;
             justify-content: center;
             margin-bottom: 20px;
             margin-top: 30px;
         }
         .text-content{
             text-align: justify;
             text-align: center;
             font-size: 21px;
             margin-left: 90px;
             margin-right: 90px;
             font-family: Arial, Helvetica, sans-serif;
             
         }

        .title{
            /* font-family: "Open Sans", sans-serif; */
            font-size: 72px;
            color: #cf7703;
            margin-top: 35px;
        }
        .fullname{
            /* font-family: "Open Sans", sans-serif; */
            font-size: 42px;
            color: #cf7703;
        }

        .subtitle{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .text{
            font-family: Arial, Helvetica, sans-serif;
        }
        .subtitle-2{
            font-size: 15px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .footer-text{
            font-size: 15px;
        }
         .date-local{
             text-align: center;
             font-size: 21px;
             font-family: Arial, Helvetica, sans-serif;
         }
         .negritar{
            font-weight: bold;
         }
         .footer{
             margin: 0px;
             padding: 0px;
         }
         
         .signature {
             text-align: center;
             font-family: Arial, Helvetica, sans-serif;
         }
     </style>
    <script>
       /*  print(); */
    </script>
</body>
</html>
HTML;

// Carrega o HTML no Dompdf
$dompdf->loadHtml($html);

// Define o tamanho da página para A4 em orientação paisagem
$dompdf->setPaper('A4', 'landscape');

// Renderiza o PDF
$dompdf->render();

// Envia para o navegador
$dompdf->stream('relatorio.pdf');
?>