<?php

/**
 * This file is part of the Arachne
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Arachne\ComponentsProtection;

use Arachne\ComponentsProtection\Exception\InvalidArgumentException;
use Arachne\ComponentsProtection\Exception\ComponentInaccessibleException;
use Arachne\Verifier\IRule;
use Arachne\Verifier\IRuleHandler;
use Nette\Application\Request;
use Nette\Application\UI\Presenter;
use Nette\Object;

/**
 * @author Jáchym Toušek
 */
class ComponentsProtectionHandler extends Object implements IRuleHandler
{

	/**
	 * @param Actions $rule
	 * @param Request $request
	 * @param string $component
	 * @throws ComponentInaccessibleException
	 */
	public function checkRule(IRule $rule, Request $request, $component = NULL)
	{
		if ($rule instanceof Actions) {
			$this->checkRuleActions($rule, $request);
		} else {
			throw new InvalidArgumentException('Unknown rule \'' . get_class($rule) . '\' given.');
		}
	}

	/**
	 * @param Actions $rule
	 * @param Request $request
	 * @throws ComponentInaccessibleException
	 */
	private function checkRuleActions(Actions $rule, Request $request)
	{
		$parameters = $request->getParameters();
		if ($rule->actions === array('*')) {
			return;
		}
		if (!in_array($parameters[Presenter::ACTION_KEY], $rule->actions)) {
			throw new ComponentInaccessibleException("Component is inaccessible for the given action.");
		}
	}


}
