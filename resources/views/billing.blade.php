<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Billing Information</div>

                <script defer>
    function updatePM() {
        LemonSqueezy.Url.Open('{!! $paymentMethodUrl !!}');
    }
</script>

<button onclick="updatePM()">
    Update payment method
</button>
            </div>
        </div>
    </div>
</div>

</x-guest-layout>

