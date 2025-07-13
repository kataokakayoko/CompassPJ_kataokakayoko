$(function () {
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });

  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();

    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $(this).removeClass('like_btn').addClass('un_like_btn');
    $(this).removeClass('far fa-heart').addClass('fas fa-heart');
    $(this).css('color', 'red');

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: { post_id: post_id },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function () {
      console.log('いいね失敗');
    });
  });

  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();

    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $(this).removeClass('un_like_btn').addClass('like_btn');
    $(this).removeClass('fas fa-heart').addClass('far fa-heart');
    $(this).css('color', '#ccc');

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: { post_id: post_id },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {
      console.log('いいね取り消し失敗');
    });
  });

  $('.edit-modal-open').on('click', function () {
    var post_title = $(this).data('post_title');
    var post_body = $(this).data('post_body');
    var post_id = $(this).data('post_id');
    $('#edit-post-title').val(post_title);
    $('#edit-post-body').val(post_body);
    $('#edit-post-id').val(post_id);
    $('#edit-post-category-id').val($(this).data('post_category_id'));
    $('.js-modal').addClass('open');
    return false;
  });

  $('.js-modal-close').on('click', function () {
    $('.js-modal').removeClass('open');
  });

  $(document).on('click', '.delete-modal-open', function () {
    $('.js-delete-modal').addClass('open');
    var postId = $(this).data('post-id');
    $('#deleteForm').attr('action', '/bulletin_board/post/' + postId);
  });

  $(document).on('click', '.js-delete-modal-close', function () {
    $('.js-delete-modal').removeClass('open');
    return false;
  });

  const errorFlag = $('#validation-error-flag').data('error');
  const isCommentError = $('#comment-error-flag').data('error');
  if (errorFlag && !isCommentError) {
    $('.js-modal').addClass('open');
  }
});
