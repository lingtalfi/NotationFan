Universe assets
================
2019-09-23



This document describe one way of organizing assets in the planets of the [universe](https://github.com/karayabin/universe-snapshot).

This is the recommended way since 2019-09-23.

Planet authors are expected to be aware of this recommendation, and try to implement it whenever they can (sometimes it's not always possible
if they are using other naming conventions).




How does this work?
----------------


In this document, we are talking about web assets (css files, js files).


In the **universe framework**, some planets use web assets.

Since the arrival of the [uni tool](https://github.com/lingtalfi/universe-naive-importer) planet,
planet authors can easily install files in the target application upon the import command (which is the base command of the uni tool to import
a planet).

Therefore, the idea behind the **universe assets** is that all planets follow a simple naming convention, so that the web assets
are directly copied to the web folder when the planet is imported.



So, what are those naming conventions?


- **www** should be the name of the web root directory, and should reside at the root of the application directory.


Then, we should have the following structure for a planet named **MyPlanet** from galaxy **MyGalaxy**:


```txt 
- $application_root_dir/
----- www/
--------- libs/
------------- universe/
----------------- MyGalaxy/
--------------------- MyPlanet/
------------------------- ... the web assets here
------------------------- ... ?style.css
------------------------- ... ?my-car.js

```



The UniverseAssetDependencies trick
-----------------

And now time for a personal trick.

Some planets are only exposing web assets (i.e. no php class). For instances, most of my planets starting with the letter "J" prefix are javascript tools only, 
and they are embedded in a planet for the convenience of importing them using the [uni tool](https://github.com/lingtalfi/universe-naive-importer) one liners. 

Now sometimes, some bigger planets use those "Assets only".

And so for instance if I create a big planet **MyBigPlanet** which uses a **JMyAssetPlanet** planet, I want to write the dependency in the **dependencies.byml** file
of the planet.

Now the dependencies.byml file is explained in the uni tool documentation here: [dependencies.byml](https://github.com/lingtalfi/Uni2#dependenciesbyml).


But to be honest, I never write in it manually, because my tools do that for me already, so they can potentially rewrite what I would put in there.

So instead I found another way to add those dependencies, which is implemented in **Ling\UniverseTools\DependencyTool::parseDumpDependencies**.


Basically, all I need to do is create the following structure at the root of the **MyBigPlanet**:


```txt

- MyBigPlanet/
----- UniverseAssetDependencies/
--------- $galaxyName/
------------- JMyAssetPlanet/

```

Note: those are only directories.


Alternately, the default way of importing those asset classes (or any classes) in the universe framework is to create
a functional dependency to it. In other words, we just need to create a class that uses (php use) that dependency planet.

So we can do this for instance (note: the faker class can be anywhere in your planet, this is just a suggestion):

```text
- MyBigPlanet/
----- UniverseAssetDependencies/
--------- MyBigPlanetFaker.php
```

And the content of **MyBigPlanetFaker.php** would be:

```php
<?php 

namespace MyBigPlanet\UniversalAssetDependencies; // any namespace would do actually, but keep it consistent
use TheGalaxyName\JMyAssetPlanet; // that's the trigger for my automatic tools to make a dependency to this planet


class MyBigPlanetFaker {
    public function __construct(){
        // this is not necessary but it forces the use statement to be there,
        // whereas if I don't instantiate this class, my ide's cleaning/optimizing routine would remove the 
        // not used "use statement", which would make my tools to NOT detect that dependency.
       $o = new JMyAssetPlanet(); 
    }
}



?>
```

I first didn't like too much the idea of creating a fake class, but now that I've tested both technique,
I now prefer this fake class technique more than the aforementioned directory technique, because it's a little bit 
more practical, namely I have the name of the class auto completed for me by my ide, which leads to less errors,
plus I can reference all my dependencies in one class vs creating multiple directories.

However, what's done is done, so both techniques are available.





  







 

