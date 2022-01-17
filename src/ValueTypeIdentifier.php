<?php

declare(strict_types=1);

namespace webignition\BasilValueTypeIdentifier;

class ValueTypeIdentifier
{
    public function isBrowserProperty(string $value): bool
    {
        return '$browser.size' === $value;
    }

    public function isDataParameter(string $value): bool
    {
        return preg_match('/^\$data\..+/', $value) > 0;
    }

    public function isEnvironmentValue(string $value): bool
    {
        return preg_match('/^\$env\..+/', $value) > 0;
    }

    public function isLiteralValue(string $value): bool
    {
        return '' !== $value && '"' === $value[0] && '"' === $value[-1];
    }

    public function isPageProperty(string $value): bool
    {
        return preg_match('/^\$page\..+/', $value) > 0;
    }

    public function isScalarValue(string $value): bool
    {
        return $this->isBrowserProperty($value)
            || $this->isDataParameter($value)
            || $this->isEnvironmentValue($value)
            || $this->isLiteralValue($value)
            || $this->isPageProperty($value);
    }
}
