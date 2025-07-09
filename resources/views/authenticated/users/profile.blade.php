<x-sidebar>
  <div class="vh-100 border">
    <div class="top_area w-75 m-auto pt-5" style="text-align: left;">
      <span>{{ $user->over_name }}</span><span>{{ $user->under_name }}さんのプロフィール</span>
      <div class="user_status p-3">
        <p>名前 : <span>{{ $user->over_name }}</span><span class="ml-1">{{ $user->under_name }}</span></p>
        <p>カナ : <span>{{ $user->over_name_kana }}</span><span class="ml-1">{{ $user->under_name_kana }}</span></p>
        <p>性別 :
          @if($user->sex == 1)
            <span>男</span>
          @else
            <span>女</span>
          @endif
        </p>
        <p>生年月日 : <span>{{ $user->birth_day }}</span></p>
        <div>選択科目 :
          @foreach($user->subjects as $subject)
            <span>{{ $subject->subject }}</span>
          @endforeach
        </div>

        @can('admin')
          <div class="accordion">
            <button class="admin-accordion-btn">
              <span class="blue-text">選択科目の登録</span>
              <span class="admin-arrow"></span>
            </button>
            <div class="subject-inner">
              <form action="{{ route('user.edit') }}" method="post">
                <div class="subject-container">
                  @foreach($subject_lists as $subject_list)
                    <div class="subject-checkbox-wrapper">
                      <label>{{ $subject_list->subject }}</label>
                      <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}">
                    </div>
                  @endforeach
                <div class="button-group">
                  <input type="submit" value="登録" class="btn btn-primary">
                </div>
                </div>
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                {{ csrf_field() }}
              </form>
            </div>
          </div>
        @endcan
      </div>
    </div>
  </div>
</div>

<script>
  document.querySelectorAll('.admin-accordion-btn').forEach(button => {
    button.addEventListener('click', () => {
      const content = button.nextElementSibling;
      const arrow = button.querySelector('.admin-arrow');

      content.classList.toggle('open');
      button.classList.toggle('open');
      arrow.classList.toggle('open');
    });
  });
</script>
</x-sidebar>
