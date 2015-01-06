Kirby Footnotes v0.1
============

This plugin extends [Kirby 2 CMS](http://getkirby.com) with some basic footnote functionalities.  

# Installation
1. Download [Kirby Footnotes](https://github.com/distantnative/kirby-footnotes/zipball/master/)
2. Copy the `site/plugins/footnotes` directory to `site/plugins/`
3. Add CSS for the footnotes (optional:
```css
.footnote {
  font-size: .85em;
}

.footnotedivider {
  width: 85px;
  margin-top: 20px;
  border-bottom: 1px solid #777;
}

.footnotes {
  font-size: .8em;
}

.footnotes ol li {
  margin: 4px 0;
}

```

# Update
1. Replace the `site/plugins/footnotes` directory with recent version

# Usage
To add a footnote to your Kirbytext field, just include `[#. Footnote text]` at the place you want the reference number to appear (e.g. `[1. This is a footnote]` or `[7. This is another one **yeah**]`):
```
“Transmigrants have multiple identities which are grounded in more than one society and thus, in effect, 
they have a hybridized transnational identity. [...] In a deterritorialized context, the conventional 
one-to-one relationship between state and territory is increasingly questioned and challenged” [1. Wong, 
L. (2002): Home away from home? Abingdon: Routledge. Seite 171]
```

**Include footnote in the list, but no reference number in the text:**  
To have a footnote / an information included in the footnotes list at the end of the text, but not as a reference number inside the text, just prepend a `<no>` tag to the footnote:
```
[0. <no>**Photo credits:** (link:http://www.flickr.com/photos/cubagallery/ text:Cuba Gallery)]
```
