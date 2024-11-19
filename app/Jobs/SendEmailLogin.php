<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendEmailLogin implements ShouldQueue
{
    use Queueable;

    protected $email;
    protected $code;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $code)
    {
        $this->email = $email;
        $this->code = $code;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
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
            $mail->addAddress(''.$this->email.'', '');

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
                                '.$this->code.'
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
            //return true;
        } catch (Exception $e) {
            \Log::error('Erro ao enviar e-mail: ' . $mail->ErrorInfo);
        }
    }
}
