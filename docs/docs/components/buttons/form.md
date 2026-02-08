---
sidebar_position: 2
title: Form buttons
description: The form button component is designed to be used within forms.
---

# Form buttons

To help you create better forms, there is also a form button component. The form button component consists of one 
or more buttons depending on your settings. In its simplest form, it is just a `submit` button.

```html
<x-eloquent-ui::button.form name="submit">Submit</x-eloquent-ui::button.form>
```

This will render a simple `submit` button in the primary theme colour.

## Usage

### Another

Often when you have a form that creates a resource, you will want to add a second `submit` button that redirects 
back to the creation form after the first has been successfully created, so you can immediately create another resource.
You can add this second button by setting the `another` attribute to `true`.

```html
<x-eloquent-ui::button.form name="submit" another="true">Submit</x-eloquent-ui::button.form>
```

This will render two submit buttons next to each other. One with the text 'Submit' and the other with the text 
'Submit and create another'. The first button will have the name `submit` (as provided) and the second button will 
have the name `submit-another`.

:::info[Submit another]
The second button will always have the name `submit-another`, no matter what you set the `name` attribute to. This is 
needed because the backend integration needs to know which button was clicked.
:::

You can customise the second button by adding the `another-theme` and `another-label` attributes.

```html
<x-eloquent-ui::button.form name="submit" another="true" another-theme="secondary" another-label="Create another">Submit</x-eloquent-ui::button.form>
```

The attributes `no-wrap`, `offset` and `theme` are also available and work the same as the button component.

### Reset

If you also want a reset button for your form, you can add the `reset` attribute. This works the same as the `another` 
attribute, except it will render a reset button instead of a submit button.

```html
<x-eloquent-ui::button.form name="submit" reset="true">Submit</x-eloquent-ui::button.form>
```

The reset button will have the name `{{ $name }}-reset`.

You can customise the second button by adding the `reset-theme` and `reset-label` attributes.

```html
<x-eloquent-ui::button.form name="submit" reset="true" reset-theme="secondary" reset-label="Reset form">Submit</x-eloquent-ui::button.form>
```

### Once

Just like with regular buttons you can add the `once` attribute to prevent the button from being clicked more than once.
If you set this option on the form button component, it will render both submit buttons as disabled as soon as either 
of them is clicked. 

```html
<x-eloquent-ui::button.form name="submit" another="true" once="true">Submit</x-eloquent-ui::button.form>
```

## Backend

### Form requests

To help you work more easily with forms that offer both a submit and a submit another button, Eloquent UI offers a 
trait that you can add to your form request: `BrickNPC\EloquentUI\Http\Traits\CanSubmitAnother`. 

This trait adds two methods to your form request: `wantsToSubmitAnother(): bool` and 
`redirect(string $defaultAction = '/'): RedirectResponse`. 

You can use the `wantsToSubmitAnother()` method to check if the user clicked the submit another button and write your 
own logic for what to do next. You can use the `redirect()` method to let the trait redirect the user to the correct 
next location. The `$defaultAction` parameter is the page the user should be redirected to if they click the submit 
button without clicking the submit another button.

```php
<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use BrickNPC\EloquentUI\Http\Traits\CanSubmitAnother;

class StorePostRequest extends FormRequest
{
    use CanSubmitAnother;
    
    // Other form request logic
}
```

Then in your controller you can use it like this:

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;

class StorePostController
{
    public function __invoke(StorePostRequest $request): RedirectResponse
    {
        // Validation, store post, etc.
        
        return $request->redirect(route('posts.index'));
    }
}
```

## Advanced usage

You can add any custom attributes to the component, including custom classes. Note that for this component, any attribute 
or class you add to it will be added to all buttons rendered.