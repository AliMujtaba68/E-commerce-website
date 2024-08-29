document.addEventListener('DOMContentLoaded', () => {
    const stripe = Stripe(`{{ env('STRIPE_PUBLIC') }}`);

    const checkoutButton = document.getElementById('checkout-button');

    checkoutButton.addEventListener('click', async () => {
        const response = await fetch(`{{ route('createCheckoutSession') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        });

        if (!response.ok) {
            const error = await response.json();
            console.error('Error:', error);
            return;
        }

        const sessionId = await response.json();

        const { error } = await stripe.redirectToCheckout({ sessionId: sessionId.id });

        if (error) {
            console.error('Error:', error);
        }
    });
});
