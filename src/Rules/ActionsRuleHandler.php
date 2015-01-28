<?php

/**
 * This file is part of the Arachne
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Arachne\ComponentsProtection\Rules;

use Arachne\ComponentsProtection\Exception\InvalidArgumentException;
use Arachne\Verifier\Exception\VerificationException;
use Arachne\Verifier\RuleInterface;
use Arachne\Verifier\RuleHandlerInterface;
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
	 * @param string $component
	 * @throws VerificationException
	 */
	public function checkRule(RuleInterface $rule, Request $request, $component = NULL)
	{
		if (!$rule instanceof Actions) {
			throw new InvalidArgumentException('Unknown rule \'' . get_class($rule) . '\' given.');
		}

		if ($rule->actions === [ '*' ]) {
			return;
		}
		$parameters = $request->getParameters();
		if (!in_array($parameters[Presenter::ACTION_KEY], $rule->actions)) {
			throw new VerificationException($rule, "Component is inaccessible for the given action.");
		}
	}


}
