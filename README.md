PicoXMLSitemap
==============

<!--
@author     Brice Boucard
@link       https://github.com/bricebou/PicoXMLSitemap/
@license    MIT License | http://bricebou.mit-license.org/
-->

PicoXMLSitemap is a [Pico 2][1] plugin used to automatically generate a valid [XML sitemap][2].

## Installation

__/!\ No matter the way you install the plugin, it's mandatory you name the plugin folder `PicoXMLSitemap`.__ 

### Using Git

Just move to your Pico CMS `plugins/` directory and run:

```bash
git clone https://github.com/bricebou/PicoXMLSitemap
```

### Otherwise

Download the [latest zip archive from Github](https://github.com/bricebou/PicoXMLSitemap/archive/master.zip) and unzip it inside a `plugins/PicoXMLSitemap/` folder.

## Configuration & Usage

You don't necessary have to do anything to configure the PicoXMLSitemap plugin!

Browse to `http://yoursite.com/?sitemap.xml` or `http://yoursite.com/sitemap.xml` (if you have mod_rewrite enabled) and that's it !

However, you can configure some parameters and exclude some URL from the generated sitemap. Just past these few lines into the `config/config.yml` or in a specific `.yml` file.

```yaml
# Enable/Disable the plugin
PicoXMLSitemap.enabled: true
pico_sitemap:
  # the sitemap URL (if empty, `sitemap.xml` by default)
  url: "sitemap.xml"
  # URL to exlude without the `base_url`
  excluded_url: 
    - "tutos"
    - "tutos/Linux"
  # Regular expression pattern to exclude from the sitemap
  excluded_url_pattern:
    - "#/_#"
```

## Note

* The `Date:` YAML header in your `.md` files, and `date_format` in your `config/config.yml` should match. The plugin will encode this date to be be in [W3C Datetime][3] format. This format allows you to omit the time portion, if desired, and use YYYY-MM-DD.

[1]: http://picocms.org/
[2]: http://www.sitemaps.org/
[3]: http://www.w3.org/TR/NOTE-datetime
