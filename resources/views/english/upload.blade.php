@extends('english.main')
@section('content')
@section('page', 'code')
@section('title', 'Code')

<body>
    <section class="w-100 m-auto code">
        <div class="container m-auto">
            @include('english.layouts.top')
            <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
                @csrf
            <div class="middle d-flex justify-content-center align-items-start">
                <div class="center">
                    <h2>Upload File</h2>

                        <div class="wa d-flex">
                            <input  id="exampleFormControlFile1" type="file" name="file" accept=".xls, .xlsx, .docx, .doc, .pdf, .jpeg, .jpg, .png" required>
                        </div>
                </div>
            </div>
            <div class="bottom d-flex justify-content-between align-items-center">
                <a href="{{ route('englishShare') }}" class="backbtn d-flex justify-content-center align-items-center">
                    <
                </a>
                    @if(isset($shop))
                        <input type="hidden" name="shop" value="{{ $shop }}">
                    @endif
                    <button type="submit" class="text-white d-flex justify-content-center align-items-center">
                        Continue >
                    </button>
                </form>
            </div>
        </div>
    </section>
</body>
@endsection
