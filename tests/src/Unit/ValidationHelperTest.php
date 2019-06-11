<?php

namespace Drupal\Tests\ridiculous_dates\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\ridiculous_dates\Helper\ValidationHelper;

/**
 * Validation Helper Test.
 *
 * @group ridiculous_dates
 */
class ValidationHelperTest extends UnitTestCase {

  protected $validationHelper;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->validationHelper = new ValidationHelper();
  }

  /**
   * Test checkForHtmlMarkup.
   */
  public function testCheckForHtmlMarkup() {
    $invalidSubmittedDates = <<<EOD
<script></script>
Person Day:2019-09-01
Object Day:2019-10-01
Daniel Day:2019-11-01
Night and Day:2019-12-01
EOD;

    $validSubmittedDates = <<<EOD
Person Day:2019-09-01
Object Day:2019-10-01
Daniel Day:2019-11-01
Night and Day:2019-12-01
EOD;

    // Test for Markup in submitted dates.
    $this->assertEquals(
        TRUE,
        $this->validationHelper->checkForHtmlMarkup($validSubmittedDates),
        'Valid markup test has failed.');
    $this->assertEquals(
        FALSE,
        $this->validationHelper->checkForHtmlMarkup($invalidSubmittedDates),
        'Invalid markup test has failed.');
  }

  /**
   * Test checkForInvalidRidiculousDate.
   */
  public function testCheckForInvalidRidiculousDate() {

    // Test for colon.
    $this->assertEquals(
        FALSE,
        $this->validationHelper->checkForInvalidRidiculousDate('Test Day:2019-09-01'),
        'Colon exists test has failed.');
    $this->assertEquals(
        TRUE,
        $this->validationHelper->checkForInvalidRidiculousDate('Tests Day2019-09-01'),
        'Colon does not exist test has failed.');
    $this->assertEquals(
          TRUE,
          $this->validationHelper->checkForInvalidRidiculousDate('Tests Day;2019-09-01'),
          'Mistyped semicolon exists test has failed.');
    // Test for correct date.
    $this->assertEquals(
          TRUE,
          $this->validationHelper->checkForInvalidRidiculousDate('Tests Day:201-09-01'),
          'Incorrect year test has failed.');
    $this->assertEquals(
          TRUE,
          $this->validationHelper->checkForInvalidRidiculousDate('Tests Day:201909-01'),
          'Year and month incorrect format test has failed.');
    $this->assertEquals(
          TRUE,
          $this->validationHelper->checkForInvalidRidiculousDate('Tests Day:2019-6-01'),
          'Incorrect month format test has failed.');
    $this->assertEquals(
          TRUE,
          $this->validationHelper->checkForInvalidRidiculousDate('Tests Day:2019-13-01'),
          'Unknown 13th month test has failed.');
    $this->assertEquals(
          TRUE,
          $this->validationHelper->checkForInvalidRidiculousDate('Tests Day:2019-02-1'),
          'Incorrect day format test has failed.');
    $this->assertEquals(
          TRUE,
          $this->validationHelper->checkForInvalidRidiculousDate('Tests Day:2019-02-30'),
          'Unknown 30th day test has failed.');
    $this->assertEquals(
          FALSE,
          $this->validationHelper->checkForInvalidRidiculousDate('Tests Day:2019-02-28'),
          'Edge case test for february passes.');
    $this->assertEquals(
          FALSE,
          $this->validationHelper->checkForInvalidRidiculousDate('Tests Day:2019-03-01'),
          'Normal date format test passes.');
  }

}
