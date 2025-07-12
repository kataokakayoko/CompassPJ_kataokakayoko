<?php

namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay {
  protected $carbon;

  function __construct($date) {
    $this->carbon = new Carbon($date);
  }

  public function getCarbon() {
    return $this->carbon;
  }

  function getClassName() {
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render() {
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay() {
    return $this->carbon->format("Y-m-d");
  }

  function dayPartCounts($ymd) {
    $html = [];
    $one_part = ReserveSettings::withCount('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::withCount('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::withCount('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

    $html[] = '<div class="text-left">';

    if($one_part) {
      $url = route('calendar.admin.detail', ['date' => $ymd, 'part' => 1]);
      $html[] = '<p class="day_part m-0 pt-1"><a href="'.$url.'" class="text-primary text-decoration-underline">1部</a>：' . $one_part->users_count . '</p>';
    }

    if($two_part) {
      $url = route('calendar.admin.detail', ['date' => $ymd, 'part' => 2]);
      $html[] = '<p class="day_part m-0 pt-1"><a href="'.$url.'" class="text-primary text-decoration-underline">2部</a>：' . $two_part->users_count . '</p>';
    }

    if($three_part) {
      $url = route('calendar.admin.detail', ['date' => $ymd, 'part' => 3]);
      $html[] = '<p class="day_part m-0 pt-1"><a href="'.$url.'" class="text-primary text-decoration-underline">3部</a>：' . $three_part->users_count . '</p>';
    }

    $html[] = '</div>';
    return implode("", $html);
  }

  function onePartFrame($day) {
    $setting = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    return $setting ? $setting->limit_users : "20";
  }

  function twoPartFrame($day) {
    $setting = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    return $setting ? $setting->limit_users : "20";
  }

  function threePartFrame($day) {
    $setting = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    return $setting ? $setting->limit_users : "20";
  }

  function dayNumberAdjustment() {
    return '
      <div class="adjust-area">
        <p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>
        <p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>
        <p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>
      </div>
    ';
  }

  public function reservedUserCount($ymd) {
    $count = 0;
    $parts = [1, 2, 3];
    foreach ($parts as $part) {
      $setting = ReserveSettings::withCount('users')->where('setting_reserve', $ymd)->where('setting_part', $part)->first();
      if ($setting) $count += $setting->users_count;
    }
    return $count;
  }
}
