// JavaScript code to fetch data from unload.php

fetch('/etl/unload.php')
    .then(response => {
        // Check if the response is OK
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Parse the JSON data
    })
    .then(data => {
        console.log(data); // Log the data to the console
        displayTopScorers(data); // Call a function to display the data
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });

// Function to display the fetched data
function displayTopScorers(topScorers) {
    const scorerList = document.getElementById('scorer-list'); // Assuming you have a <div> or <ul> with this ID

    topScorers.forEach(scorer => {
        const listItem = document.createElement('li');
        listItem.textContent = `${scorer.player_name} - Goals: ${scorer.total_goals} - Country: ${scorer.country_name}`;
        scorerList.appendChild(listItem);
    });
}
