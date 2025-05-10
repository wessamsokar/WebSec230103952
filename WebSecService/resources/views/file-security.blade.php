@extends('layouts.master') {{-- لو عندك layout أساسي --}}
@section('content')

    <div class="container mt-4">
        <div class="row">

            {{-- Encrypt Form --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Encrypt a File</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('encrypt.file') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Select file</label>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Enter password</label>
                                <input type="text" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Encrypt File</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Decrypt Form --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Decrypt a File</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('decrypt.file') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Select encrypted file</label>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Enter password</label>
                                <input type="text" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Decrypt File</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        {{-- Success Messages --}}
        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Messages --}}
        @if (session('error'))
            <div class="alert alert-danger mt-3">
                @if (str_contains(session('error'), 'does not exist'))
                    The encrypted file could not be found. Please ensure you're uploading the correct file and try again.
                @else
                    {{ session('error') }}
                @endif
            </div>
        @endif


@endsection
