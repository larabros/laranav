# Changelog

All notable changes to `laranav` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## NEXT - YYYY-MM-DD

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.4.2 - 2016-04-03

### Fixed
- Incorrect documentation

## 0.4.1 - 2016-04-03

### Added
- Better documentation

## 0.4.0 - 2016-03-10

### Fixed
- Changed project namespace to `Larabros`

## 0.3.2 - 2016-02-22

### Fixed
- Docblock for `Item::__construct()`
- Travis now sends code coverage to Scrutinizer.

## 0.3.1 - 2016-02-15

### Fixed
- Broken test fixtures

## 0.3 - 2016-02-15

### Added
- More test coverage

### Fixed
- Active classes now apply correctly

### Removed
- Removed unused `views.item` option from menu configuration options and replaced with single `view` option
- Removed useless `phpcbf.xml.dist` from source control

## 0.2.2 - 2016-02-14

### Fixed
- Menu item sample partial can now render any amount of nested children
- All menus now inherit configuration options from `default`

## 0.2.1 - 2016-02-14

### Fixed
- Relaxing version requirements for Illuminate components to allow install on Laravel 5.1+

## 0.2 - 2016-02-13

### Added
- Can now use methods from `Illuminate\Contracts\Routing\UrlGenerator` to generate link URLs

### Removed
- Unnecessary dependency from `Menu::__construct()`

## 0.1 - 2016-02-13

### Added
- Base classes and tests
