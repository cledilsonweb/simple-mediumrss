# SimpleMediumRSS

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Total Downloads][ico-downloads]][link-downloads]

PHP Library to read Medium RSS

## Usage

``` php
$simple = new SimpleMediumRSS('https://medium.com/feed/@Medium');

echo $simple->getTitle();
echo $simple->getDescription();
echo $simple->getLastBuildDate();

$itens = $simple->getItens();
foreach($itens as $item){
    echo $item->getTitle();
    echo $item->getContent();
}
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Suggestions and Security

If you discover any security related issues or have any suggestions, please [create a new issue][new-issue].

## Credits

- [Cledilson Nascimento][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/cledilsonweb/simple-mediumrss.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/cledilsonweb/simple-mediumrss.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/cledilsonweb/simple-mediumrss
[link-downloads]: https://packagist.org/packages/cledilsonweb/simple-mediumrss
[link-author]: https://github.com/cledilsonweb
[link-contributors]: ../../contributors
[new-issue]: https://github.com/cledilsonweb/simple-mediumrss/issues/new
