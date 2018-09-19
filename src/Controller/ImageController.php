<?php
/**
 * Created by PhpStorm.
 * User: bjorn
 * Date: 18.09.18
 * Time: 08:15
 */

namespace App\Controller;


use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ImageController extends AppController
{
    private $imagePath;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->imagePath = $container->get('settings')->get('image')['path'];
    }

    public function getImageAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $imagePath = $this->imagePath . $args['image'];

        if (!file_exists($imagePath)) {
            return $response->withStatus(404);
        }

        $image = file_get_contents($imagePath);
        $imageType = exif_imagetype($imagePath);
        $mime = image_type_to_mime_type($imageType);
        $response->write($image);
        return $response->withHeader('Content-Type', $mime)->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'Authentication, X-App-Language, X-Token, Content-Type')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
