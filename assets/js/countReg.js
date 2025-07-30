document.addEventListener('DOMContentLoaded', function() {
  fetch('stats.php')
  .then(response => response.json())  
  .then(data => {
    document.getElementById('regCount').textContent = data.registrations;
    document.getElementById('viewCount').textContent = data.page_views;
  })
  .catch(error => console.error('Error fetching stats:', error));

});
