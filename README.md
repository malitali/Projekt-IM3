# Projekt-IM3-Fussball
 IM3 Projekt Tobi/Malika

Top Scorers by Nationality Project

Project Overview

This project is a web application that displays top football scorers in the Swiss Super League by nationality. Users can select different seasons to view data dynamically. The data is fetched from an external API and stored in a local database, and then visualized on the front end.

Structure of the Project

HTML (index.html): Defines the structure of the user interface for displaying top scorers by nationality. The page includes a podium for the top three nationalities and a list of other countries, with an interactive dropdown for selecting different seasons.

CSS (styles.css): Provides styles for the webpage to create a consistent and responsive layout. Includes media queries for optimizing the user interface across different devices (desktop, tablet, and mobile).

JavaScript (script.js): Implements the dynamic behavior of the webpage. Handles the fetching of season data from the server, updates the UI based on user selections, and normalizes nationalities to map with the correct flag images.

PHP Scripts:

extract_players.php: Fetches the top scorer data from an external football API for multiple seasons and processes it.

transform_players.php: Transforms and inserts the fetched data into a local database, checking for duplicates and either inserting or updating as needed.

unload.php: Retrieves the data from the local database to be displayed on the frontend, including a summary of goals scored by nationality.

Functionalities

Data Retrieval: Data is fetched from an external API for football players' statistics using extract_players.php. Data from multiple seasons is retrieved.

Data Transformation and Storage: transform_players.php processes and stores data in a local database, ensuring records are either inserted or updated to avoid duplicates.

Interactive Season Selection: The user can select different seasons using a dropdown. The JavaScript (frontend) uses this selection to load relevant data via API requests.

Visualization: A podium is displayed with the top three nationalities contributing to the most goals. Other nationalities are displayed below in a separate list.

Responsive Design: The webpage uses CSS to provide a responsive experience, ensuring it works well across different devices.

Folder and File Structure

index.html: Main HTML file that contains the structure of the web page.

css/styles.css: Contains all the styling rules to make the UI presentable and responsive.

js/script.js: JavaScript file that implements data fetching, updating UI, and event handling.

etl/: Contains the PHP files for Extract-Transform-Load (ETL) operations.

extract_players.php: Extracts the data from the external API.

transform_players.php: Transforms and loads data into the local database.

unload.php: Fetches data from the database for display.

config.php: Database configuration file used to set up connection credentials.

Setting Up and Running the Project

Dependencies: Ensure the necessary PHP extensions are installed, including PDO for database interaction and optionally pecl_http for API requests.

Database Setup: Set up the players database table as referenced in transform_players.php. Ensure that it has columns for player name, nationality, goals, assists, season, and player ID.

API Keys: Replace the placeholder for the football API key in extract_players.php with your actual API key.

Run the ETL Scripts: Execute the ETL scripts (extract_players.php and transform_players.php) to fetch and store data.

Access the Frontend: Open index.html in a browser. Use the dropdown to select different seasons and view the top scorers.

Usage

Dropdown for Season Selection: Use the dropdown to select a season. The data will automatically update to show the top three nationalities and other countries.

Responsive UI: The interface will adapt to different screen sizes, making it accessible on both desktop and mobile devices.

Future Improvements

Error Handling: Improve error messages and user feedback for network or API-related issues.

Data Refresh: Implement a scheduled data update to keep the database up-to-date with the latest player statistics.

Additional Features: Add more filtering options, such as sorting by player rather than nationality or viewing additional player statistics.

Credits

Football Data API: The external football API used to fetch player data.

Font: Uses the Google Font "Bebas Neue" for consistent typography across the webpage.



Notes:
- wir hatten enorme probleme mit der API. Wir wurden mehrmals gesperrt und erreichten das call limit, wodurch wir lange zeit nicht weiter arbeiten konnten. Schlussendlich mussten wir für die API bezahlen um nicht in Zwei Tagen ein komplett neues Projekt auf die Beine zu stellen. Auf grund dieser Schwierigkeiten sind einige Funktionen (Darstellung zusätzlicher Daten in Dropdowns), sowie der Grossteil des Styling auf der Strecke geblieben. Zudem ist uns erst zu spät aufgefallen, dass die Flaggenicons-Sammlung, die wir für das Mockup bentzt haben, nicht Icons für jedes Land beinhaltet. Aus diesem Grund wird für einige Länder eine Placeholder Flagge angezeigt. Die Grundfunktionalität steht jedoch, wie oben erklärt.
  
- Daten werden im extract_players.php in die datenbank geladen. Deshalb existiert kein load.php
  
- extract.php und transform.php sind für die funktion der website nicht mehr nötig, sind aber zur dokumentation drinnen gelassen worden. Die files sind für das laden der "league" Daten in der Datenbank gebruacht worden. diese daten wurden für eine frühere version der website gebraucht, sind in der finalen vesion aber nicht mehr notwendig.

 