<?php

namespace Phalbee\Base;

class Model extends \Phalcon\Mvc\Model
{
    public function initialize($driver = 'db')
    {
        $db = $this->getDI()->get($driver)->getDescriptor();
        if (array_key_exists('prefix', $db))
            $this->setSource($db['prefix'].strtolower(substr(strrchr(get_class($this), "\\"), 1)));
        else
            $this->setSource(strtolower(substr(strrchr(get_class($this), "\\"), 1)));
    }
}
