# PhpMetricsComposerExtension

This plugin add Composer support directly in your [PhpMetrics](https://github.com/phpmetrics/phpmetrics) reports.

![Screenshot of PhpMetricsComposerExtension](https://cloud.githubusercontent.com/assets/1076296/13942681/589ab526-eff5-11e5-8a49-3f918e84e065.png "Screenshot of PhpMetricsComposerExtension")

## Installation

**As phar archive**:

    wget https://cdn.rawgit.com/phpmetrics/ComposerExtension/composer-extension.phar 
    phpmetrcs --plugins=composer-extension.phar --report-html=report.html <my-folder>

or **with Composer**:

    composer require phpmetrics/phpmetrics phpmetrics/composer-extension
    ./vendor/bin/phpmetrics --plugins=./vendor/phpmetrics/composer-extension/ComposerExtension.php --report-html=report.html <my-folder>

    
## License

Please see the LICENSE file