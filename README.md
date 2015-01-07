Kirby Footnotes v0.1
============

This plugin extends [Kirby 2 CMS](http://getkirby.com) with some basic footnote functionalities.

In-text reference:  
![In-text reference](https://cloud.githubusercontent.com/assets/3788865/5635753/670ccacc-95ec-11e4-81b8-7cdc20b077b2.png)

Footnotes list at the end of the text:  
![Footnotes list](https://cloud.githubusercontent.com/assets/3788865/5635754/67339fe4-95ec-11e4-981a-ef3f47075935.png)


# Installation
1. Download [Kirby Footnotes](https://github.com/distantnative/kirby-footnotes/zipball/master/)
2. Copy the `site/plugins/footnotes` directory to `site/plugins/`
3. Add CSS for the footnotes (optional)  
`.footnote`: in-text reference number, `sup` tag  
`.footnotes`: `div` wrapper for list of footnotes, `ol` list inside  
`.footnotedivider`: `div` element before the `ol` list  

# Update
1. Replace the `site/plugins/footnotes` directory with recent version

# Options
Footnotes can be used either as method on a text field, e.g. `$page->text()->footnotes()->kirbytext()`, when creating templates - or globally set for all Kirbytext outputs. To do the latter add the following to your `site/config/config.php`:
```php
c::set('footnotes.global', true);
```

# Usage
To add a footnote to your Kirbytext field, just include `[#. Footnote text]` at the place you want the reference number to appear (e.g. `[1. This is a footnote]` or `[7. This is another one **yeah**]`):
```
“Transmigrants have multiple identities which are grounded in more than one society and thus, 
in effect, they have a hybridized transnational identity. [...] In a deterritorialized context, 
the conventional one-to-one relationship between state and territory is increasingly 
questioned and challenged” [1. Wong, L. (2002): Home away from home? Abingdon: 
Routledge. Seite 171]
```

**Include footnote in the list, but no reference number in the text:**
To have a footnote / an information included in the footnotes list at the end of the text, but not as a reference number inside the text, just prepend a `<no>` tag to the footnote:
```
[1. <no>**Photo credits:** (link:http://www.flickr.com/photos/cubagallery/ text:Cuba Gallery)]
```
