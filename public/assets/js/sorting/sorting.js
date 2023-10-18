function appySorting() {
    // Sorting ASC and DESC
    $(document).on('click', '.column-sort', function (e) {
        var desc = `<i class="fa-solid fa-arrow-up-wide-short">`;
        var asc = `<i class="fa-solid fa-arrow-down-wide-short"></i>`;
        var column = $(this).attr('data-column');
        var order = $(this).attr('data-sort');
        var currentUrl = window.location.href;
        if (order === 'desc') {
            $(this).attr('data-sort', 'asc');
            $(this).find('.sort-icon').empty().append(asc);

        } else {
            $(this).attr('data-sort', 'desc');
            $(this).find('.sort-icon').empty().append(desc);
        }
        if (currentUrl.includes('?')) {
            currentUrl += `&column=${column}&order=${order}`;
        } else {
            currentUrl += `?column=${column}&order=${order}`;
        }
        console.log(currentUrl);
        showLoading()
        $.ajax({
            url: currentUrl,
            type: 'GET',
            success: function (response) {
                $('tbody').empty();
                $('tbody').append(response);
            },
            complete: function () {
                hideLoading();
            }
        })
    })
}
