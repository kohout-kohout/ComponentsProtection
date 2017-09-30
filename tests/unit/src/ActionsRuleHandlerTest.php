<?php

declare(strict_types=1);

namespace Tests\Unit;

use Arachne\ComponentsProtection\Exception\InvalidArgumentException;
use Arachne\ComponentsProtection\Rules\Actions;
use Arachne\ComponentsProtection\Rules\ActionsRuleHandler;
use Arachne\Verifier\Exception\VerificationException;
use Arachne\Verifier\RuleInterface;
use Codeception\Test\Unit;
use Eloquent\Phony\Phpunit\Phony;
use Nette\Application\Request;
use Nette\Application\UI\Presenter;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class ActionsRuleHandlerTest extends Unit
{
    /**
     * @var ActionsRuleHandler
     */
    private $handler;

    protected function _before(): void
    {
        $this->handler = new ActionsRuleHandler();
    }

    public function testAllowedTrue(): void
    {
        $rule = new Actions();
        $rule->actions = ['default'];
        $request = new Request('Test', 'GET', [
            Presenter::ACTION_KEY => 'default',
        ]);

        $this->handler->checkRule($rule, $request);
    }

    public function testAllowedFalse(): void
    {
        $rule = new Actions();
        $rule->actions = [];
        $request = new Request('Test', 'GET', [
            Presenter::ACTION_KEY => 'default',
        ]);

        try {
            $this->handler->checkRule($rule, $request);
            self::fail();
        } catch (VerificationException $e) {
            self::assertSame('Component is inaccessible for the given action.', $e->getMessage());
        }
    }

    public function testUnknownAnnotation(): void
    {
        $rule = Phony::mock(RuleInterface::class)->get();
        $request = new Request('Test', 'GET', []);

        try {
            $this->handler->checkRule($rule, $request);
            self::fail();
        } catch (InvalidArgumentException $e) {
        }
    }
}
