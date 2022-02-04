<?php

/*
 * This file is part of Chevere.
 *
 * (c) Rodolfo Berrios <rodolfo@chevere.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Chevere\Tests\Pluggable;

use Chevere\Pluggable\Plug\Hook\HooksQueue;
use Chevere\Pluggable\Plug\Hook\HooksRunner;
use Chevere\Tests\Pluggable\_resources\src\ControllerTestController;
use Chevere\Tests\Pluggable\_resources\src\ControllerTestModifyParamConflictHook;
use Chevere\Tests\Pluggable\_resources\src\ControllerTestModifyParamHook;
use PHPUnit\Framework\TestCase;

final class ControllerTest extends TestCase
{
    public function testHookedController(): void
    {
        $hook = new ControllerTestModifyParamHook();
        $hooksQueue = (new HooksQueue())
            ->withAdded($hook);
        $controller = new ControllerTestController();
        $controller = $controller->withHooksRunner(
            new HooksRunner($hooksQueue)
        );
        $this->assertCount(1, $controller->parameters());
        $this->assertSame(['string'], $controller->parameters()->keys());
    }

    public function testHookedControllerParamConflict(): void
    {
        $hook = new ControllerTestModifyParamConflictHook();
        $hooksQueue = (new HooksQueue())
            ->withAdded($hook);
        $controller = new ControllerTestController();
        $controller = $controller->withHooksRunner(
            new HooksRunner($hooksQueue)
        );
        $this->assertCount(1, $controller->parameters());
    }
}
