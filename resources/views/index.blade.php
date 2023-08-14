<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('public/assets/') }}/index.css">
    <style>
        @media screen and (max-width: 1919px) {
            body {
                zoom: 0.8;

            }

            html,
            body {
                height: 100%;
                margin: 0;
            }

            body {
                background-image: url('your-background-image.jpg');
                background-size: cover;
                background-position: center;
            }

        }
    </style>
</head>

<body>
    <section class="w-100 m-auto">

        <div class="container m-auto">

            <div class="header row justify-content-between">
                <p class="col-xl-4 col-lg-4 col-md-12 col-sm-6">Welcome to <br>
                    Our Printing Shop</p>
                <div class="imgdiv col-xl-4 col-lg-4 col-md-6 col-sm-6">

                    <img src="{{ asset('public/assets/english') }}/img/logo.png" alt="" class="logo ms-5 ">
                </div>
                <div
                    class="contact contactPc d-flex justify-content-end align-items-right text-right col-xl-4  col-lg-4 col-md-6 col-sm-6">
                    <p class="text-end"> Customer Support <br>
                        123 456 789</p>
                    <img src="{{ asset('public/assets/english') }}/img/contact.png" alt="">
                </div>
                <div class="Contact dropdown">
                    <img src="{{ asset('public/assets/english') }}/img/contact.png" alt=""
                        class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <ul class="dropdown-menu">
                        <p class="text-end"> Customer Support <br>
                            123 456 789</p>
                    </ul>
                </div>
            </div>
            <div class="middle d-flex justify-content-center align-items-start">
                <div class="left text-center">

                    <p class="mainText">Choose Your </p>
                    <h2 class="font-weight-semibold "> Language Experience</h2>
                    <div class="d-flex justify-content-center mt-4 mb-4">
                        <h2 class="font-weight-semibold " style="margin-bottom: 0; margin-top: 0;">الخبرة اللغوية</h2>
                        <p class="mainText "> اختر خاصتك</p>
                    </div>
                    <div class="LanguageBtn d-flex justify-content-center align-items-center flex-column flex-md-row">
                        <a href="{{ route('arabicShare') }}" class="mb-2 mb-md-0 mr-md-2"><img
                                src="{{ asset('public/assets/english') }}/img/arab.png" alt=""
                                class="img-fluid"> العربية </a>
                        <a href="{{ route('englishShare') }}"><img src="{{ asset('public/assets/english') }}/img/us.png"
                                alt="" class="img-fluid">English ></a>
                    </div>

                    {{-- <div class="LanguageBtn d-flex justify-content-center align-items-center">
                    <a href="{{route('arabicShare')}}"><img src="{{ asset('public/assets/english') }}/img/arab.png" alt="">< العربية </a>
                    <a href="{{route('englishShare')}}"><img src="{{ asset('public/assets/english') }}/img/us.png" alt="">English ></a>
           </div> --}}
                </div>

            </div>
        </div>

    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>
