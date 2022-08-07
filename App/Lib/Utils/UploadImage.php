<?php

namespace App\Lib\Utils;

/**
 * Classe responsável pro genreciar os uploads de imagem
 */
class UploadImage
{
    /***Propriedade que armazena o nome da imagem sem extensão @var string $imgName */
    private string $imgName;

    /***Propriedade que armazena a extensão da imagem sem '.' (ponto) @var string $imgExtension */
    private string $imgExtension;

    /***Propriedade que armazena o tipo da imagem [type/extension]@var string $imgType */
    private string $imgType;

    /***propriedade que armazena o nome e caminho temporário da imagem @var string $tmpName */
    private string $tmpName;

    /***Propriedade que armazena o código de erro de upload da imagem @var int $uploadError */
    private int $uploadError;

    /***Propriedade que armazena o tamanho da imagem @var int $imgSize */
    private int $imgSize;

    /***Contator de nomes duplicadas de imagens @var int $imagesNameDuplicates */
    private int $imagesNameDuplicates = 0;

    /***Propriedade que armazena as extensões de aquivo permitido para o upload @var array|string[] $extensions */
    private array $extensions = IMG_EXTENSIONS;

    /*** Propriedade que armazena o tamnho limite para o arquivo de imagem @var int $maxImageSize */
    private int $maxImageSize = IMG_MAX_SIZE;

    /**
     * Método resposável por setar os valores das propriedades da classe
     * @param array $dataFile recebe $_FILES[key]
     */
    public function __construct(array $dataFile)
    {
        $this->imgType = $dataFile['type'];
        $this->tmpName = $dataFile['tmp_name'];
        $this->uploadError = $dataFile['error'];
        $this->imgSize = $dataFile['size'];

        $fileInfo = pathinfo($dataFile['name']);
        $this->imgName = $fileInfo['filename'];
        $this->imgExtension = $fileInfo['extension'];
    }

    /**
     * Método responsável por mover o arquivo para a pasta de ‘uploads’ de imagem
     * @param string $filePath Caminho da pasta
     * @param bool $overWriteImage Sobrescrever imagem com mesmo nome
     * @return bool
     */
    public function uploadImage(string $filePath, bool $overWriteImage = false): bool
    {
        if (!$this->validateImg()) {
            return false;
        }

        $path = "{$filePath}/{$this->getPossibleName($filePath, $overWriteImage)}";
        move_uploaded_file($this->tmpName, $path);

        return true;
    }

    /**
     * Método responsável por gerar um nome possível para a imagem
     * @param string $filePath Caminho da pasta
     * @param bool $overWriteImage Sobrescrever imagem
     * @return string
     */
    private function getPossibleName(string $filePath, bool $overWriteImage): string
    {
        if ($overWriteImage) return $this->getBaseName();

        $baseName = $this->getBaseName();
        if (!file_exists("{$filePath}/{$baseName}")) return $baseName;

        $this->imagesNameDuplicates++;

        return $this->getPossibleName($filePath, $overWriteImage);
    }

    /**
     * Método responsável por retornar o nome do aquivo com extensão
     * @return string
     */
    public function getBaseName(): string
    {
        $extension = strlen($this->imgExtension) ? '.' . $this->imgExtension : '';

        $nameImageIncrement = $this->imagesNameDuplicates > 0 ? '-' . $this->imagesNameDuplicates : '';

        return $this->imgName . $nameImageIncrement . $extension;
    }

    /**
     * Método responsável por adicionar diretamente um nome para a imagem
     * @param string $imgName
     * @return void
     */
    public function setImageName(string $imgName): void
    {
        $this->imgName = $imgName;
    }

    /**
     * Método responsável por gerar um nome aleatório para a imagem
     * @param string|null $text [Opcional]Texto para incrementar ao nome aleatório
     * @return void
     */
    public function generateRandomImageName(string|null $text = null): void
    {
        if ($text) {
            $this->imgName = "Image-Bank-{$text}";
        } else {
            $this->imgName = "Image-Bank-" . time() . rand(100000, 999999) . '-' . uniqid();
        }
    }

    /**
     * Método responsável por validar o arquivo de imagem
     * @return bool
     */
    private function validateImg(): bool
    {
        $imgType = explode('/', $this->imgType);
        if ($this->uploadError != 0 || strtolower($imgType[0] != 'image')) {
            return false;
        } else if ($this->imgSize > $this->maxImageSize) {
            return false;
        } else if (!array_search(strtolower($imgType[1]), $this->extensions)) {
            return false;
        }

        return true;
    }

    /**
     * Método responsável por criar instâncias de UploadImg para cada imagem
     * @param array $dataFiles $dataFiles $_FILES[key]
     * @return array Array com valores das imagens e instâncias de UploadImage
     */
    public static function createMultiImagesUploads(array $dataFiles): array
    {
        $imagesUploads = [];

        foreach ($dataFiles['name'] as $key => $dataValue) {
            $file = [
                'name' => $dataFiles['name'][$key],
                'type' => $dataFiles['type'][$key],
                'tmp_name' => $dataFiles['tmp_name'][$key],
                'size' => $dataFiles['size'][$key],
                'error' => $dataFiles['error'][$key],
            ];

            $imagesUploads[] = new UploadImage($file);
        }

        return $imagesUploads;
    }

    /**
     * Retorna o nome da imagem
     * @return string
     */
    public function getImgName(): string
    {
        return $this->imgName;
    }

    /**
     * Método responsável por retornar a extensão do arquivo de imagem
     * @return string
     */
    public function getImgExtension(): string
    {
        return $this->imgExtension;
    }
}