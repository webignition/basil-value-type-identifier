<?php

declare(strict_types=1);

namespace webignition\BasilValueTypeIdentifier\Tests\Unit;

use PHPUnit\Framework\TestCase;
use webignition\BasilValueTypeIdentifier\ValueTypeIdentifier;

class ValueTypeIdentifierTest extends TestCase
{
    private ValueTypeIdentifier $identifier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->identifier = new ValueTypeIdentifier();
    }

    /**
     * @dataProvider isNotBrowserPropertyDataProvider
     * @dataProvider isBrowserPropertyDataProvider
     */
    public function testIsBrowserPropertyFoo(string $value, bool $expectedIs)
    {
        self::assertSame($expectedIs, $this->identifier->isBrowserProperty($value));
    }

    public function isNotBrowserPropertyDataProvider(): array
    {
        return [
            'browser property: not prefixed' => [
                'value' => 'value',
                'expectedIs' => false,
            ],
            'browser property: not size property' => [
                'value' => '$browser.property',
                'expectedIs' => false,
            ],
        ];
    }

    public function isBrowserPropertyDataProvider(): array
    {
        return [
            'browser property: $browser.size' => [
                'value' => '$browser.size',
                'expectedIs' => true,
            ],
        ];
    }

    /**
     * @dataProvider isNotDataParameterDataProvider
     * @dataProvider isDataParameterDataProvider
     */
    public function testIsDataParameter(string $value, bool $expectedIs)
    {
        self::assertSame($expectedIs, $this->identifier->isDataParameter($value));
    }

    public function isNotDataParameterDataProvider(): array
    {
        return [
            'data parameter: not prefixed' => [
                'value' => 'value',
                'expectedIs' => false,
            ],
            'data parameter: no dot separating prefix from key' => [
                'value' => '$datakey',
                'expectedIs' => false,
            ],
        ];
    }

    public function isDataParameterDataProvider(): array
    {
        return [
            'data parameter: has dot separating prefix from key' => [
                'value' => '$data.key',
                'expectedIs' => true,
            ],
            'data parameter: has supplemental dot separating prefix from key' => [
                'value' => '$data.key.key',
                'expectedIs' => true,
            ],
        ];
    }

    /**
     * @dataProvider isNotEnvironmentValueDataProvider
     * @dataProvider isEnvironmentValueDataProvider
     */
    public function testIsEnvironmentValue(string $value, bool $expectedIs)
    {
        self::assertSame($expectedIs, $this->identifier->isEnvironmentValue($value));
    }

    public function isNotEnvironmentValueDataProvider(): array
    {
        return [
            'environment value: not prefixed' => [
                'value' => 'value',
                'expectedIs' => false,
            ],
            'environment value: no dot separating prefix from key' => [
                'value' => '$envkey',
                'expectedIs' => false,
            ],
        ];
    }

    public function isEnvironmentValueDataProvider(): array
    {
        return [
            'environment value: has dot separating prefix from key' => [
                'value' => '$env.key',
                'expectedIs' => true,
            ],
            'environment value: has supplemental dot separating prefix from key' => [
                'value' => '$env.key.key',
                'expectedIs' => true,
            ],
        ];
    }

    /**
     * @dataProvider isNotLiteralValueDataProvider
     * @dataProvider isLiteralValueDataProvider
     */
    public function testIsLiteralValue(string $value, bool $expectedIs)
    {
        self::assertSame($expectedIs, $this->identifier->isLiteralValue($value));
    }

    public function isNotLiteralValueDataProvider(): array
    {
        return [
            'literal value: not quoted' => [
                'value' => 'literal',
                'expectedIs' => false,
            ],
            'literal value: dollar-prefixed' => [
                'value' => '$literal',
                'expectedIs' => false,
            ],
            'literal value: leading quote only' => [
                'value' => '"literal',
                'expectedIs' => false,
            ],
            'literal value: trailing quote only' => [
                'value' => 'literal"',
                'expectedIs' => false,
            ],
        ];
    }

    public function isLiteralValueDataProvider(): array
    {
        return [
            'literal value: leading and trailing quotes' => [
                'value' => '"literal"',
                'expectedIs' => true,
            ],
        ];
    }

    /**
     * @dataProvider isNotPagePropertyDataProvider
     * @dataProvider isPagePropertyDataProvider
     */
    public function testIsPageProperty(string $value, bool $expectedIs)
    {
        self::assertSame($expectedIs, $this->identifier->isPageProperty($value));
    }

    public function isNotPagePropertyDataProvider(): array
    {
        return [
            'page property: not prefixed' => [
                'value' => 'value',
                'expectedIs' => false,
            ],
        ];
    }

    public function isPagePropertyDataProvider(): array
    {
        return [
            'page property: $page.url' => [
                'value' => '$page.url',
                'expectedIs' => true,
            ],
            'page property: $page.title' => [
                'value' => '$page.title',
                'expectedIs' => true,
            ],
        ];
    }

    /**
     * @dataProvider isNotBrowserPropertyDataProvider
     * @dataProvider isNotDataParameterDataProvider
     * @dataProvider isNotEnvironmentValueDataProvider
     * @dataProvider isNotLiteralValueDataProvider
     * @dataProvider isNotLiteralValueDataProvider
     * @dataProvider isBrowserPropertyDataProvider
     * @dataProvider isDataParameterDataProvider
     * @dataProvider isEnvironmentValueDataProvider
     * @dataProvider isLiteralValueDataProvider
     * @dataProvider isLiteralValueDataProvider
     */
    public function testIsScalarValue(string $value, bool $expectedIs)
    {
        self::assertSame($expectedIs, $this->identifier->isScalarValue($value));
    }
}
