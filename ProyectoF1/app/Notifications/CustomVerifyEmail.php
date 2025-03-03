<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends VerifyEmail
{
    /**
     * Get the verification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Verificación de correo - F1 Stats')
            ->greeting('¡Bienvenido a F1 Stats!')
            ->line('¡Gracias por registrarte en F1 Stats, tu portal definitivo de estadísticas de Fórmula 1!')
            ->line('Para comenzar a explorar toda la información sobre pilotos, equipos y carreras, por favor verifica tu dirección de correo electrónico.')
            ->action('Verificar correo electrónico', $url)
            ->line('Este enlace de verificación expirará en 60 minutos.')
            ->line('Si no has creado una cuenta, no es necesario realizar ninguna acción.')
            ->salutation('Saludos, el equipo de F1 Stats');
    }
}
