// JavaScript code to fetch data from unload.php

// fetch('/etl/unload.php')
//     .then(response => {
//         // Check if the response is OK
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         return response.json(); // Parse the JSON data
//     })
//     .then(data => {
//         console.log(data); // Log the data to the console
//         displayTopScorers(data); // Call a function to display the data
//     })
//     .catch(error => {
//         console.error('There was a problem with the fetch operation:', error);
//     });

// // Function to display the fetched data
// function displayTopScorers(topScorers) {
//     const scorerList = document.getElementById('scorer-list'); // Assuming you have a <div> or <ul> with this ID

//     topScorers.forEach(scorer => {
//         const listItem = document.createElement('li');
//         listItem.textContent = `${scorer.player_name} - Goals: ${scorer.total_goals} - Country: ${scorer.country_name}`;
//         scorerList.appendChild(listItem);
//     });
// }

// Fetch the nationality goals from unload.php


// VON CHATGPT 2. version

// fetch('etl/unload.php')
//     .then(response => response.json())
//     .then(data => {
//         displayResults(data);
//     })
//     .catch(error => console.error('Error fetching data:', error));

// // Function to display results on the page
// function displayResults(data) {
//     const podium = document.getElementById('podium');
//     const otherCountries = document.getElementById('other-countries');
    
//     // Clear previous results
//     podium.innerHTML = '';
//     otherCountries.innerHTML = '';

//     // Get top 3 nationalities
//     const topNationalities = Object.entries(data).slice(0, 3);

//     topNationalities.forEach(([nationality, goals]) => {
//         const container = document.createElement('div');
//         container.className = 'podium-container';
//         container.innerHTML = `<h3>${nationality}</h3><p>Goals: ${goals}</p>`;
//         podium.appendChild(container);
//     });

//     // Display other countries
//     const remainingNationalities = Object.entries(data).slice(3);
//     remainingNationalities.forEach(([nationality, goals]) => {
//         const listItem = document.createElement('li');
//         listItem.innerHTML = `${nationality}: ${goals}`;
//         otherCountries.appendChild(listItem);
//     });
// }

// Fetch the nationality goals from unload.php
fetch('etl/unload.php')
    .then(response => response.json())
    .then(data => {
        displayResults(data);
    })
    .catch(error => console.error('Error fetching data:', error));

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
