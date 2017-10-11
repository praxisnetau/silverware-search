# SilverWare Search Module

[![Latest Stable Version](https://poser.pugx.org/silverware/search/v/stable)](https://packagist.org/packages/silverware/search)
[![Latest Unstable Version](https://poser.pugx.org/silverware/search/v/unstable)](https://packagist.org/packages/silverware/search)
[![License](https://poser.pugx.org/silverware/search/license)](https://packagist.org/packages/silverware/search)

Provides a search results page and navigation bar search item for use with [SilverWare][silverware].

## Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Issues](#issues)
- [Contribution](#contribution)
- [Maintainers](#maintainers)
- [License](#license)

## Requirements

- [SilverWare][silverware]
- [SilverWare Navigation Module][silverware-navigation]

## Installation

Installation is via [Composer][composer]:

```
$ composer require silverware/search
```

## Configuration

As with all SilverStripe modules, configuration is via YAML.
Frontend requirements for `ContentController` are applied via `config.yml`.
Style mappings for Bootstrap are configured in the `styles.yml` configuration file.

## Usage

This module provides a `SearchResultsPage` which will be created automatically upon
build. This page is a dedicated page for showing search results generated by SilverStripe's
built-in fulltext search.

Also provided is a `SearchItem` object which can be added as a child of the `BarNavigation`
component provided by the [SilverWare Navigation][silverware-navigation] module. This item
adds a search icon to your navbar which shows a search form popover upon click.

On small screen devices, the icon and popover are hidden, and instead the search form is
added directly into the collapsible navigation area.

## Issues

Please use the [GitHub issue tracker][issues] for bug reports and feature requests.

## Contribution

Your contributions are gladly welcomed to help make this project better.
Please see [contributing](CONTRIBUTING.md) for more information.

## Maintainers

[![Colin Tucker](https://avatars3.githubusercontent.com/u/1853705?s=144)](https://github.com/colintucker) | [![Praxis Interactive](https://avatars2.githubusercontent.com/u/1782612?s=144)](http://www.praxis.net.au)
---|---
[Colin Tucker](https://github.com/colintucker) | [Praxis Interactive](http://www.praxis.net.au)

## License

[BSD-3-Clause](LICENSE.md) &copy; Praxis Interactive

[silverware]: https://github.com/praxisnetau/silverware
[silverware-navigation]: https://github.com/praxisnetau/silverware-navigation
[composer]: https://getcomposer.org
[issues]: https://github.com/praxisnetau/silverware-search/issues
