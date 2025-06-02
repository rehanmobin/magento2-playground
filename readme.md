# Magento2 - Playground

Playground enables developers to quickly test any code in their system and access any of the services in the app.

## Install via composer

```
composer require wt/magento2-playground

php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## Usage

To enable the playground, just copy the `app/code/Pol/Playground/playground.php.dist` file to **dev/tools** directory of the project `dev/tools/playground.php`.

Add `playground.php` to `.gitignore` file 
```
/dev/tools/playground.php
```

This file needs to return a closure. Here's an example:

```php
<?php

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Filesystem\DirectoryList;

return function(ObjectManager $ob) {
    $dir = $ob->get(DirectoryList::class);
    dump($dir->getRoot());
};
```

You should be able to run this with: `bin/magento wt:playground`.

## Use a different path for playground

You can specify a different folder path for `playground.php` file if, don't want to add in `dev/tools` directory. Just update the `pgDir` argument in `di.xml` file

```xml
<type name="WT\Playground\UI\Console\PlaygroundCommand">
        <arguments>
            <argument name="pgDir" xsi:type="const">WT\Playground\UI\Console\PlaygroundDirResolver::PG_DIR_PATH</argument>
        </arguments>
    </type>
```

