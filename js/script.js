

document.addEventListener("DOMContentLoaded", () => {
    // Initialize the page on first load
    initPage();

    // Add an event listener to the dropdown to allow season changes
    const seasonDropdown = document.getElementById('season-dropdown');
    seasonDropdown.addEventListener('change', () => {
        const selectedSeason = seasonDropdown.value;
        fetchData(selectedSeason);
    });
});

// Function to initialize the page with the most recent season
function initPage() {
    fetch('etl/unload.php') // Fetch all available seasons and data
        .then(response => response.json())
        .then(data => {
            console.log('Fetched data:', data); // Debugging log

            if (data.seasons && data.seasons.length > 0) {
                const currentYear = new Date().getFullYear(); // Get current year
                const availableSeasons = data.seasons.map(Number); // Convert seasons to numbers for comparison
                const mostRecentSeason = Math.max(...availableSeasons); // Find the most recent season

                let initialSeason = mostRecentSeason; // Default to the most recent available season

                if (availableSeasons.includes(currentYear)) {
                    initialSeason = currentYear; // If current year is available, use it
                }

                populateDropdown(data.seasons); // Populate the dropdown
                document.getElementById('season-dropdown').value = initialSeason; // Set the dropdown to the selected season
                fetchData(initialSeason); // Display data for the selected season
            } else {
                console.error('No seasons available in the response');
            }
        })
        .catch(error => console.error('Error fetching seasons:', error));
}

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

function normalizeString(str) {
    // Remove diacritics (accents) and other special characters
    str = str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    // Convert to lowercase, remove punctuation, and handle special words
    return str
        .trim()
        .toLowerCase()
        .replace(/[^a-z ]/g, "") // Remove all non-alphabetic characters except spaces
        .replace(/\bdr\b/, "democratic republic") // Handle abbreviations like "DR" for Congo DR
        .replace(/\bcote divoire\b/, "ivory coast") // Handle common French forms
        .replace(/\busa\b/, "united states")
        .replace(/\buk\b/, "united kingdom")
        .replace(/\bdrc\b/, "democratic republic of congo")
        .replace(/\bivory coast\b/, "cote divoire");
}

