<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Users\User;

class CalendarView{
  private $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  public function render(){
    $html = [];
    $html[] = '<div class="calendar text-center bg-white rounded shadow p-5 mt-5 ">';
    $html[] = '<h2 class="calendar-title">'.$this->getTitle().'</h2>';
$html[] = '<table class="table m-auto border adjust-table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border text-primary">土</th>';
    $html[] = '<th class="border text-danger">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';
      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->format("Y-m-01");
        $toDay = date("Y-m-d");

        $weekDay = $day->getCarbon()->dayOfWeek;
        $tdClass = 'border ' . $day->getClassName();

        if ($weekDay == 0) {
          $tdClass .= ' text-danger';
        } elseif ($weekDay == 6) {
          $tdClass .= ' text-primary';
        }

        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $tdClass .= ' past-day';
        }

        $html[] = '<td class="'.$tdClass.'">';
        $html[] = $day->render();
        $html[] = $day->dayPartCounts($day->everyDay());
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }

    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';

    return implode("", $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
