BusinessDays [![Build Status](https://travis-ci.org/troglodyte/BusinessDays.svg?branch=master)](https://travis-ci.org/troglodyte/BusinessDays) [![Code Climate](https://codeclimate.com/github/troglodyte/BusinessDays/badges/gpa.svg)](https://codeclimate.com/github/troglodyte/BusinessDays) [![Test Coverage](https://codeclimate.com/github/troglodyte/BusinessDays/badges/coverage.svg)](https://codeclimate.com/github/troglodyte/BusinessDays/coverage)
============

PHP Object that calculates date differences with business days in mind (mon-fri)


#### Example


```php
<?php
use troglodyte\BusinessDays

$dt = new BusinessDays();
$num_days = $dt->getBusinessDays('01/01/2017', '01/03/2017');

// $num_days = (int) 2

// or

$num_days = BusinessDays::getBusinessDays('01/01/2017', '01/03/2017');
// $num_days = (int) 2

```
