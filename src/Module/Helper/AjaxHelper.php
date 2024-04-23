<?php declare(strict_types=1);

namespace Xmf\Module\Helper;

use Xmf\Request;

class AjaxHelper
{
    protected array $response;
    protected array $eventHandlers;

    public function __construct()
    {
        $this->response = [
            'success' => false,
            'message' => '',
            'data' => [],
        ];
        $this->eventHandlers = [];
    }

    public function addContent(string $content): void
    {
        $this->response['content'] = $content;
    }

    public function addData(string $key, $value): void
    {
        $this->response['data'][$key] = $value;
    }

    public function setSuccess(bool $success): void
    {
        $this->response['success'] = $success;
    }

    public function setMessage(string $message): void
    {
        $this->response['message'] = $message;
    }

    public function sendResponse(): void
    {
        header('Content-Type: application/json');
        echo json_encode($this->response);
        exit;
    }

    public function sendErrorResponse(string $message): void
    {
        $this->setSuccess(false);
        $this->setMessage($message);
        $this->sendResponse();
    }

    public function addSmartyPartial(string $template, array $data = [], ?\Smarty $smarty = null): void
    {
        $smarty = $smarty ?? $GLOBALS['xoopsTpl'];
        $smarty->assign($data);
        $renderedTemplate = $smarty->fetch($template);
        $this->addContent($renderedTemplate);
    }

    public function addHTMLSnippet(string $html): void
    {
        $this->addContent($html);
    }

    public function on(string $event, string $selector, callable $callback): void
    {
        $this->eventHandlers[] = [
            'event'    => $event,
            'selector' => $selector,
            'callback' => $callback,
        ];
    }

    public function execute(): void
    {
        // Verify XOOPS token to prevent CSRF attacks
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $this->sendErrorResponse('Invalid XOOPS token');
            return;
        }

        // Add your custom logic here based on the AJAX request parameters
        // Example:
        // $action = Request::getVar('action', '');
        // if ($action === 'someAction') {
        //     $this->handleSomeAction();
        // } else {
        //     $this->sendErrorResponse('Invalid action');
        // }

        $event    = Request::getVar('event', '');
        $selector = Request::getVar('selector', '');
        $data     = Request::getVar('data', '');

        if (empty($event) || empty($selector)) {
            $this->sendErrorResponse('Missing or invalid request parameters');
            return;
        }

        foreach ($this->eventHandlers as $handler) {
            if ($handler['event'] === $event && $handler['selector'] === $selector) {
                try {
                    $callback = $handler['callback'];
                    $callback($data);
                    $this->sendResponse();
                } catch (\Exception $e) {
                    // Log the exception using XOOPS logger
                    $GLOBALS['xoopsLogger']->addError($e->getMessage());
                    $this->sendErrorResponse('An error occurred while processing the request');
                }
                return;
            }
        }

        $this->sendErrorResponse('No matching event handler found');
    }



    // Add more methods as needed for handling specific AJAX actions
    // Example:
    // protected function handleSomeAction(): void
    // {
    //     // Perform some action and add data to the response
    //     $this->addData('key', 'value');
    //     $this->setSuccess(true);
    //     $this->setMessage('Action completed successfully');
    // }
}


//Usage Example:

//use Xmf\Module\Helper\AjaxHelper;
//
//$ajaxHelper = new AjaxHelper();
//$ajaxHelper->addSmartyPartial('path/to/partial.tpl', ['name' => 'John Doe']);
//$ajaxHelper->addHTMLSnippet('<div class="alert">Hello, world!</div>');
//$ajaxHelper->sendResponse();
