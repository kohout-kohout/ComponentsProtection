<?php

namespace Tests\Unit;

use Arachne\ComponentsProtection\Rules\Actions;
use Arachne\ComponentsProtection\Rules\ActionsRuleHandler;
use Arachne\Verifier\RuleInterface;
use Codeception\MockeryModule\Test;
use Mockery;
use Nette\Application\Request;
use Nette\Application\UI\Presenter;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class ActionsRuleHandlerTest extends Test
{
    /**
     * @var ActionsRuleHandler
     */
    private $handler;

    protected function _before()
    {
        $this->handler = new ActionsRuleHandler();
    }

    public function testAllowedTrue()
    {
        $rule = new Actions();
        $rule->actions = ['default'];
        $request = new Request('Test', 'GET', [
            Presenter::ACTION_KEY => 'default',
        ]);

        $this->assertNull($this->handler->checkRule($rule, $request));
    }

    /**
     * @expectedException \Arachne\Verifier\Exception\VerificationException
     * @expectedExceptionMessage Component is inaccessible for the given action.
     */
    public function testAllowedFalse()
    {
        $rule = new Actions();
        $rule->actions = [];
        $request = new Request('Test', 'GET', [
            Presenter::ACTION_KEY => 'default',
        ]);

        $this->handler->checkRule($rule, $request);
    }

    /**
     * @expectedException \Arachne\ComponentsProtection\Exception\InvalidArgumentException
     */
    public function testUnknownAnnotation()
    {
        $rule = Mockery::mock(RuleInterface::class);
        $request = new Request('Test', 'GET', []);

        $this->handler->checkRule($rule, $request);
    }
}
