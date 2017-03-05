<?php

namespace Tests\Integration\Classes;

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

    public function actionDefault()
    {
    }

    /**
     * @param int $id
     */
    public function actionDetail($id)
    {
    }

    /**
     * @param int $id
     */
    public function actionEdit($id)
    {
    }

    /**
     * @Actions({"*"})
     *
     * @return BlockControl
     */
    protected function createComponentHeader()
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
    protected function createComponentFooter()
    {
        return new BlockControl();
    }

    protected function createComponentUnprotected()
    {
    }

    public function formatTemplateFiles()
    {
        $name = $this->getName();
        $presenter = substr($name, strrpos(':'.$name, ':'));

        return [__DIR__."/../../templates/$presenter.$this->view.latte"];
    }
}
