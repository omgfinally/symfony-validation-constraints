# OneOfContainerParameters

The `OneOfContainerParameters` constraint checks if the value provided is contained inside an array in `parameters`
configuration.

Example usage:

```php
// config/services.yaml

...
parameters:
  app.supported_locales: ['en', 'fr', 'de']
...

// src/Entity/User.php
namespace App\Entity;

use OmgFinall\Constraints as OmgFinallyAssert;
use Symfony\Component\Validator\Constraints as Assert;

class Author
{
    // Checks if $locale is among `app.supported_locales`.
    #[OmgFinallyAssert\OneOfContainerParameters('app.supported_locales')]
    protected string $locale;
}
```

### Options

##### `parameterName`
**type:** `string` **required**

The name of the parameter in your container, usually defined in `config/services.yaml`.

##### `message`
**type:** `string` **default:** `One or more of the elements of your array did not meet the constraint criteria.`

##### `groups`
**type:** `array` | `string` **default:** `null`

It defines the validation group or groups of this constraint. Read more about [validation groups](https://symfony.com/doc/current/validation/groups.html).

##### `payload`
**type:** `mixed` **default:** `null`

This option can be used to attach arbitrary domain-specific data to a constraint. The configured payload is not used by the Validator component, but its processing is completely up to you.

For example, you may want to use [several error levels](https://symfony.com/doc/current/validation/severity.html) to present failed constraints differently in the front-end depending on the severity of the error.
