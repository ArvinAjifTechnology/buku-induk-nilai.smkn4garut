@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile"
                                    role="tab" aria-controls="profile" aria-selected="true">Profil</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab"
                                    aria-controls="password" aria-selected="false">Perbarui Kata Sandi</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content mt-3">
                            <!-- Profil Tab (Content) -->
                            <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <!-- Add Profile Form or Content Here -->
                                <p>{{ auth()->user()->email }}</p>
                                <p>{{ auth()->user()->name }}</p>
                            </div>

                            <!-- Update Password Tab (Content) -->
                            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                                <!-- Update Password Form -->
                                <form method="POST" action="{{ route('profile.index') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="current_password"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Kata Sandi Saat Ini') }}</label>

                                        <div class="col-md-6">
                                            <input id="current_password" type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                name="current_password" required>

                                            @error('current_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <label for="new_password"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Kata Sandi Baru') }}</label>

                                        <div class="col-md-6">
                                            <input id="new_password" type="password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                name="new_password" required>

                                            @error('new_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <label for="new_password_confirmation"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Konfirmasi Kata Sandi Baru') }}</label>

                                        <div class="col-md-6">
                                            <input id="new_password_confirmation" type="password" class="form-control"
                                                name="new_password_confirmation" required>
                                        </div>
                                    </div>

                                    <div class="form-group row mt-4 mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Perbarui Kata Sandi') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
