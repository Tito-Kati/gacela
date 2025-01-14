<?php

declare(strict_types=1);

namespace Gacela\Framework\Config\GacelaFileConfig;

use Gacela\Framework\Config\ConfigReader\PhpConfigReader;
use Gacela\Framework\Config\ConfigReaderInterface;
use function get_class;

final class GacelaConfigItem
{
    private const DEFAULT_PATH = 'config/*.php';
    private const DEFAULT_PATH_LOCAL = 'config/local.php';

    private string $path;
    private string $pathLocal;
    private ConfigReaderInterface $reader;

    public function __construct(
        string $path = self::DEFAULT_PATH,
        string $pathLocal = self::DEFAULT_PATH_LOCAL,
        ?ConfigReaderInterface $reader = null
    ) {
        $this->path = $path;
        $this->pathLocal = $pathLocal;
        $this->reader = $reader ?? new PhpConfigReader();
    }

    /**
     * @param array{path?:string, path_local?:string, reader?:ConfigReaderInterface|class-string} $item
     */
    public static function fromArray(array $item): self
    {
        $reader = new PhpConfigReader();

        if (isset($item['reader']) && is_string($item['reader'])) {
            /** @psalm-suppress MixedMethodCall */
            $reader = new $item['reader']();
            assert($reader instanceof ConfigReaderInterface);
        }

        return new self(
            $item['path'] ?? self::DEFAULT_PATH,
            $item['path_local'] ?? self::DEFAULT_PATH_LOCAL,
            $reader
        );
    }

    public static function withDefaults(): self
    {
        return self::fromArray([]);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function pathLocal(): string
    {
        return $this->pathLocal;
    }

    public function reader(): ConfigReaderInterface
    {
        return $this->reader;
    }

    public function __toString(): string
    {
        return sprintf(
            'GacelaConfigItem{path:%s, pathLocal:%s, reader:%s}',
            $this->path,
            $this->pathLocal,
            get_class($this->reader)
        );
    }
}