// Function to display results on the page
function displayResults(data) {
    const podium = document.getElementById('podium');
    const otherCountries = document.getElementById('other-countries');
    const flagPath = 'images/icons/';  // Correct path to your icons

    const flagMap = {
        "afghanistan": "3944521_world_national_afghanistan.png",
        "albania": "3944483_albania_national_world.png",
        "algeria": "3944524_algeria_national_world.png",
        "antigua and barbuda": "3944498_antigua_national_barbuda_world.png",
        "argentina": "3944468_national_argentina_world.png",
        "armenia": "3944489_armenia_national_world.png",
        "australia": "3944519_australia_national_world.png",
        "austria": "3944495_national_austria_world.png",
        "azerbaijan": "3944491_azerbaijan_national_world.png",
        "bahamas": "3944526_national_world_bahamas.png",
        "bahrain": "3944523_national_world_bahrain.png",
        "bangladesh": "3944492_bangladesh_national_world.png",
        "barbados": "3944537_barbados_national_world.png",
        "belgium": "3944474_national_world_belgium.png",
        "belize": "3944534_belize_national_world.png",
        "benin": "3944514_benin_national_world.png",
        "bermuda": "3944539_bermuda_national_world.png",
        "bhutan": "3944485_bhutan_national_world.png",
        "bolivia": "3944475_bolivia_national_world.png",
        "bosnia and herzegovina": "3944541_bosnia_herzegovina_national_world.png",
        "botswana": "3944527_botswana_national_world.png",
        "brazil": "3944529_national_world_brazil.png",
        "brunei": "3944503_world_national_brunei.png",
        "bulgaria": "3944494_bulgaria_national_world.png",
        "burkina faso": "3944546_burkina_national_world.png",
        "burundi": "3944528_national_world_burundi.png",
        "cambodia": "3944516_cambodia_national_world.png",
        "cameroon": "3944506_cameroon_national_world.png",
        "canada": "3944477_national_world_canada.png",
        "cape verde": "3944473_world_verde_national_cape.png",
        "cayman islands": "3944480_world_islands_national_cayman.png",
        "central african republic": "3944479_world_republic_african_national_central.png",
        "chile": "3944532_chile_national_world.png",
        "china": "3944509_china_national_world.png",
        "colombia": "3944484_colombia_national_world.png",
        "comoros": "3944499_comoros_national_world.png",
        "congo dr": "3944451_the_republic_democratic_national_worldgo_con_of.png",
        "costa rica": "3944467_world_rica_national_costa.png",
        "croatia": "3944517_croatia_national_world.png",
        "cuba": "3944520_cuba_national_world.png",
        "czech republic": "3944482_republic_national_world_czech.png",
        "denmark": "3944497_world_national_denmark.png",
        "djibouti": "3944493_national_djibouti_world.png",
        "east timor": "3944481_timor_east_national_world.png",
        "egypt": "3944501_national_world_egipt.png",
        "el salvador": "3944443_world_salvador_national_el.png",
        "england": "3944464_england_national_world.png",
        "eritrea": "3944552_world_national_eritrea.png",
        "estonia": "3944476_estonia_national_world.png",
        "ethiopia": "3944536_world_national_ethiopia.png",
        "finland": "3944535_finland_national_world.png",
        "france": "3944500_france_national_world.png",
        "gabon": "3944496_gabon_national_world.png",
        "georgia": "3944533_georgia_national_world.png",
        "germany": "3944486_german_flag_world_national_germany.png",
        "ghana": "3944542_national_world_ghana.png",
        "greece": "3944551_greece_national_world.png",
        "greenland": "3944548_greenland_national_world.png",
        "grenada": "3944504_world_national_grenada.png",
        "guam": "3944490_national_guam_world.png",
        "guatemala": "3944502_national_guatemala_world.png",
        "guinea": "3944507_world_national_guinea.png",
        "hong kong": "3944522_kong_national_hong_world.png",
        "hungary": "3944513_world_national_hungary.png",
        "iceland": "3944515_world_national_iceland.png",
        "india": "3944512_india_national_world.png",
        "indonesia": "3944531_indonesia_national_world.png",
        "israel": "3944511_national_israel_world.png",
        "italy": "3944538_italy_national_world.png",
        "ivory coast": "3944455_coast_national_ivory_world.png",
        "japan": "3944544_world_national_japan.png",
        "jordan": "3944550_jordan_national_world.png",
        "kenya": "3944508_world_national_kenya.png",
        "kiribati": "3944525_world_national_kiribati.png",
        "laos": "3944510_laos_national_world.png",
        "latvia": "3944478_latvia_national_world.png",
        "lesotho": "3944505_world_national_lesotho.png",
        "liberia": "3944469_world_national_liberia.png",
        "macedonia": "3944530_macedonia_national_world.png",
        "malta": "3944518_malta_national_world.png",
        "mauritius": "3944463_national_world_mauritius.png",
        "mongolia": "3944461_mongolia_national_world.png",
        "namibia": "3944545_namibia_national_world.png",
        "netherlands": "3944441_netherlands_national_world.png",
        "niger": "3944457_niger_national_world.png",
        "nigeria": "3944449_nigeria_national_world.png",
        "palau": "3944466_palau_national_world.png",
        "panama": "3944446_panama_national_world.png",
        "philippines": "3944454_philippines_national_world.png",
        "romania": "3944448_romania_national_world.png",
        "russia": "3944456_russia_national_world.png",
        "saint vincent and the grenadines": "3944462_thegrenadines_national_world_saintvincent.png",
        "sao tome and principe": "3944442_principe_tome_world_national_sao_and.png",
        "scotland": "3944471_scotland_national_world.png",
        "seychelles": "3944540_seychelles_national_world.png",
        "sierra leone": "3944465_leone_national_world_sierra.png",
        "slovakia": "3944459_slovakia_national_world.png",
        "solomon islands": "3944547_world_solomon_national_islands.png",
        "somalia": "3944458_somalia_national_world.png",
        "south korea": "3944445_south_korea_national_world.png",
        "spain": "3944487_flag_world_national_spain.png",
        "swaziland": "3944450_swaziland_national_world.png",
        "sweden": "3944488_sweden_national_world.png",
        "switzerland": "3944472_national_world_switzerland.png",
        "syria": "3944543_world_national_syria.png",
        "tanzania": "3944440_tanzania_national_world.png",
        "thailand": "3944444_world_national_thailand.png",
        "togo": "3944447_world_national_togo.png",
        "turkmenistan": "3944470_turkmenistan_national_world.png",
        "uganda": "3944554_uganda_national_world.png",
        "ukraine": "3944549_national_world_ukraine.png",
        "united kingdom": "3944452_united_national_world_kingdom.png",
        "united states": "3944460_united_national_world_states.png",
        "yemen": "3944553_yemen_national_world.png",
        "zambia": "3944453_zambia_national_world.png"
    };
    

    // Clear previous results in the `.podium` container and the `other-countries`
    const podiumContainer = podium.querySelector('.podium');
    podiumContainer.innerHTML = '';  // Clear only the podium inner content
    otherCountries.innerHTML = '';  // Clear the other countries content

    // Get top 3 nationalities
    const topNationalities = Object.entries(data).slice(0, 3);
   

    const podiumOrder = [1, 2, 3]; // Order: first place (center), second place (left), third place (right)
    topNationalities.forEach(([nationality, goals], index) => {
        const container = document.createElement('div');
        container.className = `podium-container podium-${podiumOrder[index]}`;  // Assign podium-1, podium-2, podium-3 classes dynamically

        // Normalize nationality name to match flagMap keys
        const normalizedNationality = normalizeString(nationality);
        console.log(`Normalized Nationality for Podium: ${normalizedNationality}`); // Debugging log

        const flagFileName = flagMap[normalizedNationality] || 'default_flag.png';  // Use normalized key to access flagMap
        const flagImgPath = `${flagPath}${flagFileName}`;

        // Log the full path to verify
        console.log(`Flag Image Path: ${flagImgPath}`);  // Debugging log

        const flagImg = `<img src="${flagImgPath}" alt="${nationality} flag" class="flag-icon">`;

        // Nationality with flag and goals
        container.innerHTML = `${flagImg}<h3>${nationality}</h3><p>Goals: ${goals}</p>`;
        podiumContainer.appendChild(container);  // Append to the `.podium` container
    });

    // Display other countries
    const remainingNationalities = Object.entries(data).slice(3);
    remainingNationalities.forEach(([nationality, goals]) => {
        const normalizedNationality = normalizeString(nationality);
        console.log(`Normalized Nationality for Other Countries: ${normalizedNationality}`); // Debugging log

        const flagFileName = flagMap[normalizedNationality] || 'default_flag.png';
        const flagImgPath = `${flagPath}${flagFileName}`;

        console.log(`Flag Image Path for Other Countries: ${flagImgPath}`); // Debugging log

        const listItem = document.createElement('li');
        listItem.innerHTML = `<img src="${flagImgPath}" alt="${nationality} flag" class="flag-icon">${nationality}: <span>${goals}</span>`;
        otherCountries.appendChild(listItem);
    });
}
