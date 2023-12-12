<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Asteroids - NeoWs</title>
  <link rel="icon" type="image/x-icon" href="astronaut.png">
  <link rel="stylesheet" href="styles2.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Dongle&family=Neuton:wght@200&family=PT+Serif&family=Secular+One&family=Tangerine:wght@700&display=swap" rel="stylesheet">
</head>
<body>
<div class="header">
  <h1 class="page2"><span class="title-word title-word-1">Asteroids </span>- Near Earth Objects</h1>
  <p>This page contains information about Near Earth Objects retrieved via NASA's NeoWs API.</p>
  <p>You can explore more about NEOs by visiting the<p> <a href="https://api.nasa.gov" target="_blank">NASA API website</a></p>.</p>
  </div>

  <h2>Latest Near Earth Objects</h2>
  <hr>
  <div id="neo-objects"></div>

  <script>
    function displayNeoObjects() {
      const apiKey = '6wXQMUZUs4kO9hU0HUM5eKJ9yPgyPdTbQD20UwYM'; // Replace with your NASA API key
      const apiUrl = `https://api.nasa.gov/neo/rest/v1/feed/today?detailed=false&api_key=6wXQMUZUs4kO9hU0HUM5eKJ9yPgyPdTbQD20UwYM`;

      fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
          const neoObjects = document.getElementById('neo-objects');
          let neoHtml = '';

          if (data.near_earth_objects) {
            Object.keys(data.near_earth_objects).forEach(date => {
              data.near_earth_objects[date].forEach(neo => {
                neoHtml += `<p><b>Name:</b> ${neo.name}</p>`;
                neoHtml += `<p><b>Estimated Diameter:</b> ${neo.estimated_diameter.kilometers.estimated_diameter_min} - ${neo.estimated_diameter.kilometers.estimated_diameter_max} km</p>`;
                neoHtml += `<p><b>Close Approach Date:</b> ${date}</p>`;
                neoHtml += '<hr>';
              });
            });
          } else {
            neoHtml = '<p>No near earth objects today</p>';
          }

          neoObjects.innerHTML = neoHtml;
        })
        .catch(error => {
          console.log('Error fetching NEOs:', error);
          const neoObjects = document.getElementById('neo-objects');
          neoObjects.innerHTML = '<p>Failed to fetch Near Earth Objects</p>';
        });
    }

    displayNeoObjects();
  </script>
</body>
</html>
