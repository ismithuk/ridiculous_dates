<?php

namespace Drupal\ridiculous_dates\Helper;

/**
 * Format Helper.
 *
 * Format helper methods for Ridiculous Dates.
 */
class FormatHelper {

  /**
   * Date String to Array.
   *
   * @param string $value
   *   String of submitted dates.
   *
   * @return array
   *   Return array of dates
   */
  public static function dateStringToArray(string $value) {

    $submittedDatesExplode = explode(PHP_EOL, $value);

    $dateArray['none'] = '- Please select a date -';

    foreach ($submittedDatesExplode as $date) {
      $dateExplode = explode(':', $date);
      $key = $dateExplode[0] . " (" . trim($dateExplode[1]) . ")";
      $dateArray{trim($dateExplode[1])} = $key;
    }

    return $dateArray;
  }

}
