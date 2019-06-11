<?php

namespace Drupal\ridiculous_dates\Helper;

use DateTime;

/**
 * Validation Helper.
 *
 * Validation helper methods for Ridiculous Dates.
 */
class ValidationHelper implements ValidationHelperInterface {

  /**
   * {@inheritdoc}
   *
   * @todo Add check for string title
   * @todo Add check for duplication
   */
  public function checkForInvalidRidiculousDate(string $value) {

    // Check if date contains colon.
    $explodeValueOnColon = explode(':', $value);
    if (count($explodeValueOnColon) === 1) {
      return TRUE;
    }

    // Check if date is valid.
    $submittedDate = trim($explodeValueOnColon[1]);
    if (!$this->validateDate($submittedDate)) {
      return TRUE;
    }

    // Date format is valid, return false.
    return FALSE;
  }

  /**
   * Check for HTML markup in submitted dates.
   *
   * @param string $value
   *   All submitted dates.
   *
   * @return bool
   *   Return TRUE if value includes HTML Markup
   */
  public static function checkForHtmlMarkup(string $value) {
    if ($value === strip_tags($value)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Validate Date.
   *
   * Code taken from php.net
   * @link https://www.php.net/manual/en/function.checkdate.php#113205
   *
   * @param string $date
   *   Submitted date value.
   * @param string $format
   *   Optional format can be provided, default set to Y-m-d.
   *
   * @return bool
   *   Return TRUE if date is valid
   */
  private function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
  }

}
