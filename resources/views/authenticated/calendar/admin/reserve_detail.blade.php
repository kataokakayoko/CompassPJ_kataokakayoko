<x-sidebar>
  <div class="vh-100 custom-border">
    <div class="w-50 m-auto h-75">
      <p class="margin-top-custom">
        <span>{{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}</span>
        <span class="ml-3">{{ $part }}部</span>
      </p>
      <div class="h-75">
        <div class="table-wrapper">
          <table class="table custom-table" style="table-layout: fixed; width: 100%;">
            <thead>
              <tr class="text-center">
                <th>ID</th>
                <th>名前</th>
                <th>予約場所</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($reservePersons as $reserve)
                @foreach ($reserve->users as $user)
                  <tr class="text-center">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->over_name }} {{ $user->under_name }}</td>
                    <td>リモート</td>
                  </tr>
                @endforeach
              @empty
                <tr>
                  <td colspan="3" class="text-center">予約はありません</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-sidebar>
