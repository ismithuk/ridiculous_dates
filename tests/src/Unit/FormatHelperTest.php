<?php

namespace Drupal\Tests\ridiculous_dates\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\ridiculous_dates\Helper\FormatHelper;

/**
 * Format Helper Test.
 *
 * @group ridiculous_dates
 */
class FormatHelperTest extends UnitTestCase {

  protected $formatHelper;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->formatHelper = new FormatHelper();
  }

  /**
   * Test checkForHtmlMarkup.
   */
  public function testDateStringToArray() {

    $validConfigDates = <<<EOD
Person Day:2019-09-01
Object Day:2019-10-01
Daniel Day:2019-11-01
Night and Day:2019-12-01
EOD;

    $validArray = [
      'none' => '- Please select a date -',
      '2019-09-01' => 'Person Day (2019-09-01)',
      '2019-10-01' => 'Object Day (2019-10-01)',
      '2019-11-01' => 'Daniel Day (2019-11-01)',
      '2019-12-01' => 'Night and Day (2019-12-01)',
    ];

    $this->assertSame($validArray, FormatHelper::dateStringToArray($validConfigDates));
  }

}
