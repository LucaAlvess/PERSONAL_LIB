<?php

namespace App\Lib\Utils;

use App\Lib\Utils\Error;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

/**
 * Classe reponsável por gerenciar os envios de E-mails
 */
class Email
{
    /*** Armazena a mensagem de erro @var string $error */
    private string $error;

    /**
     * Retorna a mensagem de erro
     *
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * Método responsável por enviar E-mails
     *
     * @param array|string $adresses Endereço destinatário
     * @param string $subject assunto do E-mail
     * @param string $body Conteúdo do E-mail
     * @param array|string $attachments
     * @param array|string $ccs
     * @param array|string $bccs
     * @return boolean
     */
    public function sendEmail(array|string $adresses, string $subject, string $body, array|string $attachments = [], array|string $ccs = [], array|string $bccs = []): bool
    {
        $this->Error = '';

        $obMail = new PHPMailer(true);

        try {
            $obMail->isSMTP(true);
            $obMail->Host = EMAIL_HOST;
            $obMail->SMTPAuth = true;
            $obMail->Username = EMAIL_USER;
            $obMail->Password = EMAIL_PASS;
            $obMail->SMTPSecure = EMAIL_SECURE;
            $obMail->port = EMAIL_PORT;
            $obMail->CharSet = EMAIL_CHARSET;

            $obMail->setFrom(EMAIL_REMETENTE, EMAIL_REMETENTE_NAME);

            $adresses = is_array($adresses) ? $adresses : [$adresses];
            foreach ($adresses as $address) {
                $obMail->addAddress($address);
            }

            $attachments = is_array($attachments) ? $attachments : [$attachments];
            foreach ($attachments as $attachment) {
                $obMail->addAttachment($attachment);
            }

            $ccs = is_array($ccs) ? $ccs : [$ccs];
            foreach ($ccs as $cc) {
                $obMail->addCC($cc);
            }

            $bccs = is_array($bccs) ? $bccs : [$bccs];
            foreach ($bccs as $bcc) {
                $obMail->addBCC($bcc);
            }

            $obMail->isHTML(true);
            $obMail->Subject = $subject;
            $obMail->Body = $body;

            return $obMail->send();
        } catch (PHPMailerException $e) {
            $error = new Error($e);
            return false;
        }
    }
}