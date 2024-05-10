<?php

namespace OrangePortfolio\Core\Domain\Helpers;

use Assert\Assert;
class ValidateParams
{
    public static function validateString(array $params, array $fields, bool $required=true): void
    {
        array_map(static function ($key) use ($params, $required) {
            if ($required) {
                Assert::that($params[$key])
                ->notNull("O campo '$key' é obrigatório");
            }

            if (! $required && ! isset($params[$key])) return;
            Assert::that($params[$key])
                ->string("O campo '$key' deve ser uma string")
                ->notEmpty("O campo '$key' não pode estar vazio");
        }, $fields);
    }

    public static function validateInteger(array $params, array $fields, bool $required=true): void
    {
        array_map(static function ($key) use ($params, $required) {
            if ($required) {
                Assert::that($params[$key])
                    ->notNull("O campo '$key' é obrigatório");
            }

            if (! $required && ! isset($params[$key])) return;
            Assert::that($params[$key])
                ->integerish("O campo '$key' deve ser um número");
        }, $fields);
    }

    public static function validateIntegerArray(array $params, array $fields, bool $required=true): void
    {
        array_map(static function ($key) use ($params, $required) {
            if ($required) {
                Assert::that($params[$key])
                    ->notNull("O campo '$key' é obrigatório");
            }

            if (! $required && ! isset($params[$key])) return;
            Assert::that($params[$key])
                ->isArray("O campo '$key' deve ser um array");

            /** @var array $array */
            $array = $params[$key];
            array_map(static function ($value) use ($key) {
                Assert::that($value)
                    ->integerish("O campo '$key' deve ser um array de inteiros");
            }, $array);
        }, $fields);
    }
}