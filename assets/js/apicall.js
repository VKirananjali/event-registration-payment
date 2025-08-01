document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');
    const form = document.getElementById('registrationForm');
    const paymentButton = document.getElementById('paymentButton');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('fullname').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;

        // Add client-side validation
        if (!name || !email || !phone) {
            alert('Please fill in all required fields.');
            return;
        }

        console.log(`Name: ${name}, Email: ${email}, Phone: ${phone}`);

        paymentButton.disabled = true;
        paymentButton.textContent = 'Processing...';

        fetch('http://localhost:8080/event_registration/index.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, email, phone })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP error, status = ' + response.status);
            }
            return response.json(); // Parse the JSON response
        })
        .then(data => {
            console.log('Order data received:', data);
            
            // Define the options object using the data from the server
            var options = {
                "key": data.key,
                "amount": data.amount,
                "currency": data.currency,
                "name": data.name,
                "description": data.description,
                "image": data.image,
                "order_id": data.order_id,
                "prefill": data.prefill,
                "theme": data.theme,
                "callback_url": data.callback_url 
            };
            
            // Open the Razorpay payment modal
            var rzp = new Razorpay(options);
            rzp.open();

            // Re-enable the button if the user closes the popup
            rzp.on('payment.dismissed', function (resp) {
                paymentButton.disabled = false;
                paymentButton.textContent = '🚀 Proceed to Payment';
            });
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Payment processing failed. Please try again.');
            paymentButton.disabled = false;
            paymentButton.textContent = '🚀 Proceed to Payment';
        });
    });

    // You need to include the Razorpay Checkout.js script here in your HTML
    const script = document.createElement('script');
    script.src = 'https://checkout.razorpay.com/v1/checkout.js';
    document.body.appendChild(script);
});