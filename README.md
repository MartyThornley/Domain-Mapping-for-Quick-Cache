Domain-Mapping-for-Quick-Cache
==============================

This is a little fork of the Domain Mapping plugin from WPMUDev. There are a couple small conflicts with the Quick Cache plugin and one with version 3.4 that effects password protected pages on mapped domains. I have sent the fixes to the devs so they can incorporate it, but a few people have asked for the fixes so I am just throwing it up here, hoping it might help a few people.

Installation
============

* Add the "domain-mapping.php" file to your mu-plugins folder.
* Edit wp-config.php and make sure the following is defined before the /* That's all, stop editing! Happy blogging. */:

```php
define( 'SUNRISE', 'on' );
```

* Add "sunrise.php" to the wp-content folder