<?php

declare(strict_types=1);

namespace Gacela\ClassResolver;

use Gacela\Exception\Backtrace;

trait ClassResolverExceptionTrait
{
    private function buildMessage(ClassInfo $callerClassInfo, string $resolvableType): string
    {
        $message = 'ClassResolver Exception' . PHP_EOL;
        $message .= sprintf(
            'Cannot resolve %1$s%2$s for your module "%1$s"',
            $callerClassInfo->getModule(),
            $resolvableType
        ) . PHP_EOL;

        $message .= sprintf(
            'You can fix this by adding the missing %s to your module.',
            $resolvableType
        ) . PHP_EOL;

        $message .= sprintf(
            'E.g. %s',
            $this->findClassNameExample($callerClassInfo, $resolvableType)
        ) . PHP_EOL;

        return $message . Backtrace::get();
    }

    private function findClassNameExample(ClassInfo $callerClassInfo, string $resolvableType): string
    {
        return (string)(new ClassResolverFactory())
            ->createClassNameFinder()
            ->findClassName($callerClassInfo, $resolvableType);
    }
}
