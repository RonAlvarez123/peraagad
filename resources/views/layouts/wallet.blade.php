<section class="wallet">
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
            <!-- ------------------ -->
            <h6>LOCAL DATE: <br>
                {{ \Carbon\Carbon::today()->toDateString() }}</h6>
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
        <div class="walletContainer">
            <h4 class="text-danger">ANNOUNCEMENT!!!</h4>
            <p>Join our Facebook Group <br>
                <span>PERA AGAD OFFICIAL MEMBERS GROUP</span> <br>
                to be updated on our latest promos <br>
                and exciting news!
            </p>
        </div>
    </div>
</section>