<?php
namespace Helper;

use Exception\ViewNotFoundException;
use Helper\Response;
use Helper\ServiceContainer;

/**
 * Class Controller
 * @package Controller
 * @author Yann Le Scouarnec <yann.le-scouarnec@hetic.net>
 */
abstract class Controller
{
    /**
     * @param $view
     * @param array $data
     * @param int $status
     * @param array $headers
     * @throws ViewNotFoundException
     * @return Response
     */
    protected function render($view, $data = [], $status = null, $headers = null)
    {
        if (!file_exists(APP_VIEW_DIR.$view)) {
            throw new ViewNotFoundException('View '.$view.' not found.');
        }
        $request = ServiceContainer::getService('Request');
        if (isset($request->GET[APP_JSON_QUERY_STRING_FLAG])) {
            $output = json_encode($data);
        } else {
            ob_start();
            extract($data);
            require APP_VIEW_DIR.$view;
            $output = ob_get_contents();
            ob_end_clean();
        }
        /** @var Response $reponse */
        $reponse = ServiceContainer::getService('Response');

        return $reponse->addBody($output)
            ->setStatus($status)
            ->addHeader($headers);
    }
}
