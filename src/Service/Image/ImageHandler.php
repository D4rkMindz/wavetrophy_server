<?php


namespace App\Service\Image;


use App\Service\UUID\UUID;
use Slim\Http\UploadedFile;

class ImageHandler
{
    public function saveImage(UploadedFile $file)
    {
        $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        $basename = UUID::generate();
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $publicPath = __DIR__ . '/../../../public/';
        $path = 'img/cache/i_' . date('ymd') . '/';
        if (!is_dir($path)) {
            mkdir($path);
        }

        $path .= $filename;

        $imagePath = $publicPath . $path;

        $file->moveTo($imagePath);

        return $path;
    }
}
