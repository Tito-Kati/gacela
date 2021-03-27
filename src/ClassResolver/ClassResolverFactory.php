<?php

declare(strict_types=1);

namespace Gacela\ClassResolver;

use Gacela\AbstractFactory;
use Gacela\ClassResolver\ClassNameFinder\ClassNameFinder;
use Gacela\ClassResolver\ClassNameFinder\ClassNameFinderInterface;
use Gacela\ClassResolver\ClassNameFinder\Rule\FinderRuleWithModulePrefix;
use Gacela\ClassResolver\ClassNameFinder\Rule\FinderRuleWithoutModulePrefix;

final class ClassResolverFactory extends AbstractFactory
{
    public function createClassNameFinder(): ClassNameFinderInterface
    {
        return new ClassNameFinder(
            new FinderRuleWithModulePrefix(),
            new FinderRuleWithoutModulePrefix(),
        );
    }
}
