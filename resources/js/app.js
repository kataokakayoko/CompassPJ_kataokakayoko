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

document.addEventListener('DOMContentLoaded', function () {
  const openButtons = document.querySelectorAll('.edit-modal-open');
  const modal = document.querySelector('.js-modal');
  const modalBg = document.querySelector('.js-modal-close');
  const titleInput = modal.querySelector('input[name="post_title"]');
  const bodyTextarea = modal.querySelector('textarea[name="post_body"]');
  const postIdInput = modal.querySelector('input[name="post_id"]');

  openButtons.forEach(button => {
    button.addEventListener('click', () => {
      titleInput.value = button.dataset.post_title;
      bodyTextarea.value = button.dataset.post_body.replace(/\\n/g, '\n');
      postIdInput.value = button.dataset.post_id;
      modal.classList.add('is-show');
    });
  });

  if (modalBg) {
    modalBg.addEventListener('click', () => {
      modal.classList.remove('is-show');
    });
  }
});
