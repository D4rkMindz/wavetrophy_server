$(function () {
    registerHandlers();
});

function registerHandlers() {
    $('[data-id=login]').on('click', loginHandler);
}

function loginHandler(event) {
    event.preventDefault();
    $('has-error').removeClass('has-error');
    $('.help-block').addClass('hidden');
    showLoader();
    const data = {
        username: $('[data-id=username]').val(),
        password: $('[data-id=password]').val(),
    };
    sendPostAjax(baseurl() + 'api/auth', JSON.stringify(data))
        .then(
            function (response) {
                hideLoader();
                if (response.errors) {
                    response.errors.forEach(function (value) {
                        let elem = $(`[data-id=${value.field}]`);
                        elem.closest('.form-group').addClass('has-error');
                        elem.parent().find('span').append(value.message);
                    });
                    return;
                }
                window.location.href = baseurl() + response.language + '/home';
            },
            function (xhr) {
                hideLoader();
                const response = xhr.responseJSON;
                if (response.errors) {
                    response.errors.forEach(function (value) {
                        let elem = $(`[data-id=main]`);
                        elem.closest('.form-group').addClass('has-error');
                        elem.parent().find('p').append(value.message);
                    });
                }
            })
}