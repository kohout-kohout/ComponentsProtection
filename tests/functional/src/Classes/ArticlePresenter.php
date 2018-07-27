<?php

declare(strict_types=1);

namespace Tests\Functional\Classes;

use Arachne\ComponentsProtection\Application\ComponentsProtectionTrait;
use Arachne\ComponentsProtection\Rules\Actions;
use Arachne\Verifier\Rules\All;
use Nette\Application\UI\Presenter;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class ArticlePresenter extends Presenter
{
    use ComponentsProtectionTrait;

    public function actionDefault(): void
    {
    }

    /**
     * @param int $id
     */
    public function actionDetail($id): void
    {
    }

    /**
     * @param int $id
     */
    public function actionEdit($id): void
    {
    }

    /**
     * @Actions({"*"})
     *
     * @return BlockControl
     */
    protected function createComponentHeader(): BlockControl
    {
        return new BlockControl();
    }

    /**
     * @Actions("default")
     * @All({
     * 	 @Actions("default"),
     * })
     *
     * @return BlockControl
     */
    protected function createComponentFooter(): BlockControl
    {
        return new BlockControl();
    }

    protected function createComponentUnprotected(): void
    {
    }

    public function formatTemplateFiles(): array
    {
        /** @var string */
        $name = $this->getName();
        $presenter = substr($name, (int) strrpos(':'.$name, ':'));

        return [__DIR__."/../../templates/$presenter.$this->view.latte"];
    }
}
