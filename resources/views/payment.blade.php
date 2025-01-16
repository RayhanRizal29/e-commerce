<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Midtrans Payment</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>
<body>
    <form id="payment-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required>
        <button type="button" id="pay-button">Pay Now</button>
    </form>

    <script>
        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const amount = document.getElementById('amount').value;

            fetch('/payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ name, email, amount }),
            })
            .then(response => response.json())
            .then(data => {
                snap.pay(data.snap_token);
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
