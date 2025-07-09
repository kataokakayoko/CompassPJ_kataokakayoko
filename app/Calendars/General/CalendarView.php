<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $today = Carbon::today()->format('Y-m-d');
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();
      foreach($days as $day){
        if ($day->everyDay() === null || $day->everyDay() === '') {
          $html[] = '<td class="calendar-td empty-day" style="background:#ddd;"></td>';
          continue;
        }
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        if ($day->everyDay() <= $today) {
          $html[] = '<td class="calendar-td calendar-disabled">';
        } else {
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        $html[] = $day->render();

        if ($day->everyDay() <= $today) {
          if (in_array($day->everyDay(), $day->authReserveDay())) {
              $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
              $reserveLabel = match ($reservePart) {
                  1 => 'リモ1部',
                  2 => 'リモ2部',
                  3 => 'リモ3部',
                  default => '',
              };
              $html[] = '<p class="text-muted small">'. $reserveLabel .'</p>';
          } else {
              $html[] = '<p class="small" style="color: black;">受付終了</p>';
          }
          $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
      } else {
        if (in_array($day->everyDay(), $day->authReserveDay())) {
            $reserveData = $day->authReserveDate($day->everyDay())->first();
            $reservePart = $reserveData->setting_part;
            $reserveLabel = match ($reservePart) {
                1 => 'リモ1部',
                2 => 'リモ2部',
                3 => 'リモ3部',
                default => '',
            };
            $remaining = $day->remainingCapacity();
            $modalId = 'cancelModal' . str_replace('-', '_', $day->everyDay());
            $html[] = '<button type="button" class="btn btn-danger p-0 w-75" data-toggle="modal" data-target="#' . $modalId . '" style="font-size:12px">' . $reserveLabel . '</button>';
            $html[] = '
            <div class="modal fade" id="' . $modalId . '" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body text-left">
                    <p>予約日：' . $day->everyDay() . '</p>
                    <p>時間：' . $reserveLabel . '</p>
                    <p>上記の予約をキャンセルしてもよろしいでしょうか？</p>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">閉じる</button>
                    <form action="/delete/calendar" method="POST" style="display:inline;">
                      ' . csrf_field() . '
                      <input type="hidden" name="delete_date" value="' . $reserveData->setting_reserve . '">
                      <button type="submit" class="btn btn-danger">キャンセル</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
        } else {
            $html[] = $day->selectPart($day->everyDay());
        }
    }

        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
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
?>
