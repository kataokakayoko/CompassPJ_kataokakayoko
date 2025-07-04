<x-guest-layout>
  <form action="{{ route('registerPost') }}" method="POST">
  @csrf
  <div class="w-100 vh-100 d-flex flex-column align-items-center justify-content-center" style="background: #ECF1F6;">
      <div class="w-25 vh-75 border p-3"style="background: #fff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">

        <div class="register_form">
          <div class="d-flex mt-3" style="justify-content:space-between">
            <div class="" style="width:140px">
              <label class="d-block m-0" style="font-size:13px"><strong>姓</strong></label>
              <div class="border-bottom border-primary" style="width:140px;">
              <input type="text" style="width:140px;" class="border-0 over_name" name="over_name" value="{{ old('over_name') }}">
              </div>
              @error('over_name')
                <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
              @enderror
            </div>
            <div class="" style="width:140px">
              <label class=" d-block m-0" style="font-size:13px"><strong>名</strong></label>
              <div class="border-bottom border-primary" style="width:140px;">
              <input type="text" style="width:140px;" class="border-0 under_name" name="under_name" value="{{ old('under_name') }}">
              </div>
              @error('under_name')
                <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="d-flex mt-3" style="justify-content:space-between">
            <div class="" style="width:140px">
              <label class="d-block m-0" style="font-size:13px"><strong>セイ</strong></label>
              <div class="border-bottom border-primary" style="width:140px;">
              <input type="text" style="width:140px;" class="border-0 over_name_kana" name="over_name_kana" value="{{ old('over_name_kana') }}">
              </div>
              @error('over_name_kana')
              <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
              @enderror
            </div>
            <div class="" style="width:140px">
              <label class="d-block m-0" style="font-size:13px"><strong>メイ</strong></label>
              <div class="border-bottom border-primary" style="width:140px;">
              <input type="text" style="width:140px;" class="border-0 under_name_kana" name="under_name_kana" value="{{ old('under_name_kana') }}">
              </div>
              @error('under_name_kana')
              <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="mt-3">
            <label class="m-0 d-block" style="font-size:13px"><strong>メールアドレス</strong></label>
            <div class="border-bottom border-primary">
            <input type="email" class="w-100 border-0 mail_address" name="mail_address" value="{{ old('mail_address') }}">
            </div>
            @error('mail_address')
            <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
            @enderror
        </div>
        </div>
        <div class="mt-3">
        <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; align-items: center;">
          <input type="radio" name="sex" class="sex" value="1" {{ old('sex') == 1 ? 'checked' : '' }}>
          <label style="font-size:13px"><strong>男性</strong></label>
          <input type="radio" name="sex" class="sex" value="2" {{ old('sex') == 2 ? 'checked' : '' }}>
          <label style="font-size:13px"><strong>女性</strong></label>
          <input type="radio" name="sex" class="sex" value="3" {{ old('sex') == 3 ? 'checked' : '' }}>
          <label style="font-size:13px"><strong>その他</strong></label>
          </div>
          @error('sex')
          <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-3">
          <label class="d-block m-0 aa" style="font-size:13px"><strong>生年月日</strong></label>
          <select class="old_year" name="old_year">
            <option value="">-----</option>
            <option value="1985">1985</option>
            <option value="1986">1986</option>
            <option value="1987">1987</option>
            <option value="1988">1988</option>
            <option value="1989">1989</option>
            <option value="1990">1990</option>
            <option value="1991">1991</option>
            <option value="1992">1992</option>
            <option value="1993">1993</option>
            <option value="1994">1994</option>
            <option value="1995">1995</option>
            <option value="1996">1996</option>
            <option value="1997">1997</option>
            <option value="1998">1998</option>
            <option value="1999">1999</option>
            <option value="2000">2000</option>
            <option value="2001">2001</option>
            <option value="2002">2002</option>
            <option value="2003">2003</option>
            <option value="2004">2004</option>
            <option value="2005">2005</option>
            <option value="2006">2006</option>
            <option value="2007">2007</option>
            <option value="2008">2008</option>
            <option value="2009">2009</option>
            <option value="2010">2010</option>
          </select>
          <label style="font-size:13px"><strong>年</strong></label>
          <select class="old_month" name="old_month">
            <option value="">-----</option>
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>
          <label style="font-size:13px"><strong>月</strong></label>
          <select class="old_day" name="old_day">
            <option value="">-----</option>
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
          </select>

          <label style="font-size:13px"><strong>日</strong></label>
          @error('old_year')
            <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
          @enderror
          @error('old_month')
            <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
          @enderror
          @error('old_day')
            <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
          @enderror
        </div>

        <div class="mt-3">
          <label class="d-block m-0" style="font-size:13px"><strong>役職</strong></label>
          <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; align-items: center;">
          <input type="radio" name="role" class="admin_role role" value="1" {{ old('role') == 1 ? 'checked' : '' }}>
          <label style="font-size:13px"><strong>教師(国語)</strong></label>
          <input type="radio" name="role" class="admin_role role" value="2" {{ old('role') == 2 ? 'checked' : '' }}>
          <label style="font-size:13px"><strong>教師(数学)</strong></label>
          <input type="radio" name="role" class="admin_role role" value="3" {{ old('role') == 3 ? 'checked' : '' }}>
          <label style="font-size:13px"><strong>教師(英語)</strong></label>
          <input type="radio" name="role" class="other_role role" value="4" {{ old('role') == 4 ? 'checked' : '' }}>
          <label style="font-size:13px" class="other_role"><strong>生徒</strong></label>
          </div>
          @error('role')
          <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
          @enderror
        </div>
        <div class="select_teacher d-none">
          <label class="d-block m-0" style="font-size:13px"><strong>選択科目</strong></label>
          @foreach($subjects as $subject)
          <div class="">
          <input type="checkbox" name="subject[]" value="{{ $subject->id }}" {{ is_array(old('subject')) && in_array($subject->id, old('subject')) ? 'checked' : '' }}>
            <label>{{ $subject->subject }}</label>
          </div>
          @endforeach
        </div>
        <div class="mt-3">
          <label class="d-block m-0" style="font-size:13px"><strong>パスワード</strong></label>
          <div class="border-bottom border-primary">
            <input type="password" class="border-0 w-100 password" name="password">
          </div>
          @error('password')
          <div class="text-danger" style="font-size:12px;">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-3">
          <label class="d-block m-0" style="font-size:13px"><strong>確認用パスワード</strong></label>
          <div class="border-bottom border-primary">
            <input type="password" class="border-0 w-100 password_confirmation" name="password_confirmation">
          </div>
        </div>
        <div class="mt-5 text-right">
          <input type="submit" class="btn btn-primary register_btn" disabled value="新規登録" onclick="return confirm('登録してよろしいですか？')">
        </div>
        <div class="text-center">
          <a href="{{ route('login') }}">ログインはこちら</a>
        </div>
      </div>
    </div>
  </form>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
</x-guest-layout>
