<?php

declare(strict_types=1);

namespace GacelaTest\Unit\Framework\Container;

use Gacela\Framework\Config;
use Gacela\Framework\Config\ConfigReaderInterface;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{
    private Config $config;

    public function setUp(): void
    {
        Config::resetInstance();
        $this->config = Config::getInstance();
    }

    public function tearDown(): void
    {
        Config::resetInstance();
    }

    public function test_get_undefined_key(): void
    {
        $this->expectExceptionMessageMatches('/Could not find config key "key"/');
        $this->config->get('key');
    }

    public function test_get_default_value_from_undefined_key(): void
    {
        self::assertSame('default', $this->config->get('key', 'default'));
    }

    public function test_get_using_custom_reader(): void
    {
        $this->config->setConfigReaders([
            Config\GacelaJsonConfigItem::DEFAULT_TYPE => new class() implements ConfigReaderInterface {
                public function read(string $absolutePath): array
                {
                    return ['key' => 'value'];
                }

                public function canRead(string $absolutePath): bool
                {
                    return true;
                }
            },
        ]);

        $this->config->init();

        self::assertSame('value', $this->config->get('key'));
    }
}
