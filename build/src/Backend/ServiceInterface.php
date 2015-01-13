<?php

namespace Heise\Shariff\Backend;

interface ServiceInterface
{
    public function getRequest($url);
    public function extractCount($data);
    public function getName();
}
