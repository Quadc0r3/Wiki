$(document).ready(function () {
    var currentPage = 1; // Initial page

    function loadArticles(page) {
        $.ajax({
            url: 'php/article/load.php', // Update with the actual URL to load the articles
            type: 'GET',
            data: {page: page},
            success: function (response) {
                $('#articleTable').html(response); // Update the article table with the loaded articles
            }
        });
    }

    function handlePaginationClick() {
        currentPage = parseInt($(this).text());
        loadArticles(currentPage);
        return false; // Prevent the default link behavior
    }

    // Initial page load
    loadArticles(currentPage);

    // Handle pagination button click
    $(document).on('click', '.pagination_button', handlePaginationClick);
});