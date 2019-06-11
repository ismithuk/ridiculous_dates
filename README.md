# Ridiculous Dates

## Introduction

**DEMO Module**

**This is a demo module and I highly recommend not using it in a production site.**

---

Provides a set of ridiculous dates as conditions for block placements.

Ridiculous dates comes pre-packaged with the following dates in 2019 to use:

* National Drink Wine Day:2019-02-05
* Mario Day:2019-03-10
* Batman Day:2019-05-01
* Video Games Day:2019-07-08
* World Emoji Day:2019-07-17
* International Cat Day:2019-08-08
* Wife Appreciation Day:2019-09-15
* Sweetest Day:2019-10-19
* Mickey Mouse Birthday:2019-11-18
* National Bacon Day:2019-12-30

You can add/update and delete these days using the config page. See Configuration.

## Requirements
* Drupal 8

## Installation

### Composer

This is currently a sandbox module so you will need to add a new repo to your composer.json file:

```
"drupal-ismith/ridiculous_dates": {
     "type": "package",
     "package": {
         "name": "drupal-ismith/ridiculous_dates",
         "version": "v0.3-alpha",
         "type": "drupal-module",
         "source": {
             "url": "https://github.com/ismithuk/ridiculous_dates.git",
             "type": "git",
             "reference": "v0.3-alpha"
         }
     }
 }
```

You can then use composer require to include this module.

`composer require drupal-ismith/ridiculous_dates`

## Configuration

You can administer who has access to the ridiculous dates configuration by assigning, **"Administer ridiculous_dates configuration"** to the appropriate roles.

Config page to update ridiculous dates can be here:

`/admin/config/system/ridiculous_dates/settings`


## Maintainers

#### Current maintainers:
 * Ian Smith - https://www.drupal.org/u/isuk