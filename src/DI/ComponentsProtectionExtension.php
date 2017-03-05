<?php

namespace Arachne\ComponentsProtection\DI;

use Arachne\Verifier\DI\VerifierExtension;
use Nette\DI\CompilerExtension;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class ComponentsProtectionExtension extends CompilerExtension
{
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('handler'))
            ->setClass('Arachne\ComponentsProtection\Rules\ActionsRuleHandler')
            ->addTag(VerifierExtension::TAG_HANDLER, [
                'Arachne\ComponentsProtection\Rules\Actions',
            ]);
    }
}
