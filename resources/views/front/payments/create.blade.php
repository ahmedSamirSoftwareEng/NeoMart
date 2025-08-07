<x-front-layout title="Order Payment">
    <x-slot:breadcrumb>
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Order Payment</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                            <li>Order Payment</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <div id="payment-message" style="display:none;" class="alert alert-info"></div>
                    <form action="" method="post" id="payment-form">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div id="payment-element"></div>
                        <div class="single-form form-default button mt-3">
                            <button type="submit" id="submit" class="btn">
                                <span id="button-text">Pay now</span>
                                <span id="spinner" style="display:none;">Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ config('services.stripe.publishable_key') }}");
        let elements;

        initialize();

        document
            .querySelector("#payment-form")
            .addEventListener("submit", handleSubmit);

        async function initialize() {
            const clientSecret = await fetch("{{ route('stripe.paymentIntent.create', $order->id) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                })
                .then((res) => res.json())
                .then((data) => {
                    console.log("Client secret:", data.clientSecret);
                    return data.clientSecret;
                });

            const appearance = {
                theme: 'stripe',
            };

            elements = stripe.elements({
                appearance,
                clientSecret
            });

            const paymentElement = elements.create("payment");
            paymentElement.mount("#payment-element");
        }

        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            const {
                error
            } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: "{{ route('stripe.return', $order->id) }}",
                },
            });

            if (error) {
                showMessage(error.message);
                setLoading(false);
            }
        }

        function showMessage(messageText) {
            const messageContainer = document.querySelector("#payment-message");
            messageContainer.style.display = "block";
            messageContainer.textContent = messageText;

            setTimeout(() => {
                messageContainer.style.display = "none";
                messageContainer.textContent = "";
            }, 4000);
        }

        function setLoading(isLoading) {
            const button = document.querySelector("#submit");
            const spinner = document.querySelector("#spinner");
            const buttonText = document.querySelector("#button-text");

            if (isLoading) {
                button.disabled = true;
                spinner.style.display = "inline";
                buttonText.style.display = "none";
            } else {
                button.disabled = false;
                spinner.style.display = "none";
                buttonText.style.display = "inline";
            }
        }
    </script>
</x-front-layout>   