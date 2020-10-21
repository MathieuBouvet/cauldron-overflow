import $ from 'jquery';

const containers = $('.js-vote-arrows');
containers.find('a').on('click', function (e) {
  e.preventDefault();
  const $link = $(e.currentTarget);
  const answerId = $link.parent('.js-vote-arrows').data('answer-id');
  $.ajax({
    url: '/comments/10/vote/' + $link.data('direction'),
    method: 'POST',
  }).then(function (data) {
    $('[data-answer-id="' + answerId + '"] .js-vote-total').text(data.votes);
  });
});
