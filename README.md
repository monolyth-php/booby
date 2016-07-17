# Booby
Generic flash message storage system

"Flash messages" are those one-off messages a web application might want to show
to a User, e.g. "Changes saved successfully". The developer wants to add these
messages and be ensured they get shown exactly once, whenever (between page
loads, after redirect, on the desktop when generated in an Ajax request etc.).

## Installation

### Composer (recommended)
```bash
$ composer require monolyth/booby
```

### Manual
1. Clone or download the repository;
2. Add `/path/to/booby/src` for namespace `Monolyth\Booby` in your autoloader.

## Usage
Adding a message is simple:

```php
<?php

Monolyth\Booby\Flash::me('This is my awesome message.');
```

...as is later displaying it:

```php
<?php

foreach (Monolyth\Booby\Flash::each() as $msg) {
    echo $msg;
}
```

## Adding options to messages
You can pass an optional second parameter to `Flash::me` containing a hash of
key/value pairs available as options on your message. E.g.:

```php
<?php

Monolyth\Booby\Flash::me('This is a warning', ['type' => 'warning']);

$msg = Monolyth\Booby\Flash::each();
echo $msg->type; // "warning"
```

These options can be anything as long as the key is a valid PHP property name.

