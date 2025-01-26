# EachElement

The `EachElement` constraint checks if every element in the array provided is correctly validated by the other passed Constraints.

Example usage:

```php
// src/Entity/Author.php
namespace App\Entity;

use OmgFinall\Constraints as OmgFinallyAssert;
use Symfony\Component\Validator\Constraints as Assert;

class Author
{
    // Checks if every element of $numbers is `int`.
    #[OmgFinallyAssert\EachElement(subConstraints: new Assert\Type('int'))]
    protected array $numbers;

    // Checks if every element of $incomes is both `int` and is positive (above zero).
    #[OmgFinallyAssert\EachElement(
        subConstraints: [
            new Assert\Type('int'),
            new Positive()
        ]
    )]
    protected array $incomes;

    // Checks if every element of $books is either `int` or `string`.
    #[OmgFinallyAssert\EachElement(
        subConstraints: [
            new Assert\Type('int'),
            new Assert\Type('string'),
        ],
        logicalOperator: 'or'
    )]
    protected array $books;
}
```
### Options

##### `subConstraints`
**type:** `array` | `Constraint` **required**

Pass either a single Constraint or an array of Constraints.
See [official Symfony documentation](https://symfony.com/doc/current/reference/constraints.html) for available constraints or use your own.

##### `message`
**type:** `string` **default:** `One or more of the elements of your array did not meet the constraint criteria.`

##### `logicalOperator`
**type:** `string` **default:** `and`

The logical operator to use when comparing the validation results of passed constraints.

The list of available values you may use:

| `logicalOperator` | Description                                                                                                              | `subConstraints` type   |
|-------------------|--------------------------------------------------------------------------------------------------------------------------|-------------------------|
| `and` (default)   | Uses the `&&` operator internally.                                                                                       | `array`                 |
| `or`              | Uses the `\|\|` operator internally.                                                                                     | `array`                 |
| `not`             | Uses the `!` operator internally. If you're validating with an array of constraints, each validation result should fail. | `array` \| `Constraint` |

##### `groups`
**type:** `array` | `string` **default:** `null`

It defines the validation group or groups of this constraint. Read more about [validation groups](https://symfony.com/doc/current/validation/groups.html).

##### `payload`
**type:** `mixed` **default:** `null`

This option can be used to attach arbitrary domain-specific data to a constraint. The configured payload is not used by the Validator component, but its processing is completely up to you.

For example, you may want to use [several error levels](https://symfony.com/doc/current/validation/severity.html) to present failed constraints differently in the front-end depending on the severity of the error.
