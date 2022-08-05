<?php

namespace App\Controllers;

use App\Controllers\Template\TemplateController;
use App\Lib\Controllers\Page;
use App\Lib\Utils\Error;
use App\Lib\Utils\UploadImage;
use App\Lib\Views\Render\View;
use App\Lib\Utils\Session;

class ImageController extends Page
{
    private string $message;

    public function __construct()
    {
        $content = View::render('form/form-img', [
            'ERROR' => Session::returnMessageValue()
        ]);

        echo TemplateController::getTemplate('Upload de Imagens', $content);
        Session::clearMessage();
    }

    public function upload(): void
    {
        if (isset($_FILES['image'])) {
            $imgUploads = UploadImage::createMultiImagesUploads($_FILES['image']);

            foreach ($imgUploads as $objImgUpload) {
                $objImgUpload->generateRandomImageName();
                $sucess = $objImgUpload->uploadImage(__DIR__ . '/../../files');
                if (!$sucess) {
                    Session::recordMessage('Erro ao enviar o arquivo');
                } else {
                    Session::recordMessage("Arquivo enviado com sucesso!");
                }
            }
        }

        $this->redirect('image');
    }
}