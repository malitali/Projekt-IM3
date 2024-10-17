

document.addEventListener("DOMContentLoaded", () => {
    // Fetch available seasons and initial data for the default season
    fetch('etl/unload.php?season=2022') // Default season, adjust as needed
        .then(response => response.json())
        .then(data => {
            console.log('Fetched data:', data); // Debugging log

            if (data.seasons && data.seasons.length > 0) {
                populateDropdown(data.seasons); // Populate the dropdown
                displayResults(data.data); // Display data for the first season
            } else {
                console.error('No seasons available in the response');
            }
        })
        .catch(error => console.error('Error fetching seasons:', error));

    // Listen for season change and fetch new data
    document.getElementById('season-dropdown').addEventListener('change', function() {
        const selectedSeason = this.value;
        fetchData(selectedSeason); // Fetch data for the selected season
    });
});

// Function to populate the season dropdown
function populateDropdown(seasons) {
    const seasonDropdown = document.getElementById('season-dropdown');
    seasonDropdown.innerHTML = ''; // Clear existing options

    seasons.forEach(season => {
        const option = document.createElement('option');
        option.value = season;
        option.textContent = season;
        seasonDropdown.appendChild(option);
    });

    console.log('Dropdown populated with seasons:', seasons); // Debugging log
}

// Function to fetch data for the selected season
function fetchData(season) {
    fetch(`etl/unload.php?season=${season}`) // Fetch data for the selected season
        .then(response => response.json())
        .then(data => {
            console.log('Fetched season data:', data); // Debugging log
            displayResults(data.data); // Display the results
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Function to display results on the page
function displayResults(data) {
    const podium = document.getElementById('podium');
    const otherCountries = document.getElementById('other-countries');

    // Clear previous results
    podium.innerHTML = '';
    otherCountries.innerHTML = '';

    // Get top 3 nationalities
    const topNationalities = Object.entries(data).slice(0, 3);

    topNationalities.forEach(([nationality, goals]) => {
        const container = document.createElement('div');
        container.className = 'podium-container';
        container.innerHTML = `<h3>${nationality}</h3><p>Goals: ${goals}</p>`;
        podium.appendChild(container);
    });

    // Display other countries
    const remainingNationalities = Object.entries(data).slice(3);
    remainingNationalities.forEach(([nationality, goals]) => {
        const listItem = document.createElement('li');
        listItem.innerHTML = `${nationality}: ${goals}`;
        otherCountries.appendChild(listItem);
    });
}
