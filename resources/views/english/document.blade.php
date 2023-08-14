@extends('english.main')
@section('content')
@section('page', 'document')
@section('title', 'Document')

<body>
    <section class="w-100 m-auto document afterCode">
        <div class="container  m-auto">
            @include('english.layouts.top')
            <div class="main d-flex justify-content-between align-items-start">
                <div class="documents">
                    <div class="top">
                        <p class="mainText">Please Review Your File</p>
                        <!-- <p class="doc d-flex justify-content-start align-items-start"><img src="./img/pdficon.png" -->
                        <!-- alt=""> Document Name</p> -->
                    </div>
                    {{--   <div class="documentFiles overflow-scroll">
                        <embed src="" height="243" width="547" type="application/pdf" style="margin-bottom: 20px;">
                        </div> --}}
                    <div style="width: 37.9rem; height: 60.5rem;
                    background: #80808059; margin-bottom: 2.9rem;"
                        class="d-flex justify-content-center align-items-center">
                        <div class="documentFiles overflow-hidden d-flex justify-content-center align-items-center">
                            <canvas style="width: 83%; max-width : 100%; position: relative; cursor: grabbing;"></canvas>
                        </div>
                    </div>
                    <div class="pagination d-flex justify-content-start align-items-center">
                        <img src="{{ asset('public/assets/english') }}/img/Larrow.png" alt=""
                            onclick="Pagination(false)">
                        <button class="currentPage">1</button>
                        <p>Of</p>
                        <p class="number">3</p>
                        <img src="{{ asset('public/assets/english') }}/img/Larrow.png" alt=""
                            style="transform: rotate(180deg);" onclick="Pagination(true)">
                    </div>
                </div>
                <form method="post" action="{{ route('eSubmitDocument') }}">@csrf
                    <input type="hidden" name="file"
                        value="@if (isset($file)) @php echo $file; @endphp @endif">
                    <input type="hidden" name="phone"
                        value="@if (isset($phone)) @php echo $phone; @endphp @endif">
                    <div>
                        <div class="settings position-relative " style="display: block !important;">
                            <div
                                class="TopHeading d-flex top-0 left-0 justify-content-end align-items-center position-absolute">
                                Subtotal
                            </div>
                            <div class="d-flex options">
                                <p><img src="{{ asset('public/assets/english') }}/img/color.png" style="width: 3.8rem;"
                                        alt=""> Color:</p>

                                <div class="d-flex fle-column">
                                    <div class="d-flex input">
                                        <input name="color" value="false" id="blackwhite"  @if(isset($print_job)) checked="{{!$print_job->color}}" @else checked="true" @endif
                                            type="radio" onchange="(uncheck('color'))">
                                        <p>Grayscale</p>
                                    </div>
                                    <div class="d-flex input">
                                        <input name="color" value="true" type="radio" id="color" @if(isset($print_job)) checked="{{$print_job->color}}" @endif
                                            onchange="(uncheck('blackwhite'))">
                                        <p style="margin-right: 0;">Color</p>
                                    </div>
                                </div>
                                <p class="amount"> <span id="subtotal"> 1 </span> SAR</p>
                            </div>

                            <div class="d-flex options">
                                <p><img src="{{ asset('public/assets/english') }}/img/sides.png" style="width: 3.2rem;"
                                        alt=""> Sides:</p>
                                <div class="d-flex fle-column">
                                    <div class="d-flex input">
                                        <input name="sides" value="one" type="radio" @if(isset($print_job)) checked="{{!$print_job->double_sided}}" @else checked="true" @endif
                                            id="oneside" onchange="(uncheck('twoside'))">
                                        <p>One Sided</p>
                                    </div>
                                    <div class="d-flex input">
                                        <input name="sides" value="two" type="radio" id="twoside"
                                            onchange="(uncheck('oneside'))" @if(isset($print_job)) checked="{{$print_job->double_sided}}" @endif>
                                        <p style="margin-right: 0;">Two Sided</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex options">
                                <p><img src="{{ asset('public/assets/english') }}/img/range.png" style="width: 3.3rem;"
                                        alt=""> Range:</p>
                                <div class="d-flex fle-column">
                                    <div class="d-flex input">
                                        <input name="range" value="all" type="radio" checked="true"
                                            id="all" onchange="(uncheck('custom', 'all'))">
                                        <p>All Pages</p>
                                    </div>
                                    <div class="d-flex input">
                                        <input name="range" value="custom" type="radio" id="custom"
                                            onchange="(uncheck('all', 'custom'))">
                                        <p style="margin-right: 0;">Custom</p>
                                    </div>
                                </div>
                                <p class="amount"> <span id="subtotal-all" class="subtotalPages"> 1 </span> SAR</p>
                            </div>
                            <div class="Pages " id="CopiesNumber">
                                <div class="d-flex fle-column">

                                    <div class="d-flex justify-content-center align-items-center">

                                        <p style="margin-right: 2rem; margin-left: 0; font-weight: 400;">From</p>
                                        <div class="position-relative d-flex align-items-center">

                                            <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 25px; font-weight: 500; "
                                                onclick="IncreaseCount('from', false)">-</p>
                                            <input disabled type="text" class="number text-center" id="from"
                                                value="1">

                                            <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 25px; font-weight: 500; transform: rotate(180deg);"
                                                onclick="IncreaseCount('from', true)">+</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p style="margin-right: 2rem; margin-left: 5.5rem; font-weight: 400;">To</p>
                                        <div class="position-relative d-flex align-items-center">
                                            <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 25px; font-weight: 500; transform: rotate(180deg);"
                                                onclick="IncreaseCount('to', false)">-</p>
                                            <input disabled type="text" class="number text-center" id="to"
                                                value="2">

                                            <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 25px; font-weight: 500; transform: rotate(180deg);"
                                                onclick="IncreaseCount('to', true)">+</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="d-flex Pages">
                                <div class="d-flex justify-content-center align-items-center">
                                    <p style="margin-right: 8.1rem; margin-left: 0"><img style="width: 2.8rem;"
                                            src="{{ asset('public/assets/english') }}/img/copies.png" alt="">
                                        Copies:</p>
                                    <div class="position-relative d-flex align-items-center">
                                        <p class="minus-button"  style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 25px; font-weight: 500; transform: rotate(180deg);"
                                            onclick="IncreaseCount('copies', false)">-</p>
                                        <input name="copies" type="text" class="number text-center"
                                            id="copies" value="1">
                                        <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 25px; font-weight: 500; transform: rotate(180deg);"
                                        class="plus-button"
                                        onclick="IncreaseCount('copies', true)">+</p>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="amount d-flex justify-content-end align-items-center">
                            <h2>Total:<span id="total">1.00</span> SAR</h2>
                            <div class="d-flex">
                                <a href="{{ route('englishCode') }}"
                                    class="d-flex justify-content-center align-items-center back">
                                    < </a>
                                        {{--  <a href="{{ route('englishPay') }}"
                                        class="d-flex justify-content-center align-items-center pay">Confirm Pay</a>
                         --}}
                                        <input class="d-flex justify-content-center align-items-center pay"
                                            type="submit" value="Confirm Pay">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <script>
        var Numpages = 1
        var TotalPrice = 1.00
        // Define variables for PDF loading and rendering
        let pdfDoc = null;
        let pageNum = 1;
        let pageRendering = false;
        let pageNumPending = null;
        let scale = 1.5;
        const canvas = document.querySelector("canvas");
        const documentFiles = document.querySelector(".documentFiles");
        const context = canvas.getContext("2d");
        // Function to load and render the PDF
        const renderPage = (num) => {
            pageRendering = true;
            pdfDoc.getPage(num).then((page) => {
                const viewport = page.getViewport({
                    scale
                });
                canvas.width = viewport.width;
                if(Numpages % 2 == 0){

                    paginationP.innerHTML = Numpages
                }else{
                    paginationP.innerHTML = "-1"
                }
document.querySelector("#to").value = Numpages

                console.log(Numpages)
                canvas.height = viewport.height ;
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport,
                };
                page.render(renderContext).promise.then(() => {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update current page number
            document.querySelector(".currentPage").textContent = num;
        };

        // Function to queue rendering of the next page
        const queueRenderPage = (num) => {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        };

        // Function to navigate to the previous page
        const goPreviousPage = () => {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        };

        // Function to navigate to the next page
        const goNextPage = () => {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        };

        // Function to zoom in
        const zoomIn = () => {
            scale *= 1.2;
            queueRenderPage(pageNum);
        };

        // Function to zoom out
        const zoomOut = () => {
            scale /= 1.2;
            queueRenderPage(pageNum);
        };

        // Function to load and render the PDF
        const loadPDF = async (url) => {
            try {
                const loadingTask = pdfjsLib.getDocument(url);
                pdfDoc = await loadingTask.promise;
                
                Numpages = pdfDoc._pdfInfo.numPages
                renderPage(pageNum);
            } catch (error) {
                console.error("Error loading PDF:", error);
            }
        };

        // Load and render the PDF on page load
        document.addEventListener("DOMContentLoaded", () => {
            const pdfUrl =
                "@if (isset($file)){{ $file }}@endif";
            loadPDF(pdfUrl);
        });
    </script>

    <script>
        function onDrag({movementX, movementY}){
      let getStyle = window.getComputedStyle(canvas);
      let leftVal = parseInt(getStyle.left);
      let topVal = parseInt(getStyle.top);
      canvas.style.left = `${leftVal + movementX}px`;
      canvas.style.top = `${topVal + movementY}px`;
    }
    documentFiles.addEventListener("mousedown", ()=>{
        documentFiles.addEventListener("mousemove", onDrag);
    });
    document.addEventListener("mouseup", ()=>{
        documentFiles.removeEventListener("mousemove", onDrag);
    });
        let scalecanvas = 1

documentFiles.addEventListener("wheel", (event)=>{
    event.preventDefault()
    if (event.deltaY < 0.4){
        
     scalecanvas += .05
     canvas.style.transform = `scale(${scalecanvas})`
    }else if (event.deltaY > 0){
        if(scalecanvas <=0){
            return
        }
     scalecanvas -= .05
     canvas.style.transform = `scale(${scalecanvas})`
 }
})

        let custom = false
        document.getElementById("CopiesNumber").style.opacity = "0.5"
        const uncheck = (id, e) => {
            document.getElementById(id).checked = false
            if (e == "custom") {
                document.getElementById("CopiesNumber").style.opacity = "1"
                document.getElementById("from").setAttribute('name','from');
                document.getElementById("to").setAttribute('name','to');
                custom = true
            } else if (e == "all") {
                document.getElementById("CopiesNumber").style.opacity = "0.5";
                document.getElementById("from").removeAttribute('name');
                document.getElementById("to").removeAttribute('name');
                custom = false
            }
        }
    </script>


    <script>
        let subtotalPages = document.querySelector(".subtotalPages")
        var subtotalPagesPrice = 1
        let from = document.getElementById("from").value
        let to = document.getElementById("from").value
        let copies = document.getElementById("from").value


        const IncreaseCount = (id, value) => {


            if (id == "from") {
                if (custom) {
                    if (value) {
                        if(document.getElementById(id).value >= Numpages ){
                            return
                        }
                        document.getElementById(id).value++
                        subtotalPagesCount(document.getElementById(id).value, document.getElementById("to").value)

                    } else {
                        if (document.getElementById(id).value <= 1) {
                            return
                        } else {
                            document.getElementById(id).value--
                        subtotalPagesCount(document.getElementById(id).value, document.getElementById("to").value)

                        }

                    }
                }
            } else if (id == "to") {
                if (custom) {

                    if (value) {
                        if(document.getElementById(id).value >= Numpages){
                            return
                        }
                        document.getElementById(id).value++
                        subtotalPagesCount(document.getElementById("from").value, document.getElementById(id).value)


                    } else {
                        if (document.getElementById(id).value <= 1) {
                        return
                        } else {
                            document.getElementById(id).value--
                        subtotalPagesCount(document.getElementById("from").value, document.getElementById(id).value)


                        }
                    }
                }
            }
            if (id == "copies") {

                if (value) {
                    //document.getElementById(id).value++

                } else {
                    if (document.getElementById(id).value <= 0) {
                        document.getElementById(id).value = 0
                    } else {
                       // document.getElementById(id).value--
                    }

                }
            }


        }

       
        const currentPage = document.querySelectorAll(".currentPage")
        const paginationBtn = document.querySelector(".pagination button")
        const paginationP = document.querySelector(".pagination .number")
        const PDFs =
            "@if (isset($file)) {{ $file }} @endif"
        console.log(PDFs)


        let InitalPage = 1
        const PDFJS = () => {
            pdfjsLib.getDocument(`${PDFs}`).promise.then(doc => {

                doc.getPage(InitalPage).then(page => {

                    const canvas = document.querySelector("canvas")
                    const context = canvas.getContext("2d")
                    // console.log(page.getViewport({scale:1}))
                    var viewport = page.getViewport({
                        scale: 1
                    })
                    // console.log(viewport)
                    canvas.width = viewport.width
                    canvas.height = viewport.height
                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    })
                })
            })

        }

        // PDFJS()

        const Pagination = (value) => {
            if (value) {
                // console.log(typeof( ))
                if (InitalPage >= parseInt(paginationP.innerHTML)) {
                    return
                } else {
                    InitalPage++
                    PDFJS()
                    paginationBtn.innerHTML = InitalPage
                }
            } else {
                if (InitalPage <= 1) {
                    return
                } else {
                    InitalPage--
                    PDFJS()
                    paginationBtn.innerHTML = InitalPage
                }
            }

        }
    </script>
    <script>
        // Assuming you have HTML elements for color options and total price
        const grayscaleRadio = document.getElementById('blackwhite');
        const colorRadio = document.getElementById('color');
        const totalPrice = document.getElementById('total');
        const subTotal = document.getElementById('subtotal');
        const subTotalAll = document.getElementById('subtotal-all');
        const copiesInput = document.getElementById('copies');
        const minus_button = document.querySelector('.minus-button');
        const plus_button = document.querySelector('.plus-button');



        let PagesCount = 0;
        const subtotalPagesCount = (from, to)=>{
        PagesCount = to - from + 1
        updateTotalPrice()
        }

        // Event listeners for color options
        grayscaleRadio.addEventListener('change', updateTotalPrice);
        colorRadio.addEventListener('change', updateTotalPrice);
        copiesInput.addEventListener('input', updateTotalPrice);
        minus_button.addEventListener('click', decreaseCopies);
        plus_button.addEventListener('click', increaseCopies);

        function decreaseCopies() {
        let numCopies = parseInt(copiesInput.value) || 0;
        numCopies = numCopies > 1 ? numCopies - 1 : 1;
        copiesInput.value = numCopies;
        updateTotalPrice();
        }

        // Function to increase the number of copies
        function increaseCopies() {
        let numCopies = parseInt(copiesInput.value) || 0;
        numCopies++;
        copiesInput.value = numCopies;
        updateTotalPrice();
        }


        function updateTotalPrice() {
            const numCopies = parseInt(copiesInput.value) || 0;

            // Get the selected color option value
            let price = 0;
            if (colorRadio.checked) {
                price = 2 * pdfDoc.numPages;
                subTotal.textContent = 2;
                subTotalAll.textContent = 2 * pdfDoc.numPages;

                subtotalPagesPrice = PagesCount * 2 
                subtotalPages.textContent = subtotalPagesPrice
            } else if (grayscaleRadio.checked) {
                price = 0.3333 * pdfDoc.numPages;
                subTotal.textContent = 1;
                subTotalAll.textContent = Math.ceil(0.3333 * pdfDoc.numPages);

                subtotalPagesPrice = PagesCount * .33
                subtotalPages.textContent = subtotalPagesPrice.toFixed(2)
            }

            // Calculate the total price based on number of copies
            let totalPriceValue = price * numCopies;

            // Round up the total price to the nearest upper whole value
            totalPriceValue = Math.ceil(totalPriceValue);

            // Update the total price element
            totalPrice.textContent = totalPriceValue.toFixed(
            2); // Assuming you want to show the price with 2 decimal places
        }

    </script>
</body>
@endsection
