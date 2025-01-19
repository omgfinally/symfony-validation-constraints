# SymfonyValidationConstraints
Finally, a couple more of custom validation constraints for Symfony.

# EachElement

The `EachElement` constraint checks if every element in the array passed is correctly validated by the other passed Constraints.

Example usage:

```php
// src/Entity/Author.php
namespace App\Entity;

use OmgFinall\Constraints as OmgFinallyAssert;
use Symfony\Component\Validator\Constraints as Assert;

class Author
{
    #[OmgFinallyAssert\EachElement(new Assert\Type('int'))]
    protected array $numbers;

    #[OmgFinallyAssert\EachElement([
      new Assert\Type('int'),
      new Positive()
    ])]
    protected array $characters;
}
```
### Options

##### `subConstraints`
**type:** `array` | `Constraint` **required**

Pass either a single Constraint or an array of Constraints.
See [official Symfony documentation](https://symfony.com/doc/current/reference/constraints.html) for available constraints or use your own.

##### `message`
**type:** `string` **default:** `One or more of the elements of your array did not meet the constraint criteria.`

##### `groups`
**type:** `array` | `string` **default:** `null`

It defines the validation group or groups of this constraint. Read more about [validation groups](https://symfony.com/doc/current/validation/groups.html).

##### `payload`
**type:** `mixed` **default:** `null`

This option can be used to attach arbitrary domain-specific data to a constraint. The configured payload is not used by the Validator component, but its processing is completely up to you.

For example, you may want to use [several error levels](https://symfony.com/doc/current/validation/severity.html) to present failed constraints differently in the front-end depending on the severity of the error.
