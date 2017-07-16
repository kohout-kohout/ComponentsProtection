# Documentation

This extension is here to provide easy annotation-based protection of presenter components.


## Installation

The best way to install Arachne/ComponentsProtection is using [Composer](http://getcomposer.org/):

```sh
composer require arachne/components-protection
```

Now you need to register Arachne/ComponentsProtection, Arachne/Verifier and Kdyby/Annotations extensions using your [neon](http://ne-on.org/) config file.

```yml
extensions:
    kdyby.annotations: Kdyby\Annotations\DI\AnnotationsExtension
    arachne.verifier: Arachne\Verifier\DI\VerifierExtension
    arachne.componentsProtection: Arachne\ComponentsProtection\DI\ComponentsProtectionExtension
```

See also the documentation of [Kdyby/Annotations](https://github.com/Kdyby/Annotations/blob/master/docs/en/index.md) and Arachne/Verifier.

Finally **replace** the `Arachne\Verifier\Application\VerifierPresenterTrait` trait in your BasePresenter with `Arachne\ComponentsProtection\Application\ComponentsProtectionTrait`.

```php
use Arachne\ComponentsProtection\Application\ComponentsProtectionTrait;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
	use ComponentsProtectionTrait;
}
```


## Usage

### Presenter

This extension adds only one new annotation `@Actions` for Verifier. It's used for restricting components to specified actions. This solves the security issue in Nette where a component can be created even when not intended by sending a signal to it. Note that this annotation is required and the components wont work at all if you miss it.

```php
use Arachne\ComponentsProtection\Rules\Actions;

class ArticlePresenter extends BasePresenter
{
	public function actionDefault()
	{
		// Using $this['editForm'] will cause an exception.
	}

	public function actionEdit($id)
	{
		// Using $this['editForm'] will work normally.
	}

	/**
	 * @Actions("edit")
	 */
	public function createComponentEditForm()
	{
		// This component will be available only for edit action.
	}
}
```

You can make a component accessible from multiple actions like this:

```php
	/**
	 * @Actions({"default", "edit"})
	 */
	public function createComponentMenu()
	{
		// This component will be available for both default and menu actions.
	}
```


## Notes

If you are restricting a component to an action and are relying on some other annotations specified for that action, make sure the annotations are used for the action method and not the render method. Otherwise your component won't be protected because signal is called after action method but before render method.
