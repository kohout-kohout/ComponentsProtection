<?php

namespace Arachne\ComponentsProtection\DI;

use Arachne\ComponentsProtection\Rules\Actions;
use Arachne\ComponentsProtection\Rules\ActionsRuleHandler;
use Arachne\Verifier\DI\VerifierExtension;
use Nette\DI\CompilerExtension;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class ComponentsProtectionExtension extends CompilerExtension
{
    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('handler'))
            ->setClass(ActionsRuleHandler::class)
            ->addTag(
                VerifierExtension::TAG_HANDLER,
                [
                    Actions::class,
                ]
            );
    }
}
