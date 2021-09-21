<?php

namespace Cypress\PatchManager\Tests;

use Cypress\PatchManager\MatchedPatchOperation;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

abstract class PatchManagerTestCase extends TestCase
{
    use ProphecyTrait;

    protected function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    /**
     * @param null $name
     * @param bool $canHandle
     *
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function mockHandler($name = null, $canHandle = true)
    {
        $handler = $this->prophesize('Cypress\PatchManager\PatchOperationHandler');
        if (!is_null($name)) {
            $handler->getName()->willReturn($name);
        }
        $handler->configureOptions(Argument::any());
        $handler->canHandle("test")->willReturn($canHandle);
        $handler->handle("test", Argument::any());

        return $handler;
    }

    /**
     * @param null $handlerName
     * @return MatchedPatchOperation
     */
    protected function getMatchedPatchOperation($handlerName = null)
    {
        return MatchedPatchOperation::create([], $this->mockHandler($handlerName));
    }
}
