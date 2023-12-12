<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NASA APOD Display</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="icon" type="image/x-icon" href="astronaut.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Dongle&family=Neuton:wght@200&family=PT+Serif&family=Secular+One&family=Tangerine:wght@700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Neuton', serif;
    }

    .header {
      text-align: center;
    }

    .button-1 {
      padding: 10px 20px;
      margin-top: 10px;
      font-size: 1.2em;
      text-decoration: none;
      color: #fff;
      border-radius: 5px;
    }

    hr {
      border: 0;
      height: 3px;
      background: linear-gradient(to right, rgba(0, 0, 0, 0), #ccc, rgba(0, 0, 0, 0));
      margin: 20px 0;
    }

    .weather {
      text-align: center;
      font-family: 'Bree Serif', serif;
      position: relative;
    }

    .mars-image {
      width: 80px;
      height: 80px;
      margin: 10px;
    }

    #mars-weather {
      text-align: center;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-image: url('mars.jpg'); /* Replace 'your-image.jpg' with the actual path to your image */
      background-size: cover;
      background-position: center;
      color: #fff;
      margin-left: 475px;
    height: 200px;
    width: 500px;
    }

    #mars-weather p {
      margin: 10px 0px;
      font-size: 20px;
      margin-top: 20px;
  }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }

    .button-2 {
      margin-top: 10px;
      font-size: 1.2em;
      text-decoration: none;
      color: #fff;
      background-color: #007FFF;
      border-radius: 5px;
    }

    /* Add a new class for the fade-in effect */
  .fade-in-overlay {
    position: relative;
    overflow: hidden;
  }

  .fade-in-overlay:after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
    opacity: 0;
    transition: opacity 2s ease-in-out; /* Adjust the animation duration as needed */
    pointer-events: none;
    z-index: 1;
  }

  .fade-in-overlay.fade-in-overlay-visible:after {
    opacity: 1;
  }
  </style>

</head>
<body>
  <div class="header">
    <h1 class="page1">
      <span class="title-word title-word-1">Astronomy</span> Picture of the Day
    </h1>
    <p>Each day a different image or photograph of our fascinating universe is featured, along with a brief explanation written by a professional astronomer.</p>
    <a href="#apod-content" class="button-1">View</a>
  </div>
  <hr>
  <div id="apod-content"></div>
  <hr>
  <h2 class="weather fade-in-overlay">Mars Weather<img class="mars-image" src="mars.gif"></h2>
  <div id="mars-weather"></div>
  <hr>
  <h2>Other Links</h2>
  <a href="page2.php">Asteroids - Near Earth Objects</a>
 

  <script>
    function displayAPOD() {
      const apiKey = 'DhgElpnGhaqLjQi1gY9c0UVBCziH60r4NL5QBpXV'; // Replace with your NASA API key
      const apodUrl = `https://api.nasa.gov/planetary/apod?api_key=${apiKey}`;
      const insightWeatherUrl = `https://mars.nasa.gov/rss/api/?feed=weather&category=insight_temperature&feedtype=json&ver=1.0`;

      // Fetch APOD data
      fetch(apodUrl)
        .then(response => response.json())
        .then(data => {
          const apodContent = document.getElementById('apod-content');
          const title = `<h2>${data.title}</h2>`;
          const date = `<h4>Date: ${data.date}</h4>`;
          const explanation = `<p class="explanation">${data.explanation}</p>`;
          let media = '';

if (data.media_type === 'image') {
  media = `<img src="${data.url}" alt="NASA APOD" title=" ">`;
} else if (data.media_type === 'video') {
  const videoId = extractYouTubeVideoId(data.url);
  if (videoId) {
    // If it's a YouTube video, embed the video
    media = `<iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
  } else {
    media = 'Video not available.';
  }
} else {
  media = 'Media type not supported.';
}
          apodContent.innerHTML =  title + date + media +explanation;
          const table = `
      <table>
        <tr>
          <h2>${data.title}</h2>
          <h4>Date: ${data.date}</h4>
          <th>${media}</th>
          <th> ${explanation}
          <a href="https://apod.nasa.gov/apod/archivepix.html" class="button-2"><span> Discover More</span></a> </th>
        </tr>
        
      </table>
    `;

    // Set the table HTML content to the apodContent element
    apodContent.innerHTML = table;

        })
        .catch(error => {
          console.log('Error fetching APOD:', error);
          const apodContent = document.getElementById('apod-content');
          apodContent.innerHTML = '<p>Failed to fetch data from NASA APOD API</p>';
        });

      // Fetch Mars weather data
    fetch(insightWeatherUrl)
      .then(response => response.json())
      .then(data => {
      const marsWeather = document.getElementById('mars-weather');
          // Process and display Mars weather data here
          // Example: Display the first sol's (Martian day) weather data
          const solKeys = Object.keys(data);
          if (solKeys.length > 0) {
            const firstSolData = data[solKeys[0]];
            const solDate = `<p>Sol Date: ${firstSolData.First_UTC}</p>`;
            const season = `<p>Season: ${firstSolData.Season}</p>`;
            const temperature = `<p>Average Temperature (°C): ${firstSolData.AT.av}</p>`;
            const pressure = `<p>Average Pressure (Pa): ${firstSolData.PRE.av}</p>`;

            marsWeather.innerHTML = solDate + season + temperature + pressure;
          } else {
            marsWeather.innerHTML = '<p>No weather data available for Mars</p>';
          }
        })
        .catch(error => {
          console.log('Error fetching Mars weather:', error);
          const marsWeather = document.getElementById('mars-weather');
          marsWeather.innerHTML = '<p>Failed to fetch data from Mars Weather API</p>';
        // Add the "fade-in-overlay-visible" class to trigger the fade-in animation
      const weatherHeader = document.querySelector('.weather');
      weatherHeader.classList.add('fade-in-overlay-visible');

      // Wait for the animation to finish, then remove the "fade-in-overlay-visible" class
      setTimeout(() => {
        weatherHeader.classList.remove('fade-in-overlay-visible');
      }, 2000); // Adjust the timeout to match the animation duration
    })
    .catch(error => {
      console.log('Error fetching Mars weather:', error);
      const marsWeather = document.getElementById('mars-weather');
      marsWeather.innerHTML = '<p>Failed to fetch data from Mars Weather API</p>';
    });
}

    function extractYouTubeVideoId(url) {
  const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
  const match = url.match(regExp);
  return (match && match[2].length === 11) ? match[2] : null;
}
    displayAPOD();
  </script>

</body>
</html>