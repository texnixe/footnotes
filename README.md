![Footnotes for Kirby CMS](docs/logo.png)  

[![Release](https://img.shields.io/github/release/distantnative/footnotes.svg)](https://github.com/distantnative/footnotes/releases)  [![Issues](https://img.shields.io/github/issues/distantnative/footnotes.svg)](https://github.com/distantnative/footnotes/issues)
[![Moral License](https://img.shields.io/badge/buy-moral_license-8dae28.svg)](https://gumroad.com/l/kirby-footnotes)

This plugin extends [Kirby CMS](http://getkirby.com) with some basic and extremely easy footnote functionalities. The syntax is simple to understand and if the plugin is removed the remaining text still makes sense.

**The plugin is free. However, I would really appreciate if you could support me with a [moral license](https://gumroad.com/l/kirby-footnotes)!**


## Table of Contents
1. [Requirements](#Requirements)
2. [Installation & Update](#Installation)
3. [Usage](#Usage)
4. [Options](#Options)
5. [Help & Improve](#Help)
6. [Version History](#VersionHistory)

## Requirements <a id="Requirements"></a>
Since version 1.0.0 the footnotes plugin requires Kirby CMS 2.3.0 or higher.  
If you are running an older version of Kirby, please use [version 0.9.0](https://github.com/distantnative/footnotes/releases/tag/v0.9).

## Installation & Update <a id="Installation"></a>
1. Download [Footnotes](https://github.com/distantnative/footnotes/zipball/master/)
2. Copy the `footnotes` directory to `site/plugins/`
3. Add CSS for the footnotes (optional)  
`.footnote`: in-text reference number, `sup` tag  
`.footnotes`: `div` wrapper for list of footnotes, `ol` list inside  
`.footnotedivider`: `div` element before the `ol` list  


## Usage <a id="Usage"></a>
Just use the footnotes method on the field: `$page->text()->footnotes()`. Adding footnotes to your Kirbytext field is simple. Just type them inline in your post in square brackets like this:

```
[1. This is a footnote.]
```

Each footnote must have a number followed by a period, a space and the actual footnote. It does not matter which number as the footnotes will be automatically renumbered. Footnotes can contain anything you like including links or images and are automatically linked back to the spot in the text where the note was made.

```
“In a deterritorialized context, the conventional one-to-one 
relationship between state and territory is increasingly 
questioned and challenged” [1. Wong, L. (2002): Home away from 
home? Abingdon: Routledge. Seite 171]
```

**In-text reference:**  
![In-text reference](docs/example1.png)
**Footnotes list at the end of the text:**  
![Footnotes list](docs/example2.png)

Notes:  
- You should not include square brackets [] inside the footnotes themselves.
- Unique footnote numbers are recommended, especially if the text is identical for multiple footnotes.

### Reference-less footnotes
To have a footnote / an information included in the footnotes list at the end of the text, but not as a reference number inside the text, just prepend a `<no>` tag to the footnote:
```
[1. <no>**Photo credits:** (link:http://www.flickr.com/photos/cubagallery/ text:Cuba Gallery)]
```



## Options <a id="Options"></a>

**Remove footnotes**  
If you want show footnotes of a text field on specific pages (e.g. single blog article) but not on others (e.g. blog overview), you can add a parameter to the footnotes field method in e.g. `templates/blog.php` to remove all footnotes:
```php
<?= $post->text()->footnotes(false) ?>
<?= $post->text()->footnotes(['convert' => false]) ?>
```

**Separate bibliography output**
If you do not want the bibliography to be appened right after the field text, you first have to deactivate thhe bibliography in the field method:
```php
<?= $page->text()->footnotes(['bibliography' => false]) ?>
```
And then output the bibliography where wanted:
```php
<?= dnFootnotes::bibliography($page->text()) ?>
```

**Smooth scrolling**  
With the following options, you can enable a smooth scrolling effect to the bibliography as well as define a scroll speed and an offset to the scrolling position (e.g. if a fixed header menu is used). Add them to your `site/config/config.php`:

```php
c::set('plugin.footnotes.scroll',        true);
c::set('plugin.footnotes.scroll.offset', 60);
c::set('plugin.footnotes.scroll.speed',  500);
```

**Global footnotes**
In addition to converting footnotes via the field method, you can set an option to activate it for all Kirbytext outputs globally. Add the following to your `site/config/config.php`:
```php
c::set('plugin.footnotes.global', true);
```

**Template whitelist**  
You can allow footnotes only on specific templates by adding the following to your `site/config/config.php`:
```php
c::set('plugin.footnotes.templates.allow', array(
  'about',
  'blog',
  'project'
));
```

**Template blacklist**
You can restrict footnotes from specific templates by adding the following to your `site/config/config.php`:
```php
c::set('plugin.footnotes.templates.ignore', array(
  'about',
  'blog',
  'project'
));
```


## Help & Improve <a id="Help"></a>
*If you have any suggestions for further configuration options, [please let me know](https://github.com/distantnative/footnotes/issues/new).*


## Version history <a id="VersionHistory"></a>
You can find a more or less complete version history in the [changelog](docs/CHANGELOG.md).

## License
[MIT License](http://www.opensource.org/licenses/mit-license.php)

## Author
Nico Hoffmann - <https://nhoffmann.com>
