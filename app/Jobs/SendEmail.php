<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\SendEmailController;

class SendEmail implements ShouldQueue
{
    use Queueable;

    protected $email;
    protected $code;
    protected $password;
    protected $type;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $type, $options = [])
    {
        $this->email = $email;
        $this->type = $type;
        $this->code = $options['code'] ?? null;
        $this->password = $options['password'] ?? null;
    }

    /**
     * Execute the job.
     */
    public function handle(SendEmailController $sendEmailController): void
    {
        switch ($this->type) {
            case 1:
                // Enviar email para verificação de identidade
                $sendEmailController->codeToVerifyIdentity($this->email, $this->code);
                break;
            case 2:
                // Enviar email de recuperação de senha
                $sendEmailController->sendRecoverPassEmail($this->email, $this->code);
                break;
            case 3:
                // Enviar email de boas-vindas
                $sendEmailController->sendWelcomeEmail($this->email, $this->password);
                break;
            default:
                \Log::error("Tipo de email inválido: {$this->type}");
                break;
        }
    }
}
