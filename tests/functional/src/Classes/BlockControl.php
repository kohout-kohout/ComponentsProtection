<?php

declare(strict_types=1);

namespace Tests\Functional\Classes;

use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 *
 * @property Template $template
 */
class BlockControl extends Control
{
    public function render(): void
    {
        $this->template->setFile(__DIR__.'/../../templates/block.latte');
        $this->template->render();
    }
}
