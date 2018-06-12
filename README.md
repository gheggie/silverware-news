# SilverWare News Module

[![Latest Stable Version](https://poser.pugx.org/silverware/news/v/stable)](https://packagist.org/packages/silverware/news)
[![Latest Unstable Version](https://poser.pugx.org/silverware/news/v/unstable)](https://packagist.org/packages/silverware/news)
[![License](https://poser.pugx.org/silverware/news/license)](https://packagist.org/packages/silverware/news)

Provides a news archive for [SilverWare][silverware] apps, divided into a series of categories and articles.

## Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Issues](#issues)
- [Contribution](#contribution)
- [Maintainers](#maintainers)
- [License](#license)

## Requirements

- [SilverWare][silverware]

## Installation

Installation is via [Composer][composer]:

```
$ composer require silverware/news
```

## Usage

The module provides three pages ready for use within the CMS:

- `NewsArchive`
- `NewsCategory`
- `NewsArticle`

Create a `NewsArchive` page as the top-level of your news archive. Under the `NewsArchive` you
may add `NewsCategory` pages as children to divide the archive into a series
of categories. Then, as children of `NewsCategory`, add your `NewsArticle` pages.

A `NewsArticle` consists of a title, content, and a date. You can also add an image and summary for the article
by using the "Meta" tab. `NewsArchive` and `NewsCategory` pages are also implementors of `ListSource`,
and can be used with components to show a series of news articles as list items.

### RSS Feed

A `NewsArchive` also supports the automatic generation of an RSS feed based on the
latest articles. You can enable or disable this functionality using the "Feed enabled"
checkbox on the `NewsArchive` options tab.

## Issues

Please use the [GitHub issue tracker][issues] for bug reports and feature requests.

## Contribution

Your contributions are gladly welcomed to help make this project better.
Please see [contributing](CONTRIBUTING.md) for more information.

## Maintainers

[![Colin Tucker](https://avatars3.githubusercontent.com/u/1853705?s=144)](https://github.com/colintucker) | [![Praxis Interactive](https://avatars2.githubusercontent.com/u/1782612?s=144)](https://www.praxis.net.au)
---|---
[Colin Tucker](https://github.com/colintucker) | [Praxis Interactive](https://www.praxis.net.au)

## License

[BSD-3-Clause](LICENSE.md) &copy; Praxis Interactive

[silverware]: https://github.com/praxisnetau/silverware
[composer]: https://getcomposer.org
[issues]: https://github.com/praxisnetau/silverware-news/issues
