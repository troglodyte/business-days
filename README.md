BusinessDays
============

PHP Object that calculates date differences with business days in mind (mon-fri)


#### Example


```php
<?php
use troglodyte\BusinessDays

$dt = new BusinessDays();
$num_days = $dt->getBusinessDays('11/01/2014', '11/3/2014');

// or 

$num_days = BusinessDays::getBusinessDays('11/01/2014', '11/3/2014');

?>
```