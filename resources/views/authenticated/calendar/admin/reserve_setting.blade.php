<x-sidebar>
  <div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-100 vh-100 p-5" style="position:relative;">
  <div class="calendar-wrapper" style="background-color: white; border-radius: 8px; padding: 10px;
                                      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1); position:relative; z-index:1;
                                      margin: 0 10px;">
        <div id="calendar-header" class="text-center mb-3">
          <h3 id="calendar-month-year" style="font-size: 1.2rem;"></h3>
        </div>
        {!! $calendar->render() !!}
        <div class="adjust-table-btn m-auto text-right" style="padding-top: 20px;">
          <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
        </div>
      </div>
    </div>
  </div>
</x-sidebar>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const today = new Date();
    const tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 1);
    const allDateCells = document.querySelectorAll('td');
    allDateCells.forEach(function(cell) {
      const dateText = cell.textContent.trim();
      const dateInt = parseInt(dateText, 10);
      if (!isNaN(dateInt) && dateInt >= tomorrow.getDate()) {
        cell.style.backgroundColor = 'white';
      }
    });
    const calendarHeader = document.getElementById('calendar-month-year');
    const monthNames = [
      '1月', '2月', '3月', '4月', '5月', '6月',
      '7月', '8月', '9月', '10月', '11月', '12月'
    ];

    const year = today.getFullYear();
    const month = today.getMonth();
    calendarHeader.textContent = `${year}年 ${monthNames[month]}`;
  });
</script>
