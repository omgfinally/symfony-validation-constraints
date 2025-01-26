# SymfonyValidationConstraints
Finally, a couple more of custom validation constraints for Symfony.

The constraints the package provides:

- [`EachElement`](docs/EachElement.md) - checks if every element in the array provided is correctly validated by the other passed Constraints.
- [`OneOfContainerParameters`](docs/OneOfContainerParameters.md) - checks if the value provided is contained inside an array in `parameters` configuration.

## Installation

```shell
composer require omgfinally/symfony-validation-constraints
```

You might also need to update `bundles.php`:

```php
// config/bundles.php

<?php

return [
    ...
    OmgFinally\SymfonyValidationConstraints\SymfonyValidationConstraintsBundle::class => ['all' => true],
];
```

## Usage

For usage, see specific files in docs folder:
- [`EachElement`](docs/EachElement.md)
- [`OneOfContainerParameters`](docs/OneOfContainerParameters.md)
