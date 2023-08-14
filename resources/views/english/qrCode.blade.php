@extends('english.main')
@section('content')
@section('page', 'code')
@section('title', 'QRCODE')

<body>
    <section class="w-100 m-auto code">
        <div class="container m-auto">
            @include('english.layouts.top')
            @if(!isset($shop))
            <form method="POST" action="{{ route('englishQrCode') }}" enctype="multipart/form-data" style="
    width: 7em;
    margin: auto;
    margin-top: 3em;
">
                @csrf
                <select name="shop" style="font-size:18px;">
                    @foreach($shops as $shop)
                        <option value="{{ $shop->id }}">{{ $shop->address }}</option>
                    @endforeach
                </select>
                <button type="submit" style="
    font-size: 16px;
    margin-top: 3em;
    padding: 0.3em;
">Submit</button>
                </form>
                @elseif(isset($shop))
                {!! QrCode::size(300)->generate(url('/').'/uploadShop/'.$shop->id) !!}
                @endif;
            </div>
        </div>
    </section>
</body>
@endsection
