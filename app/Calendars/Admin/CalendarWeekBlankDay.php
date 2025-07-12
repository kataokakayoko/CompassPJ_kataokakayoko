<?php

namespace App\Calendars\Admin;

class CalendarWeekBlankDay extends CalendarWeekDay {

  public function getClassName() {
    return "day-blank";
  }

  public function render() {
    return '';
  }

  public function everyDay() {
    return '';
  }

  public function dayPartCounts($ymd = null) {
    return '';
  }

  public function dayNumberAdjustment() {
    return '';
  }
}
