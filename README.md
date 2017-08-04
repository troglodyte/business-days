BusinessDays [![Build Status](https://travis-ci.org/troglodyte/business-days.svg?branch=master)](https://travis-ci.org/troglodyte/BusinessDays) [![Code Climate](https://codeclimate.com/github/troglodyte/BusinessDays/badges/gpa.svg)](https://codeclimate.com/github/troglodyte/BusinessDays) [![Test Coverage](https://codeclimate.com/github/troglodyte/BusinessDays/badges/coverage.svg)](https://codeclimate.com/github/troglodyte/BusinessDays/coverage)
============

PHP Object that calculates date differences with business days in mind (mon-fri)

requires php 7+

#### Example


```php
<?php
use troglodyte\BusinessDays

$dt = new BusinessDays();
$num_days = $dt->getBusinessDays('11/01/2014', '11/3/2014');

// or

$num_days = BusinessDays::getBusinessDays('11/01/2014', '11/3/2014');

```
