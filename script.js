console.log("script.js loaded!");
const form = document.getElementById('registerForm');
form.addEventListener('submit', function(e) {
  e.preventDefault();
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const phone = document.getElementById('phone').value;
  const password = document.getElementById('password').value;

  fetch('http://localhost:8080/event_registration/register.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ name, email, phone, password})
  })
  .then(res => res.json())
  .then(data => {
    console.log(data);
    alert(data.message);
  })
  .catch(err => console.error(err));
});