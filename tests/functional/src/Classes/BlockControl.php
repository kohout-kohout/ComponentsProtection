<?php

namespace Tests\Functional\Classes;

use Nette\Application\UI\Control;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class BlockControl extends Control
{
    public function render(): void
    {
        $this->template->setFile(__DIR__.'/../../templates/block.latte');
        $this->template->render();
    }
}
