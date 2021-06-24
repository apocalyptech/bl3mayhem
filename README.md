Borderland 3 Mayhem Mode Configurator
=====================================

This is a little web app to generate [BL3 Hotfix Mods](http://borderlandsmodding.com/bl3/)
to alter various characteristics of BL3's [Mayhem Mode](https://borderlands.fandom.com/wiki/Mayhem_Mode).
This lets you alter which Mayhem Modifier pools are used in which mayhem
levels, what many of the scaling values are in those levels, and which
mayhem modifiers are active in each of the pools.

The scaling values in particular that it lets you edit are:

 * Enemy Scaling (does Health/Shields/Armor all at once)
 * XP Scaling
 * Cash/Eridium Scaling
 * Loot Scaling
 * Pet Health
 * Companion Health

At the moment it does *not* let you change the drop weight/quantity
scaling values, or the damage scaling parameters, mostly because
there's a hell of a lot of those values, and the codes used to identify
configurations are already gigantic.

Once you've configured how you want Mayhem Mode to operate, click the
`Generate Modfile` button to download the [B3HM-compatible mod file](http://borderlandsmodding.com/bl3-running-mods/)
containing your config.  Choose `Add Local Path` from B3HM's web UI
to add the downloaded file to your mod list.

Also, as you change the options on the page, the app will generate a
URL which uniquely identifies the config, so you can bookmark that
and return later if you want to just tweak it slightly.  The URL
will also appear in the downloaded mod file, for ease of lookup
later.

Where To Find It
----------------

The BL3 Mayhem Mode Configurator lives at https://apocalyptech.com/games/bl3-mayhem/

Hosting It Yourself
-------------------

Feel free to clone this repo and host it yourself if you like.  It
should run on any server with PHP active, though it's only been tested
on a pretty ancient PHP 5.4 machine, and may need tweaking for more
modern PHP versions.  You'll need PHP installed with JSON support,
but that should be pretty standard.

The one wrinkle will be that it uses a custom framework that I use
for writing apocalyptech.com content, which isn't included in this
repo (and isn't generally available online).  To host it yourself
you'll have to write in your own HTML header (in place of the
current `Site header` section) and footer, in `index.php`.

The app uses some data provided by my [`gen_mayhem_php.py`](https://github.com/BLCM/bl3mods/blob/master/Apocalyptech/dataprocessing/gen_mayhem_php.py)
script, though you wouldn't have to worry about regenerating that.

Licenses
--------

The main code for the Configurator is licensed under the
[New/Modified (3-Clause) BSD License](https://opensource.org/licenses/BSD-3-Clause).
A copy can be found in [COPYING.txt](COPYING.txt).

This project also includes a partial PHP port of
[pieroxy's lz-string project](https://pieroxy.net/blog/pages/lz-string/index.html),
which is licensed under the [MIT License](https://opensource.org/licenses/MIT).

The mods which this app generates are licensed under
[CC0 1.0 (Public Domain)](https://creativecommons.org/publicdomain/zero/1.0/),
so feel free to do whatever you like with those.

