import $ from 'jquery';

$(() => {
    $('[data-item=likes]').each(function () {
        const $container = $(this);

        $container.on('click', function (e) {
            e.preventDefault();

            const mode = $container.data('mode');
            const url = $container.data('url');

            $.ajax({
                url: url,
                method: mode === 'like' ? 'PUT' : 'DELETE'
            }).then(function (data) {
                $container.data('mode', mode === 'like' ? 'dislike' : 'like')

                $container.find('.fa-heart').toggleClass('far fas');
                $container.find('[data-item=likesCount]').text(data.likes);
            });
        });
    });
});
