<?php

declare(strict_types=1);

namespace Gacela\Framework;

use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use RuntimeException;

final class Config
{
    /**
     * This file config/local.php could be ignore in your project, and it will be read the last one
     * so it will override every possible value.
     */
    private const CONFIG_LOCAL_FILENAME = 'local.php';

    private static string $applicationRootDir = '';
    private static array $config = [];
    private static ?self $instance = null;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param mixed|null $default
     *
     * @throws Exception
     *
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        if (empty(self::$config)) {
            self::init();
        }

        if ($default !== null && !self::hasValue($key)) {
            return $default;
        }

        if (!self::hasValue($key)) {
            throw new RuntimeException(sprintf(
                'Could not find config key "%s" in "%s"',
                $key,
                self::class
            ));
        }

        return self::$config[$key];
    }

    public static function init(): void
    {
        $configs = [];

        foreach (self::scanAllConfigFiles() as $filename) {
            $fileNameOrDir = self::fullPath($filename);
            if (is_dir($fileNameOrDir)) {
                foreach (self::createRecursiveIterator($fileNameOrDir) as $fileInfo) {
                    if (self::isPhpFile($fileInfo[0])) {
                        $configs[] = self::readConfigFromFile($fileInfo[0]);
                    }
                }
            } elseif (self::isPhpFile($fileNameOrDir)) {
                $configs[] = self::readConfigFromFile($fileNameOrDir);
            }
        }

        $configs[] = self::readConfigFromFile(self::fullPath(self::CONFIG_LOCAL_FILENAME));

        self::$config = array_merge(...$configs);
    }

    private static function scanAllConfigFiles(): array
    {
        $configDir = self::getApplicationRootDir() . '/config/';
        if (!is_dir($configDir)) {
            throw new RuntimeException('"config" directory not found on application root dir');
        }

        return array_diff(
            scandir($configDir),
            ['..', '.', self::CONFIG_LOCAL_FILENAME]
        );
    }

    public static function getApplicationRootDir(): string
    {
        if (empty(self::$applicationRootDir)) {
            self::$applicationRootDir = getcwd() ?: '';
        }

        return self::$applicationRootDir;
    }

    public static function setApplicationRootDir(string $dir): void
    {
        self::$applicationRootDir = $dir;
    }

    private static function fullPath(string $fileNameOrDir): string
    {
        return self::getApplicationRootDir() . '/config/' . $fileNameOrDir;
    }

    private static function createRecursiveIterator(string $path): RegexIterator
    {
        return new RegexIterator(
            new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)),
            '/^.+\.php$/i',
            RecursiveRegexIterator::GET_MATCH
        );
    }

    private static function isPhpFile(string $path): bool
    {
        return is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php';
    }

    private static function readConfigFromFile(string $file): array
    {
        if (file_exists($file)) {
            $content = include $file;
            return is_array($content) ? $content : [];
        }

        return [];
    }

    public static function hasValue(string $key): bool
    {
        return isset(self::$config[$key]);
    }
}
