# Changelog

## [1.1.1](https://github.com/distantnative/footnotes/releases/tag/1.1.1) (2017-06-18)
:bug: Fixed bug related to unwanted whitespace  

## [1.1.0](https://github.com/distantnative/footnotes/releases/tag/1.1.0) (2017-01-22)
- Improved namespacing and code structure
- Added KibryFootnotes::field() helper method
- Fixed install folder name typo in README

## 1.0.1 (2016-09-04)
- Fixed an error when using `$page->text()->footnotes(false)`
- Fixed falsely using `$number`
- Removed docs images from repository

## 1.0.0 (2016-05-05)
- Requires Kirby 2.3.0
- Switched to follow the markdown footnotes mark-up
- Identical footnotes are now always merged
- Updated `package.json` to work with the [Kirby CLI](https://github.com/getkirby/cli)
- Completely refactored PHP (including namespacing)
- Renamed config options for consistency
- Switched to MIT License

## 0.9.0
- Removed jQuery dependency for smooth scrolling footnotes links (thx to @servicethinker)
- Fixed $page scope for global footnotes (by @servicethinker)

## 0.8.0
- Fixed anchor click listener bug (by @servicethinker)

## 0.7.0
- Added options to limit footnotes to specific templates (whitelist & blacklist)
- Added option to merge identical footnotes

## 0.6.0
- Added option to restrict footnotes to certain templates
- Fixed numbering of footnotes without in-text footnote (`<no>`)

## 0.5.0
- Enabled Kirbytext inside footnotes
- Fixed footnotes without in-text footnote (`<no>`)
- No backlink on `<no>` footnotes

## 0.4.0
- Renamed repository to `footnotes` & restructured files
- Moved functionalities to KirbyFootnotes class
- Fixed bug with not replacing order number correctly
