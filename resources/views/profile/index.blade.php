@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/profile/index.css') }}">
@endsection

@section('title')
    <title>Profile</title>
@endsection

@section('contentContainer')
    {{-- @if ($account->isBonusClaimable())
        <form action="{{ route('profile.bonus') }}" method="POST" class="alert alert-secondary d-flex align-items-center justify-content-between" role="alert">
            @csrf
            <h6 class="m-0 text-secondary">You have a daily bonus!</h6>
            <button type="submit" class="btn btn-success fw-bold">Claim Bonus</button>
        </form>
    @endif
    @if (session('status'))
        <h6 class="alert alert-info text-secondary text-center mb-3">{{ session('status') }}</h6>
    @endif
    <div class="contentContainer">
        <div class="mainHeader">
            <h4 class="text-center my-3">Personal Info</h4>
        </div>
        <div class="subHeader">
            <h5>Profile</h5>
            <div class="text-danger">Please provide the correct and updated informations below</div>
        </div>
        <div class="details-grid name">
            <div class="firstname">FIRST NAME</div>
            <div class="middlename">MIDDLE NAME</div>
            <div class="lastname">LAST NAME</div>
            <h6>NAME</h6>
            <p class="first">{{ $user->firstname }}</p>
            <p class="middle">{{ $user->middlename }}</p>
            <p class="last">{{ $user->lastname }}</p>
        </div>
        <div class="details-grid address">
            <div class="city">CITY/MUNICIPALITY</div>
            <div class="province">PROVINCE</div>
            <h6>ADDRESS</h6>
            <p class="c">{{ $user->city }}</p>
            <p class="p">{{ $user->province }}</p>
        </div>
        <div class="details">
            <h6>PHONE</h6>
            <p>{{ $user->phone_number }}</p>
        </div>
        <div class="details">
            <h6>EMAIL</h6>
            <p>N/A</p>
        </div>
        <div class="details">
            <h6>ACCOUNT TYPE</h6>
            <p>{{ $account->level }}</p>
        </div>
        <div class="details">
            <h6>ACCOUNT CODE</h6>
            <p>{{ $user->account_code }}</p>
        </div>
    </div> --}}

    @if ($account->isBonusClaimable())
        <form action="{{ route('profile.bonus') }}" method="POST" class="alert alert-info d-flex align-items-center justify-content-between mb-3" role="alert">
            @csrf
            <p class="m-0 fw-bold">You have a daily bonus!</p>
            <button type="submit" class="btn btn-success">Claim Bonus</button>
        </form>
    @endif

    @if (session('status'))
        <h6 class="alert alert-info text-secondary text-center mb-3">{{ session('status') }}</h6>
    @endif

    <div class="contentContainer">
        <section class="user-profile">
            {{-- <div>
                <img src="R.jpg" alt="">
            </div> --}}
            <h4>{{ $user->firstname . ' ' . $user->lastname }}</h4>
        </section>

        <section class="user-details">
            <div class="accordion accordion-flush" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Personal Information
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <label>Firstname</label>
                                <h6>{{ $user->firstname }}</h6>
                            </div>
                            <div class="mb-3">
                                <label>Middlename</label>
                                <h6>{{ $user->middlename }}</h6>
                            </div>
                            <div class="mb-3">
                                <label>Lastname</label>
                                <h6>{{ $user->lastname }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Account Information
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <label>Account Code</label>
                                <h6>{{ $user->account_code }}</h6>
                            </div>
                            <div class="mb-3">
                                <label>Account Type</label>
                                <h6>{{ $account->level }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Contact Details
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <label>Phone Number</label>
                                <h6>{{ $user->phone_number }}</h6>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <h6>N/A</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Address
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <label>City</label>
                                <h6>{{ $user->city }}</h6>
                            </div>
                            <div class="mb-3">
                                <label>Province</label>
                                <h6>{{ $user->province }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection