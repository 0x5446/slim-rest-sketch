<?php
namespace App\Controller;

class Base
{

    public $request;
    public $response;
    public $_GET;
    public $_DATA;

    public function __construct($request, $response) {
        parse_str($request->getUri()->getQuery(), $this->_GET);
        $this->_DATA = $request->getParsedBody();
        $this->request = $request;
        $this->response = $response;
    }

    public function __call($method, $params) {
        throw new \Exception($method . ' not implemented');
    }
}
