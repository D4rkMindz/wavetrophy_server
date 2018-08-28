<?php


namespace App\Controller;


use App\Service\Image\ImageHandler;
use App\Service\Response\JSONResponse;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class UploadController extends AppController
{
    /**
     * @var ImageHandler
     */
    private $imageHandler;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->imageHandler = $container->get(ImageHandler::class);
    }

    /**
     * Controller Action.
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function uploadImageAction(Request $request, Response $response, array $args): ResponseInterface
    {
        $uploadedFiles = $request->getUploadedFiles();
        /** @var UploadedFile $file */
        $file = $uploadedFiles['image'];
        if ($file->getError() === UPLOAD_ERR_OK) {
            $url = $this->imageHandler->saveImage($file);
        }
        $responseData = JSONResponse::success(['url' => $url]);
        return $this->json($response, $responseData);
    }
}
