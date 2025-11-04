@extends('admin.patient-portal.layouts.app')

@section('title', 'Password Change')

@section('patient-portal-content')
    <main class="mb-5">
        <div class="container ">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Password Change</a></span>
            </div>
            <div class="row mt-4">
                <div class="col-12 mt-md-0 mt-2">
                        <div class="card col-lg-6 offset-lg-3">
                            <div class="card-header">
                                <div class="table-head"><i class="fas fa-table me-1"></i>Password Change</div>
                            </div>
                            <form action="{{ route('patientPortal.updatePassword') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    @if (isset($errorMessage))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errorMessage }}
                                        </div>
                                    @endif
                                    {{-- @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @elseif (isset('errorMessage'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errorMessage }}
                                        </div>
                                    @endif --}}
                                    <div class="mb-3">
                                            <label for="oldPasswordInput" class="form-label">Old Password</label>
                                            <input name="old_password" type="password" class="form-control 
                                                @error('old_password') is-invalid @enderror" id="oldPasswordInput" placeholder="Old Password">
                                            @error('old_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="newPasswordInput" class="form-label">New Password</label>
                                            <input name="new_password" type="password" class="form-control 
                                                @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                                placeholder="New Password">
                                            @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                                            <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput"
                                                placeholder="Confirm New Password">
                                        </div>
                                    </div>
                                <div class="card-footer">
                                    <button class="btn btn-success float-right my-2">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('admin-js')

@endpush
