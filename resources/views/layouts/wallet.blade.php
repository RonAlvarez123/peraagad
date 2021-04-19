{{-- <section class="wallet">
    <div>
        <div class="walletContainer">
            <h5>YOUR CURRENT WALLET</h5>
            <div class="custom-input-container">
                <div class="custom-input-label">PHP</div>
                <div class="custom-input">{{ $account->money }}</div>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    CASH OUT
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">MONEY REMITTANCE</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">GCASH</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="cashout.html">BANK TRANSFER</a></li>
                </ul>
            </div>

            <h6>LOCAL DATE: <br>
                {{ today()->toDateString() }}</h6>
            <h5>YOUR POOL MEMBERS</h5>
            <div class="custom-input-container">
                <div class="custom-input-label">DIRECT</div>
                <div class="custom-input">{{ $account->direct }}</div>
            </div>
            <div class="custom-input-container">
                <div class="custom-input-label">INDIRECT</div>
                <div class="custom-input">{{ $account->indirect }}</div>
            </div>
        </div>
        <div class="walletContainer py-2">
            <h4 class="text-danger">ANNOUNCEMENT!!!</h4>
            <p>Join our Facebook Group <br>
                <span>PERA AGAD OFFICIAL MEMBERS GROUP</span> <br>
                to be updated on our latest promos <br>
                and exciting news!
            </p>
        </div>
    </div>
</section> --}}

<section class="wallet">
    <form action="{{ route('cashout.index') }}" method="GET" class="walletContainer">
        @csrf
        <h6 class="text-center mb-4">Wallet Details</h6>
        <div class="mb-3 balance text-center">
            <h6>{{ $account->money }} <span>PHP</span></h6>
            <label>My balance</label>
        </div>
        <div class="mb-3">
            <label class="form-label">Method</label>
            <select class="form-select" name="method" required>
                <option value="gcash">Gcash</option>
                <option value="bank transfer">Bank Transfer</option>
                <option value="money remittance">Money Remittance</option>
            </select>
            <p class="instructions">
                Choose the corresponding cashout method that you like.
            </p>
        </div>
        <button type="submit" class="button-submit mt-3">CASHOUT NOW</button>
    </form>

    <div class="invites">
        <div class="badge-container">
            <span class="badge bg-secondary">{{ today()->toDateString() }}</span>
        </div>
        <h6 class="text-center mb-4">Referrals</h6>
        <div class="tableContainer">
            <div class="row dataContainer">
                <div>Direct</div>
                <div>{{ $account->direct }}</div>
            </div>
            <div class="row dataContainer">
                <div>Indirect</div>
                <div>{{ $account->indirect }}</div>
            </div>
        </div>
    </div>
</section>