<?php

namespace Tests\Integration\Classes;

use Arachne\ComponentsProtection\Actions;
use Arachne\ComponentsProtection\Application\TComponentsProtection;
use Nette\Application\UI\Presenter;

/**
 * @author Jáchym Toušek
 */
class ArticlePresenter extends Presenter
{

	use TComponentsProtection;

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
	 * @return BlockControl
	 */
	protected function createComponentHeader()
	{
		return new BlockControl();
	}

	/**
	 * @Actions("default")
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
		$presenter = substr($name, strrpos(':' . $name, ':'));
		return [ __DIR__ . "/../../templates/$presenter.$this->view.latte" ];
	}

}