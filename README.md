# SymfonyValidationConstraints
Finally, a couple more of custom validation constraints for Symfony.

# EachElement

The `EachElement` constraint checks if every element in an array is either alpha, numeric or alphanumeric.

Example usage:

```php
// src/Entity/Author.php
namespace App\Entity;

use OmgFinall\Constraints as Assert;

class Author
{
    #[Assert\EachElement('numeric')]
    protected array $numbers;

    #[Assert\EachElement('alpha')]
    protected array $characters;

    #[Assert\EachElement('alnum')]
    protected array $numbersAndCharacters;
}
```
### Options

##### `method`

- `int` uses [`is_int`](https://www.php.net/manual/en/function.is-int.php).
- `numeric` uses [`is_numeric`](https://www.php.net/manual/en/function.is-numeric.php).
- `alpha` uses [`ctype_alpha`](https://www.php.net/manual/en/function.ctype-alpha.php).
- `alnum` uses [`ctype_alpha` || `is_numeric`], a combination of the two above.
