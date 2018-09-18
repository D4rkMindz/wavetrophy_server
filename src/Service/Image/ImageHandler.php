<?php


namespace App\Service\Image;


use App\Service\UUID\UUID;
use Slim\Container;
use Slim\Http\UploadedFile;

class ImageHandler
{
    private $imagePath;

    public function __construct(Container $container)
    {
        $this->imagePath = $container->get('settings')->get('image')['path'];
    }

    public function saveImage(UploadedFile $file)
    {
        $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        $basename = UUID::generate();
        $filename = sprintf('%s.%0.8s', $basename, $extension);


        $imagePath = $this->imagePath . $filename;

        $file->moveTo($imagePath);

        return 'v1/img/' . $filename;
    }
}
