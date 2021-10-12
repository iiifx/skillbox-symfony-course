$(() => {
    $('[data-item=likes]').each(function () {
        const $container = $(this);

        $container.on('click', function (e) {
            e.preventDefault();

            const mode = $container.data('mode');

            $.ajax({
                url: '/articles/10/likes',
                method: mode === 'like' ? 'PUT' : 'DELETE'
            }).then(function (data) {
                $container.data('mode', mode === 'like' ? 'dislike' : 'like')

                $container.find('.fa-heart').toggleClass('far fas');
                $container.find('[data-item=likesCount]').text(data.likes);
            });
        });
    });
});
