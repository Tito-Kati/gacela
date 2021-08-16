<?php

declare(strict_types=1);

namespace Gacela\Framework\Config\GacelaFileConfig;

final class GacelaConfigItem
{
    public const DEFAULT_TYPE = 'php';

    private const DEFAULT_PATH = 'config/*.php';
    private const DEFAULT_PATH_LOCAL = 'config/local.php';

    private string $type;
    private string $path;
    private string $pathLocal;

    /**
     * @param array<array-key, mixed> $item
     */
    public static function fromArray(array $item): self
    {
        return new self(
            (string)($item['type'] ?? self::DEFAULT_TYPE),
            (string)($item['path'] ?? self::DEFAULT_PATH),
            (string)($item['path_local'] ?? self::DEFAULT_PATH_LOCAL)
        );
    }

    public static function withDefaults(): self
    {
        return new self();
    }

    private function __construct(
        string $type = self::DEFAULT_TYPE,
        string $path = self::DEFAULT_PATH,
        string $pathLocal = self::DEFAULT_PATH_LOCAL
    ) {
        $this->type = $type;
        $this->path = $path;
        $this->pathLocal = $pathLocal;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function pathLocal(): string
    {
        return $this->pathLocal;
    }

    public function __toString(): string
    {
        return sprintf(
            'GacelaConfigItem{ type:%s, path:%s, pathLocal:%s }',
            $this->type,
            $this->path,
            $this->pathLocal
        );
    }
}