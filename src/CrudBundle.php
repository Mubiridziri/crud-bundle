<?php

namespace Mubiridziri\Crud;

use Mubiridziri\Crud\DependencyInjection\CrudBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CrudBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new CrudBundleExtension();
        }
        return $this->extension;
    }
}