# Read Only PHP Classes (Immutable Objects)

**Disclamer: This is a POC, it is experimental and there is magic involved.**

The goal of this project is provide a way to create Immutable PHP Objects.

## Instalation

```bash
composer require abdala/readonly
```

## Usage

```php
<?php

use Abdala\Readonly;

class Email
{
    use Readonly;
    
    private string $value;
}

$email = new Email('abdala.cerqueira@gmail.com');
```

## License

This project is under LGPLv3
