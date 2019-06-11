<?php

namespace Drupal\ridiculous_dates\Helper;

/**
 * Validation Helper.
 *
 * Validation helper methods for Ridiculous Dates.
 */
interface ValidationHelperInterface {

  /**
   * Check for date format errors in submitted dates.
   *
   * @param string $value
   *   A submitted date.
   *
   * @return bool
   *   Return TRUE if date format is invalid
   */
  public function checkForInvalidRidiculousDate(string $value);

}
