<?php
namespace app\controller\lucky;

class Config extends \app\controller\Base
{
    public function get() {
        $params = $this->_GET;
        return $params;
    }
}
