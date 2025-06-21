window.$ = window.jQuery = require('jquery');

import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function () {
  $(document).on('click', '.delete-modal-open', function () {
    const postId = $(this).data('post-id');
    $('#deleteForm').attr('action', '/bulletin_board/post/' + postId);
    $('.js-delete-modal').fadeIn();
  });

  $('.js-delete-modal-close').on('click', function (e) {
    e.preventDefault();
    $('.js-delete-modal').fadeOut();
  });

  $(document).on('click', '.js-delete-modal-close, .modal__bg', function () {
    $('.js-delete-modal').fadeOut();
  });

});
