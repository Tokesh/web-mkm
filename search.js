document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('searchForm');
    const searchText = document.getElementById('searchText');
    const searchResults = document.getElementById('searchResults');

    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const searchQuery = searchText.value;
        
        // Отправка AJAX-запроса на сервер
        fetch(`search.php?search=${encodeURIComponent(searchQuery)}`)
            .then(response => response.json())
            .then(data => {
                
                // Обновление результатов поиска на странице
                if (data.length > 0) {
                    const resultList = data.map(user => `<p>${user.username}</p>`).join('');
                    searchResults.innerHTML = `<h2>Search Results:</h2>${resultList}`;
                } else {
                    searchResults.innerHTML = '<p>No results found.</p>';
                }
            })
            .catch(error => console.error('Error:', error));
    });
});
