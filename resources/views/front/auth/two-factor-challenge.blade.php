<x-front-layout title="2FA Challenge">
    <x-slot:breadcrumb>
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Two Factor Authentication Challenge</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                            <li>Two Factor Authentication Challenge</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->
    </x-slot:breadcrumb>


    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{ route('two-factor.login') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>2FA Challenge</h3>
                                <p>You must enter 2FA code.</p>
                            </div>
                            @if ($errors->has('code'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('code') }}
                                </div>
                            @endif
                            <div class="form-group input-group">
                                <label for="reg-fn">2FA Code</label>
                                <input class="form-control" type="text" name="code" id="reg-email">
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">Recovery Code</label>
                                <input class="form-control" type="text" name="recovery_code" id="reg-recovery_code" >
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->
</x-front-layout>
