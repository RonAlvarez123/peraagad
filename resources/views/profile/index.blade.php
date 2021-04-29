@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/profile/index.css') }}">
    <script defer src="{{ asset('js/receipt/fileUpload.js') }}"></script>
@endsection

@section('title')
    <title>Profile</title>
@endsection

@section('contentContainer')
    @if ($account->isBonusClaimable())
        <form action="{{ route('profile.bonus') }}" method="POST" class="alert alert-info d-flex align-items-center justify-content-between mb-3" role="alert">
            @csrf
            <p class="m-0 fw-bold">You have a daily bonus!</p>
            <button type="submit" class="btn btn-success">Claim Bonus</button>
        </form>
    @endif

    @error('main_error')
        <h6 class="alert alert-danger text-danger text-center mb-3">{{ $message }}</h6>
    @enderror

    @if (session('status'))
        <h6 class="alert alert-info text-secondary text-center mb-3">{{ session('status') }}</h6>
    @endif

    <div class="contentContainer">
        <section class="user-profile">
            @if ($user->profile_pic == null)
                <form action="{{ route('profile.picture') }}" method="POST" class="file-upload-container" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="file" name="file">
                    <div class="file-upload">
                        <p class="{{ $errors->has('file') ? 'border-danger text-danger' : '' }}">NO FILE SELECTED</p>
                        <button type="button">CHOOSE FILE</button>
                    </div>
                    @error('file')
                        <p class="text-danger error-message">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="button-submit my-3">SET PROFILE PICTURE</button>
                </form>
            @else
                <div>
                    <img src="{{ asset('storage/profile/'. $user->profile_pic) }}" alt="User Profile Picture">
                </div>
            @endif
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
                            <div class="mb-3">
                                <label>You joined</label>
                                <h6>{{ $user->joinedAt() }}</h6>
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

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Security
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @if ($user->canChangePassword())
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="mb-3 col-12 col-md-8 mx-auto">
                                        <label class="text-secondary">Old Password</label>
                                        <input type="password" class="form-control {{ $errors->has('old_password') ? 'border-danger' : '' }}" required name="old_password">
                                        @error('old_password')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-12 col-md-8 mx-auto">
                                        <label class="text-secondary">New Password</label>
                                        <input type="password" class="form-control {{ $errors->has('new_password') ? 'border-danger' : '' }}" required name="new_password">
                                        @error('new_password')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="mb-4 col-12 col-md-8 mx-auto">
                                        <label class="text-secondary">Confirm New Password</label>
                                        <input type="password" class="form-control" required name="new_password_confirmation">
                                    </div>
                                    <div class="col-12 col-md-8 mx-auto mt-4 mb-3">
                                        <button class="button-submit" type="submit">CHANGE PASSWORD</button>
                                    </div>
                                </form>
                            @else
                                <h6>You have changed your password {{ $user->passwordChangedAt() }}. You can change your password again after 15 days from the day that you changed it.</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection