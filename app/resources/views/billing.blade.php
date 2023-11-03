<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Billing Information</div>

                <div class="card-body">
                    <p>
                        To update your payment information, click the button below:
                    </p>

                    <x-lemon-button :href="$checkout" class="px-8 py-4">
    Buy Product
</x-lemon-button>
                </div>
            </div>
        </div>
    </div>
</div>
<p>8888888888888888888888</p>


<button onclick="updatePM()">
    Update payment method
</button>
</x-guest-layout>

