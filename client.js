const searchInput = document.getElementById('search');
const searchResults = document.getElementById('search-results');

searchInput.addEventListener('keyup', (event) => {
    const searchTerm = event.target.value;

    if (searchTerm.length > 2) { // Only fetch suggestions after 2 characters
        fetch('fetch_locations.php?search=' + searchTerm)
            .then(response => response.json())
            .then(data => {
                searchResults.innerHTML = ''; // Clear previous results
                data.forEach(location => {
                    const listItem = document.createElement('li');
                    listItem.textContent = location;
                    listItem.addEventListener('click', () => {
                        searchInput.value = location;
                        searchResults.innerHTML = ''; // Hide suggestions
                    });
                    searchResults.appendChild(listItem);
                });
            })
            .catch(error => {
                console.error('Error fetching locations:', error);
            });
    } else {
        searchResults.innerHTML = ''; // Clear suggestions if input is shorter than 3 characters
    }
});