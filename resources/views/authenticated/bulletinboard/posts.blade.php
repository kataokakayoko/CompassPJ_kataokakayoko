<x-sidebar>
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
    <p><strong><span style="color: #888;">{{ $post->user->over_name }}</span><span class="ml-3" style="color: #888;">{{ $post->user->under_name }}</span><span style="color: #888;">さん</span></strong></p>
      <p><strong><a href="{{ route('post.detail', ['id' => $post->id]) }}"class="post-text">{{ $post->post_title }}</a></strong></p>
      <p class="sub-categories" style="font-size: 12px;">
  <div class="post-meta d-flex justify-content-between align-items-center">
    @foreach($post->subCategories as $subCategory)
        <span class="sub-category-item">{{ $subCategory->sub_category }}</span>
        @if(!$loop->last)
            <span>, </span>
        @endif
    @endforeach
  </p>
  </div>
      <div class="post_bottom_area d-flex justify-content-end" style="position: relative;">
      <div class="d-flex post_status" style="position: absolute; bottom: 0; right: 10px;">
          <div class="mr-5">
            <i class="fa fa-comment" style="color: #888;"></i>
              <span style="color: #888;">{{ $post->post_comments_count }}</span>
                </div>
                  <div>
                  @if(Auth::user()->is_Like($post->id))
                <p class="m-0">
                  <i class="fas fa-heart un_like_btn like-btn-red" post_id="{{ $post->id }}"></i>
                  <span class="like_counts{{ $post->id }}">{{ $post->likes_count }}</span>
                </p>
              @else
                <p class="m-0">
                 <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
                 <span class="like_counts{{ $post->id }}">{{ $post->likes_count }}</span>
              </p>
              @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25">
    <div class=" m-4">
      <div class="post-btn"><a href="{{ route('post.input') }}">投稿</a></div>
      <div class="search-box">
        <input type="text" class="search-input" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="search-btn" value="検索" form="postSearchRequest">
      </div>
      <div class="custom-button-container">
      <input type="submit" name="like_posts" class="category_btn like-posts" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn my-posts" value="自分の投稿" form="postSearchRequest">
      </div>
      <ul>
      @foreach($categories as $category)
  <div class="category-search">
    <li class="main_categories" category_id="{{ $category->id }}">
      <button class="accordion-btn">{{ $category->main_category }}<span class="arrow"></span> </button>
      <ul class="sub-category-list">
        @foreach($category->subCategories as $subCategory)
          <li style="margin-left: 10px;">
            <button type="submit"
                    name="sub_category_word"
                    value="{{ $subCategory->sub_category }}"
                    class="category-btn"
                    form="postSearchRequest">
              {{ $subCategory->sub_category }}
            </button>
          </li>
        @endforeach
      </ul>
    </li>
  </div>
@endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>

<script>
 document.addEventListener("DOMContentLoaded", function() {
    var accordions = document.querySelectorAll(".accordion-btn");
    accordions.forEach(function(accordion) {
      accordion.addEventListener("click", function() {
        var sublist = this.closest("li").querySelector(".sub-category-list");
        if (!sublist) {
          console.log("sublist not found for", this);
          return;
        }
        var allSubLists = document.querySelectorAll('.sub-category-list');
        allSubLists.forEach(function(list) {
          if (list !== sublist) {
            list.classList.remove("open");
            list.style.display = "none";
          }
        });
        if (!sublist.classList.contains("open")) {
          sublist.classList.add("open");
          sublist.style.display = "block";
        } else {
          sublist.classList.remove("open");
          sublist.style.display = "none";
        }
        this.classList.toggle("open");
      });
    });
  });
</script>
</x-sidebar>
