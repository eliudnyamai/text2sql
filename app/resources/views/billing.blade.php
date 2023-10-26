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

                    <a href="{{ $paymentMethodUrl }}" class="btn btn-primary">
                        Update Payment Information
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<p>8888888888888888888888</p>
<script defer>
    function updatePM() {
        LemonSqueezy.Url.Open('{!! $paymentMethodUrl !!}');
    }
</script>

<button onclick="updatePM()">
    Update payment method
</button>
</x-guest-layout>

