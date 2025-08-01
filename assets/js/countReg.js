document.addEventListener('DOMContentLoaded', function() {
  fetch('http://localhost:8080/event_registration/start.php')
  .then(response => response.json())  
  .then(data => {
    console.log('Data fetched:', data);
    document.getElementById('regCount').textContent = data.registrations;
    document.getElementById('viewCount').textContent = data.page_views;
  })
  .catch(error => {
    console.error('Error fetching stats:', error);
    // Also inspect raw response for debugging
    fetch('http://localhost:8080/event_registration/start.php')
      .then(response => response.text())
      .then(text => console.log('Raw response:', text));
  });
});
