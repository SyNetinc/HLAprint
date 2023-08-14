@extends('english.main')
@section('content')
@section('page', 'processing')
@section('title', 'Processing')
<body>
    <section class="w-100 m-auto processing">
        <div class="container  m-auto"> 
            @include('english.layouts.top')

            <div class="main d-flex justify-content-center align-items-center">
                <div class="left">
                    <p>Please Wait</p>
                    <h2>Processing payment</h2>
                </div>
                <img src="{{ asset('public/assets/english') }}/img/process.png" alt="" class="process">
            </div>
        <a href="{{ route('englishPay') }}" class="back text-decoration-none d-flex justify-content-center align-items-center "><</a>
       
       </div>

    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


</body>

</html>