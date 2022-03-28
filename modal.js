$(document).ready(function () {

    $(function () {
        $('.modal-open').click(function () {
            $('#delete-modal').fadeIn();
        });

        $('.modal-close').click(function () {
            $('#delete-modal').fadeOut();
        });
    });
});