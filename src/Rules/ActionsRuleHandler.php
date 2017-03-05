<?php

namespace Arachne\ComponentsProtection\Rules;

use Arachne\ComponentsProtection\Exception\InvalidArgumentException;
use Arachne\Verifier\Exception\VerificationException;
use Arachne\Verifier\RuleHandlerInterface;
use Arachne\Verifier\RuleInterface;
use Nette\Application\Request;
use Nette\Application\UI\Presenter;
use Nette\Object;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class ActionsRuleHandler extends Object implements RuleHandlerInterface
{
    /**
     * @param Actions $rule
     * @param Request $request
     * @param string  $component
     *
     * @throws VerificationException
     */
    public function checkRule(RuleInterface $rule, Request $request, $component = null)
    {
        if (!$rule instanceof Actions) {
            throw new InvalidArgumentException('Unknown rule \''.get_class($rule).'\' given.');
        }

        if ($rule->actions === ['*']) {
            return;
        }
        $parameters = $request->getParameters();
        if (!in_array($parameters[Presenter::ACTION_KEY], $rule->actions)) {
            throw new VerificationException($rule, 'Component is inaccessible for the given action.');
        }
    }
}
