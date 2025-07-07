<x-sidebar>
<!-- <p>ユーザー検索</p> -->
<div class="search_content w-100 d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="one_person">
      <div>
      <div class="user-info-box">
      <div class="user-info-item">
    <span class="user-info-label">ID : </span>
    <span class="user-info-value"><strong>{{ $user->id }}</strong></span>
</div>

<div class="user-info-item">
    <span class="user-info-label">名前 : </span>
    <a href="{{ route('user.profile', ['id' => $user->id]) }}" class="user-info-value">
      <span><strong>{{ $user->over_name }}</strong></span>
      <span><strong>{{ $user->under_name }}</strong></span>
    </a>
</div>

<div class="user-info-item">
    <span class="user-info-label">カナ : </span>
    <span class="user-info-value"><strong>({{ $user->over_name_kana }} {{ $user->under_name_kana }})</strong></span>
</div>

<div class="user-info-item">
    <span class="user-info-label">性別 : </span>
    <span class="user-info-value">
      <strong>
        @if($user->sex == 1)
            男
        @elseif($user->sex == 2)
            女
        @else
            その他
        @endif
      </strong>
    </span>
</div>

<div class="user-info-item">
    <span class="user-info-label">生年月日 : </span>
    <span class="user-info-value"><strong>{{ $user->birth_day }}</strong></span>
</div>

<div class="user-info-item">
    <span class="user-info-label">権限 : </span>
    <span class="user-info-value">
      <strong>
        @if($user->role == 1)
            教師(国語)
        @elseif($user->role == 2)
            教師(数学)
        @elseif($user->role == 3)
            講師(英語)
        @else
            生徒
        @endif
      </strong>
    </span>
</div>

<div class="user-info-item">
    @if($user->role == 4)
        <span class="user-info-label">選択科目 : </span>
        @if(!$user->subjects->isEmpty())
            @foreach($user->subjects as $subject)
                <span class="subject-item-search"><strong>{{ $subject->subject }}</strong></span>
            @endforeach
        @endif
    @endif
</div>
</div>
</div>
</div>
@endforeach
</div>
  <div class="search_area w-25">
      <form action="{{ route('user.show') }}" method="get" id="userSearchRequest">
        <div class="search-container">
          <div class="search-field">
            <label for="keyword" class="label">検索</label>
            <div class="input-container">
              <input type="text" id="keyword" class="free_word search-input" name="keyword" placeholder="キーワードを検索">
            </div>
          </div>
          <div class="search-field">
            <label for="category" class="label">カテゴリ</label>
            <div class="input-container">
              <select name="category" id="category" class="search-select">
                <option value="name">名前</option>
                <option value="id">社員ID</option>
              </select>
            </div>
          </div>
          <div class="search-field">
            <label for="updown" class="label">並び替え</label>
            <div class="input-container">
              <select name="updown" id="updown" class="search-select">
                <option value="ASC">昇順</option>
                <option value="DESC">降順</option>
              </select>
            </div>
          </div>
          <div class="accordion">
            <div class="accordion-header">
             <p class="m-0 search_conditions">検索条件の追加</p>
              <span class="accordion-toggle">
                <button class="accordion-btn">
                  <span class="arrow"></span>
                </button>
              </span>
            </div>
            <div class="search_conditions_inner">
              <div class="search-field">
                <label class="label">性別</label>
                <div class="input-container">
                  <label><input type="radio" name="sex" value="1"> 男</label>
                  <label><input type="radio" name="sex" value="2"> 女</label>
                  <label><input type="radio" name="sex" value="3"> その他</label>
                </div>
              </div>
              <div class="search-field">
                <label for="role" class="label">権限</label>
                <div class="input-container">
                  <select name="role" id="role" class="search-select">
                    <option selected disabled>----</option>
                    <option value="1">教師(国語)</option>
                    <option value="2">教師(数学)</option>
                    <option value="3">教師(英語)</option>
                    <option value="4">生徒</option>
                  </select>
                </div>
              </div>
              <div class="search-field selected_engineer">
                <label for="subjects" class="label">選択科目</label>
                <div class="subject-container">
                  @foreach($subjects as $subject)
                  <div class="subject-checkbox-wrapper">
                    <span>{{ $subject->subject }}</span>
                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"/>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="button-group" style="display: block;">
          <input type="submit" name="search_btn" value="検索" class="search-btn-btn">
          <input type="reset" value="リセット" class="reset-btn-btn">
          </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(function () {
      $('.accordion-toggle').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var $arrow = $(this).find('.arrow');
        var $searchConditionsInner = $(this).closest('.accordion').find('.search_conditions_inner');

        $searchConditionsInner.slideToggle();

        $arrow.toggleClass('open');
      });
    });
  </script>

<style>
.accordion-btn .arrow.open {
transform: rotate(-135deg);
}
</style>
</x-sidebar>
