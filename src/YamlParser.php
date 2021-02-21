<?php


namespace Tobexkee\Deployer;


use ArrayAccess;
use Tobexkee\Deployer\Exceptions\InvalidConfigFileException;
use Tobexkee\Deployer\Exceptions\MissingConfigFileException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlParser implements ArrayAccess
{
    protected static  $instance;

    protected static  array $rules;

    protected static  string $rulesPath;

    private function __construct()
    {
        self::$rulesPath = __DIR__."/../deploy.yaml";
        self::$rules = [];
    }

    public static function getInstance(): static
    {
        if (!self::$instance) {
            self::$instance = (new static);
            self::$instance->loadRules();
        }
        return self::$instance;
    }

    public function offsetExists($offset): bool
    {
        return isset(self::$rules[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return self::$rules[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        self::$rules[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset(self::$rules[$offset]);
    }

    protected function loadRules(): void
    {
        if (self::rulesPathIsValid()) {
            try{
                self::$rules  = Yaml::parseFile(self::$rulesPath);
            } catch (ParseException $exception) {
                throw new InvalidConfigFileException($exception->getMessage());
            }
        }
    }

    protected function rulesPathIsValid(): bool
    {
        if (!is_file(self::$rulesPath)) {
            throw new MissingConfigFileException(
                sprintf(
                    "The %s file cannot be found at the base directory",
                    self::$rulesPath
                )
            );
        }
        return true;
    }
}