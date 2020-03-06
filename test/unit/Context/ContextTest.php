<?php

declare(strict_types=1);

namespace Wcomnisky\Flagship\UnitTests\Context;

use PHPUnit\Framework\TestCase;
use Wcomnisky\Flagship\Context\Context;

class ContextTest extends TestCase
{
    /**
     * @covers \Wcomnisky\Flagship\Context\Context
     */
    public function test_successful_new_instance()
    {
        $context = new Context();
        $this->assertInstanceOf(Context::class, $context);
    }

    /**
     * @covers \Wcomnisky\Flagship\Context\Context::getList
     */
    public function test_getList_returns_empty_array_by_default()
    {
        $context = new Context();
        $this->assertSame([], $context->getList());
    }

    /**
     * @covers \Wcomnisky\Flagship\Context\Context::add
     * @uses \Wcomnisky\Flagship\Context\Context::getList
     */
    public function test_successful_add()
    {
        $context = new Context();
        $this->assertSame([], $context->getList());

        $context->add('key1', 'value1');
        $context->add('key2', 'value2');
        $this->assertSame(
            [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            $context->getList()
        );
    }

    /**
     * @covers \Wcomnisky\Flagship\Context\Context::set
     * @uses \Wcomnisky\Flagship\Context\Context::getList
     */
    public function test_successful_set()
    {
        $context = new Context();
        $this->assertSame([], $context->getList());

        $expected = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $context->set($expected);

        $this->assertSame(
            $expected,
            $context->getList()
        );
    }

    /**
     * @covers \Wcomnisky\Flagship\Context\Context::set
     * @uses \Wcomnisky\Flagship\Context\Context::add
     * @uses \Wcomnisky\Flagship\Context\Context::getList
     */
    public function test_set_overrides_predefined_context_list()
    {
        $context = new Context();
        $this->assertSame([], $context->getList());

        $context->add('key1', 'value1');
        $this->assertSame(['key1' => 'value1'], $context->getList());

        $expected = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $context->set($expected);

        $this->assertSame(
            $expected,
            $context->getList()
        );
    }
}
