var containers = $('.js-vote-arrows');
containers.find('a').on('click', function (e) {
  e.preventDefault();
  var $link = $(e.currentTarget);
  var answerId = $link.parent('.js-vote-arrows').data('answer-id');
  $.ajax({
    url: '/comments/10/vote/' + $link.data('direction'),
    method: 'POST',
  }).then(function (data) {
    $('[data-answer-id="' + answerId + '"] .js-vote-total').text(data.votes);
  });
});
