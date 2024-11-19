<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendEmailController extends Controller
{
    /* public function sendEmail()
    {
        // O envio do email é feito usando o método to na facade Mail
        $res = Mail::to('manuelmuanza20@gmail.com')->send(new SendEmail("Manuel Muanza"));
        if($res){
            return response()->json(["Success"]);
        }
        return response()->json(["Error"]);
    } */

    public function codeToVerifyIdentity($email, $code){
        // Crie uma instância do PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Configuração do servidor SMTP
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->ContentType = 'text/html; charset=UTF-8';
            $mail->Host = 's1380.use1.mysecurecloudhost.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nao-responde@dentaluanda.ao';
            $mail->Password = 'Dalva_2024'; // Substitua 'sua-senha' pela senha real
            $mail->SMTPSecure = 'ssl'; // Use 'ssl' para SMTP com SSL ou 'tls' para SMTP com TLS
            $mail->Port = 465; // Porta SMTP

            // Configuração do remetente e do destinatário
            $mail->setFrom('nao-responde@dentaluanda.ao', '[TrainingCenter]');
            $mail->addAddress(''.$email.'', '');

            // Configuração do assunto e do corpo do e-mail
            $mail->Subject = '=?UTF-8?B?' . base64_encode('Código de Verificação - Iniciar Sessão') . '?=';
            $mail->Body = '
                    <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    </head>
                    <body style="max-width: 500px; margin: 0 auto; text-align: center;">
                        <div style="background-color: #f0f0f0; padding: 20px; text-align: center;">

                        </div>
                        <div style="max-width:100%; padding: 20px; text-align: justify;">
                            <h1 style="max-width: 100%; font-weight: bold; font-size:14pt; margin-bottom: 15px;">
                                Iniciar Sessão
                            </h1>
                            <h2 style="max-width: 100%; font-weight: normal; font-size:12pt; margin-bottom: 15px;">
                                O teu código de Verificação
                            </h2>
                            <h1 style="max-width: 100%; font-weight: bold; font-size:14pt; margin-bottom: 15px; color:darkblue;">
                                '.$code.'
                            </h1>
                            <p style="max-width: 100%; font-weight: normal; font-size:12pt; margin-bottom: 10px;">
                                Informe o código acima para verificar a sua Identidade.
                            </p>
                            <i style="max-width: 100%; font-weight: normal; font-size:8pt; margin-bottom: 20px;">
                                Esta é uma mensagem automática, por favor, não responda.
                            </i>

                            <p style="max-width: 100%; font-weight: normal; font-size:12pt; margin-bottom: 10px;">
                                Obrigado, <br> Equipa Training Center
                            </p>
                        </div>
                        <div style="background-color: #f0f0f0; padding: 20px; text-align: center; border-top:1px solid darkblue; gap:15px;">

                        </div>
                    </body>
                    </html>
                    ';

            // Envio do e-mail
            $mail->send();
            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }

    
    public function sendRecoverPassEmail($email, $code)
    {
        // Crie uma instância do PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Configuração do servidor SMTP
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->ContentType = 'text/html; charset=UTF-8';
            $mail->Host = 's1380.use1.mysecurecloudhost.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nao-responde@dentaluanda.ao';
            $mail->Password = 'Dalva_2024'; // Substitua 'sua-senha' pela senha real
            $mail->SMTPSecure = 'ssl'; // Use 'ssl' para SMTP com SSL ou 'tls' para SMTP com TLS
            $mail->Port = 465; // Porta SMTP

            // Configuração do remetente e do destinatário
            $mail->setFrom('nao-responde@dentaluanda.ao', '[TrainingCenter]');
            $mail->addAddress(''.$email.'', '');

            // Configuração do assunto e do corpo do e-mail
            $mail->Subject = '=?UTF-8?B?' . base64_encode('Recuperar Palavra-Passe') . '?=';
            $mail->Body = '
                    <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    </head>
                    <body style="max-width: 500px; margin: 0 auto; text-align: center;">
                        <div style="background-color: #f0f0f0; padding: 20px; text-align: center;">

                        </div>
                        <div style="max-width:100%; padding: 20px; text-align: justify;">
                            <h1 style="max-width: 100%; font-weight: bold; font-size:14pt; margin-bottom: 15px;">
                               Redefinir Palavra-Passe
                            </h1>
                            <h2 style="max-width: 100%; font-weight: normal; font-size:12pt; margin-bottom: 15px;">
                                Solicitação de Redefinição de Senha. <br><br>
                                Abaixo tens a sua Palavra-Passe para Inicio de Sessão
                            </h2>
                            <h1 style="max-width: 100%; font-weight: bold; font-size:14pt; margin-bottom: 15px; color:darkblue;">
                                '.$code.'
                            </h1>
                            <p style="max-width: 100%; font-weight: normal; font-size:12pt; margin-bottom: 10px;">
                                Infome o código acima no formulário onde fez a solicitação para alterares
                                a sua Palavra-passe.
                            </p>
                            <i style="max-width: 100%; font-weight: normal; font-size:8pt; margin-bottom: 20px;">
                                Não fez uma solitação para Alterar a sua Senha? Discarte este Email.
                            </i>
                            <br>
                            <i style="max-width: 100%; font-weight: normal; font-size:8pt; margin-bottom: 20px;">
                                Esta é uma mensagem automática, por favor, não responda.
                            </i>
                            <p style="max-width: 100%; font-weight: normal; font-size:12pt; margin-bottom: 10px;">
                                Obrigado, <br> Equipa Training Center
                            </p>
                        </div>
                        <div style="background-color: #f0f0f0; padding: 20px; text-align: center; border-top:1px solid darkblue; gap:15px;">

                        </div>
                    </body>
                    </html>
                    ';

            // Envio do e-mail
            $mail->send();
            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }


    public function sendWelcomeEmail($email, $password, $name)
    {
        // Crie uma instância do PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Configuração do servidor SMTP
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->ContentType = 'text/html; charset=UTF-8';
            $mail->Host = 's1380.use1.mysecurecloudhost.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nao-responde@dentaluanda.ao';
            $mail->Password = 'Dalva_2024'; // Substitua 'sua-senha' pela senha real
            $mail->SMTPSecure = 'ssl'; // Use 'ssl' para SMTP com SSL ou 'tls' para SMTP com TLS
            $mail->Port = 465; // Porta SMTP

            // Configuração do remetente e do destinatário
            $mail->setFrom('nao-responde@dentaluanda.ao', '[TrainingCenter]');
            $mail->addAddress(''.$email.'', '');

            // Configuração do assunto e do corpo do e-mail
            $mail->Subject = '=?UTF-8?B?' . base64_encode('Bem-Vindo ao TrainingCenter') . '?=';
            $mail->Body = '
                    <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    </head>
                    <body style="max-width: 500px; margin: 0 auto; text-align: center;">
                        <div style="background-color: #f0f0f0; padding: 20px; text-align: center;">

                        </div>
                        <div style="max-width:100%; padding: 20px; text-align: justify;">
                            <h1 style="max-width: 100%; font-weight: bold; font-size:14pt; margin-bottom: 15px;">
                                Iniciar Sessão
                            </h1>
                            <h2 style="max-width: 100%; font-weight: normal; font-size:12pt; margin-bottom: 15px;">
                                Seja-Bem Vindo, '.$name.'. <br><br>
                                Abaixo tens a sua Palavra-Passe para Inicio de Sessão
                            </h2>
                            <h1 style="max-width: 100%; font-weight: bold; font-size:14pt; margin-bottom: 15px; color:darkblue;">
                                '.$password.'
                            </h1>
                            <p style="max-width: 100%; font-weight: normal; font-size:12pt; margin-bottom: 10px;">
                                Deverá alterar a Palavra-Passe para uma a sua escolha.
                            </p>
                            <i style="max-width: 100%; font-weight: normal; font-size:8pt; margin-bottom: 20px;">
                                Esta é uma mensagem automática, por favor, não responda.
                            </i>

                            <p style="max-width: 100%; font-weight: normal; font-size:12pt; margin-bottom: 10px;">
                                Obrigado, <br> Equipa Training Center
                            </p>
                        </div>
                        <div style="background-color: #f0f0f0; padding: 20px; text-align: center; border-top:1px solid darkblue; gap:15px;">

                        </div>
                    </body>
                    </html>
                    ';

            // Envio do e-mail
            $mail->send();
            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }
}
