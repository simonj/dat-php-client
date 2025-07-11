# Dat PHP Client

A PHP client library for the [Dat debugging application](https://github.com/dat-app/dat), providing fast and intuitive debugging capabilities for PHP applications.

## Installation

Install the package via Composer:

```bash
composer require dat/php-client
```

## Quick Start

```php
<?php

require 'vendor/autoload.php';

// Basic usage
dat('Hello, World!');

// Debug variables
$user = ['name' => 'John', 'age' => 30];
dat($user);

// Multiple arguments
dat('User logged in:', $user, time());

// Colored output
dat('Success!')->green();
dat('Error occurred')->red();
dat('Warning message')->yellow();

// Pass-through debugging
$result = dat($someCalculation)->pass($value);

// Conditional debugging
dat_if($debug, 'Debug information');

// Screen organization
dat('User data')->screen('auth');
dat('Database query')->screen('database');
```

## Features

Dat provides a modern, fast debugging experience for PHP applications with an intuitive API and powerful features.

### Basic Debugging

Send any type of data to Dat:

```php
dat('Simple string message');
dat(['key' => 'value']);
dat($object);
dat(123);
dat(true);
```

### Multiple Arguments

Send multiple values in one call:

```php
dat('User:', $user, 'logged in at', date('Y-m-d H:i:s'));
```

### Colored Output

Add colors to your debug messages:

```php
dat('Success message')->green();
dat('Error message')->red();
dat('Warning message')->yellow();
dat('Info message')->blue();
dat('Debug message')->gray();
```

### Pass-through Debugging

Debug a value and return it unchanged:

```php
$result = dat($calculation)->pass($value);
// Equivalent to:
// dat($calculation, $value);
// return $value;
```

### Screen Organization

Organize your debug messages into different screens:

```php
dat('Authentication data')->screen('auth');
dat('Database queries')->screen('db');
dat('API responses')->screen('api');
```

### Pause Execution

Pause the execution of your application:

```php
dat('Before critical section')->pause();
// This will pause the Dat application and your PHP script
```

### Clear Messages

Clear all messages or screen-specific messages:

```php
dat()->clearAll();           // Clear all messages
dat()->clearScreen();        // Clear all messages in current screen
```

### Helper Functions

#### `dat()`
The main debugging function:

```php
dat('message');
dat($variable);
dat('label', $variable);
```

#### `datd()`
Debug and die:

```php
datd('Fatal error occurred', $error);
// Equivalent to: dat('Fatal error occurred', $error); exit(1);
```

#### `dat_if()`
Conditional debugging:

```php
dat_if($condition, 'Debug message');
dat_if($user->isAdmin(), 'Admin user detected', $user);
```

#### `dat_once()`
Debug only once per execution:

```php
foreach ($items as $item) {
    dat_once('Processing items...'); // Only shows once
    // ... process item
}
```

#### `dat_trace()`
Send a stack trace:

```php
dat_trace();          // Full stack trace
dat_trace(5);         // Limit to 5 stack frames
```

#### `dat_caller()`
Debug information about the caller:

```php
function someFunction() {
    dat_caller(); // Shows file, line, function info
}
```

## Configuration

### Environment Detection

The client automatically detects production environments and disables debugging:

```php
// Set environment via:
$_ENV['APP_ENV'] = 'production';        // Laravel style
$_SERVER['APP_ENV'] = 'production';     // Server variable
putenv('APP_ENV=production');           // Environment variable
```

### Custom Server Configuration

Configure a custom Dat server:

```php
use Dat\Dat;

// Custom host and port
$dat = new Dat('192.168.1.100', 3030);

// Disable debugging
$dat = new Dat('127.0.0.1', 3030, false);
```

## Advanced Usage

### Chaining Methods

Chain multiple methods for powerful debugging:

```php
dat('User registration')
    ->screen('auth')
    ->color('green')
    ->send($userData);
```

### Method Reference

| Method | Description | Example |
|--------|-------------|---------|
| `send()` | Send debug data | `dat()->send($data)` |
| `color()` | Set custom color | `dat()->color('purple')` |
| `red()` | Set red color | `dat()->red()` |
| `green()` | Set green color | `dat()->green()` |
| `blue()` | Set blue color | `dat()->blue()` |
| `yellow()` | Set yellow color | `dat()->yellow()` |
| `orange()` | Set orange color | `dat()->orange()` |
| `purple()` | Set purple color | `dat()->purple()` |
| `gray()` | Set gray color | `dat()->gray()` |
| `screen()` | Set screen name | `dat()->screen('database')` |
| `pause()` | Pause execution | `dat()->pause()` |
| `pass()` | Pass-through value | `dat()->pass($value)` |
| `clearAll()` | Clear all messages | `dat()->clearAll()` |
| `clearScreen()` | Clear screen messages | `dat()->clearScreen()` |

## Requirements

- PHP 7.4 or higher
- Guzzle HTTP client
- Ramsey UUID library

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).