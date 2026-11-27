# LYRASOFT Package Development Guide

For general package development guidance, see `../../../windwalker/references/development-core/package-development.md`.

This document covers additional procedures for LYRASOFT packages.

## Development files in the package root

- `.gitignore`: Use this shared version as a reference: <https://github.com/lyrasoft/luna/blob/master/.gitignore>
- `README.md`: You can start with the package title.
- `VERSION`: Start with `0.1.0`.

## Automatically updating package versions

To make package versions easier to manage, use a prepared release command to update the version and Git tag.

First, create a `VERSION` file in the package root and set its initial version, such as `0.1.0`.

Next, create a `bin/` directory in the package root, and download `Console.php` and `release.php` into it:

```shell
wget https://raw.githubusercontent.com/asika32764/php-simple-console/master/src/Console.php
wget https://raw.githubusercontent.com/asika32764/php-simple-console/refs/heads/master/bin/release.php

chmod +x release.php
```

Alternatively, use `curl`:

```shell
curl https://raw.githubusercontent.com/asika32764/php-simple-console/master/src/Console.php -o Console.php
curl https://raw.githubusercontent.com/asika32764/php-simple-console/refs/heads/master/bin/release.php -o release.php

chmod +x release.php
```

### Version update commands

After updating the code, when preparing a new release, run this from the package root:

```shell
php bin/release.php patch
```

Other options:

```shell
php bin/release.php -h       # Show help
php bin/release.php patch    # Bump the patch version
php bin/release.php minor    # Bump the minor version
php bin/release.php major    # Bump the major version
php bin/release.php x.x.x    # Set a specific version
```
