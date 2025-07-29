document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM fully loaded and parsed');
  const form = document.getElementById('registrationForm');
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('fullname').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    
    console.log(`Name: ${name}, Email: ${email}, Phone: ${phone}`);
    fetch('http://localhost:8080/event_registration/index.php', { // change the path
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, email, phone})
    })
    .catch(err => console.error(err));
  });
});