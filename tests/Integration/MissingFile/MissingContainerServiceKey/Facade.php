<?php

declare(strict_types=1);

namespace GacelaTest\Integration\MissingFile\MissingContainerServiceKey;

use Gacela\AbstractFacade;

/**
 * @method Factory getFactory()
 */
final class Facade extends AbstractFacade
{
    public function error(): void
    {
        $this->getFactory()->createDomainService();
    }
}