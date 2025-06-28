<x-sidebar>
<div class="vh-100 d-flex">
  <div class="w-50 mt-5">
    <div class="m-3 detail_container">
      <div class="p-3">
        <div class="detail_inner_head">
          <div></div>
          <div>
            @if(Auth::id() === $post->user_id)
            <span class="edit-modal-open"
                data-post_title="{{ e($post->post_title) }}"
                data-post_body="{{ e($post->post) }}"
                data-post_id="{{ $post->id }}"
                style="cursor:pointer;">
                編集
            </span>
              <button type="button" class="delete-modal-open btn btn-link text-danger" data-post-id="{{ $post->id }}">削除</button>
            @endif
          </div>
        </div>
        <div class="modal js-delete-modal">
          <div class="modal__bg js-delete-modal-close"></div>
          <div class="modal__content">
            <p>この投稿を削除してもよろしいですか？</p>
            <div class="text-center">
              <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">削除する</button>
                <a class="btn btn-secondary js-delete-modal-close" href="#">キャンセル</a>
              </form>
            </div>
          </div>
        </div>
        <div class="contributor d-flex">
          <p>
            <span>{{ $post->user->over_name }}</span>
            <span>{{ $post->user->under_name }}</span>さん
          </p>
          <span class="ml-5">{{ $post->created_at }}</span>
        </div>
        <div class="detsail_post_title">{{ $post->post_title }}</div>
        <div class="mt-3 detsail_post">{{ $post->post }}</div>
      </div>
      <div class="p-3">
        <div class="comment_container">
          <span>コメント</span>
          @foreach($post->postComments as $comment)
            <div class="comment_area border-top">
              <p>
                <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
                <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
              </p>
              <p>{{ $comment->comment }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <div class="w-50 p-3">
    <div class="comment_container border m-5">
      <div class="comment_area p-3">
        <p class="m-0">コメントする</p>
        @if ($errors->has('comment'))
          <div class="alert alert-danger">{{ $errors->first('comment') }}</div>
        @endif
        <textarea class="w-100" name="comment" form="commentRequest"></textarea>
        <input type="hidden" name="post_id" id="comment-post-id" value="{{ $post->id }}">
        <input type="submit" class="btn btn-primary" form="commentRequest" value="投稿">
        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
      </div>
    </div>
  </div>
</div>

<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('post.edit') }}" method="post">
      <div class="w-100">
        @if ($errors->any())
          <div class="alert alert-danger w-50 m-auto">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <input type="hidden" id="validation-error-flag" data-error="{{ $errors->any() ? 'true' : 'false' }}" style="display:none;">
        <div class="modal-inner-title w-50 m-auto">
          <input type="text" name="post_title" id="edit-post-title" placeholder="タイトル" class="w-100"
            value="{{ old('post_title', session('editPost')->post_title ?? '') }}">
        </div>
        <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
          <textarea name="post_body" id="edit-post-body" placeholder="投稿内容" class="w-100">{{ old('post_body', session('editPost')->post ?? '') }}</textarea>
        </div>
        <input type="hidden" id="edit-post-id" name="post_id" value="{{ old('post_id', session('editPost')->id ?? '') }}">
        <input type="hidden" id="edit-post-category-id" name="post_category_id" value="{{ old('post_category_id') }}">
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-danger d-inline-block" href="javascript:void(0);">閉じる</a>
          <input type="submit" class="btn btn-primary d-block" value="編集">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>
</x-sidebar>
