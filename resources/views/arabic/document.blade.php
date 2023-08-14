@extends('arabic.main')
@section('content')
@section('page', 'document')
@section('title', 'Document')
<body>
    <section class="w-100 m-auto document">
        <div class="container  m-auto"> 
        @include('arabic.layouts.top')
        <div class="main flex-row-reverse d-flex justify-content-center align-items-start">
            <div class="documents">
                <div class="top">
                    <p class="mainText text-end">راجع ملفك لو سمحت</p>
                    <!-- <p class="doc text-end flex-row-reverse d-flex justify-content-start align-items-start"><img src="./img/pdficon.png"
                            alt="">اسم الملف</p> -->
                </div>
                <div style="width: 37.9rem; height: 60.5rem; 
                    background: #80808059;  margin: auto; margin-right: 0; margin-bottom: 2.9rem;"
                        class="d-flex justify-content-center align-items-center">

                        <div class="documentFiles overflow-hidden d-flex justify-content-center align-items-center">
                        <canvas style="width: 100%; position: relative; cursor: grabbing;"></canvas>

                        </div>
                    </div>
                <div class="pagination d-flex justify-content-start align-items-center">
                    <img src="{{ asset('public/assets/arabic') }}/img/Larrow.png" alt="" onclick="Pagination(false)">
                    <button class="currentPage">1</button>
                    <p>Of</p>
                    <p class="number">3</p>
                    <img src="{{ asset('public/assets/arabic') }}/img/Larrow.png" alt="" style="transform: rotate(180deg);"
                        onclick="Pagination(true)">
                </div>
            </div>
        <div>
            <div class="settings">
                <div class="d-flex options flex-row-reverse">
                    <p> :لون <img src="{{ asset('public/assets/arabic') }}/img/color.png" style="width: 3.8rem;" alt=""></p>
                    <div class="d-flex fle-column flex-row-reverse">


                    <div class="d-flex input flex-row-reverse">
                        <input id="blackwhite" checked="true" type="radio" onchange="(uncheck('color'))">
                        <p>تدرج الرمادي</p>
                    </div>
                    <div class="d-flex input flex-row-reverse">
                        <input type="radio" id="color"  onchange="(uncheck('blackwhite'))">
                        <p style="margin-left: 0;"> من جانب واحد </p>
                    </div>
                    </div>

                </div>
                <div class="d-flex options flex-row-reverse">
                    <p> :الجوانب  <img src="{{ asset('public/assets/arabic') }}
/img/sides.png" style="width: 3.2rem;" alt=""></p>
                    <div class="d-flex fle-column flex-row-reverse">

                    <div class="d-flex input flex-row-reverse">
                        <input type="radio" checked="true" id="oneside"  onchange="(uncheck('twoside'))">
                        <p>من جانب واحد</p>
                    </div>
                    <div class="d-flex input flex-row-reverse">
                        <input type="radio" id="twoside"  onchange="(uncheck('oneside'))">
                        <p style="margin-left: 0;">وجهان</p>
                    </div>
                    </div>

                </div>
                <div class="d-flex options flex-row-reverse">
                    <p> :يتراوح <img src="{{ asset('public/assets/arabic') }}/img/copies.png" alt="" style="width: 3.3rem;"></p>
                    <div class="d-flex fle-column flex-row-reverse">

                    <div class="d-flex input flex-row-reverse">
                        <input type="radio" checked="true" id="all"  onchange="(uncheck('custom', 'all'))">
                        <p>كل الصفحات</p>
                    </div>
                    <div class="d-flex input flex-row-reverse">
                        <input type="radio" id="custom"  onchange="(uncheck('all', 'custom'))">
                        <p style="margin-left: 0;">مخصص</p>
                    </div>
                    </div>

                </div>
                <div class="Pages flex justify-content-start flex-row-reverse" id="CopiesNumber">
                    <div class="d-flex fle-column flex-row-reverse">

                    <div class="d-flex justify-content-center align-items-center">
                        <div class="position-relative d-flex align-items-center">

                            <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 35px; font-weight: 500; "
                                onclick="IncreaseCount('from', false)">-</p>
                            <input disabled type="number" class="number text-center" id="from" value="1">

                            <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 35px; font-weight: 500; transform: rotate(180deg);"
                                onclick="IncreaseCount('from', true)">+</p>
                        </div>
                        <p style="margin-left: 2rem; margin-right: 0; font-weight: 400;" >من</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="position-relative d-flex align-items-center">

                            <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 35px; font-weight: 500; "
                                onclick="IncreaseCount('to', false)">-</p>
                            <input disabled type="number" class="number text-center" id="to" value="2">

                            <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 35px; font-weight: 500; transform: rotate(180deg);"
                                onclick="IncreaseCount('to', true)">+</p>
                        </div>
                        <p style="margin-left: 2rem; margin-right: 4.8rem; font-weight: 400;">ل</p>
                    </div>
                    </div>
                    
                </div>
                <div class="d-flex Pages justify-content-end"> 
                    <div class="d-flex justify-content-center w-100 align-items-center flex-row-reverse">
                    <p style="margin-left: 6.9rem; margin-right: 1.2rem;"> :نسخ<img style="margin-left: 1.2rem; width: 2.8rem;" src="{{ asset('public/assets/arabic') }}/img/copies2.png"  alt=""></p>
                    <div class="position-relative d-flex align-items-center">

                        <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 35px; font-weight: 500; "
                            onclick="IncreaseCount('copies', false)">-</p>
                        <input disabled type="number" class="number text-center" id="copies" value="1">

                        <p style="user-select: none; cursor: pointer; margin: 0 !important; padding: 0; font-size: 35px; font-weight: 500; transform: rotate(180deg);"
                            onclick="IncreaseCount('copies', true)">+</p>
                    </div>
                    
                    <p class="amount">10 SAR</p>
                    </div>                    
                </div>
            </div>
            <div class="amount d-flex justify-content-between align-items-center flex-row-reverse">
                <h2 style="letter-spacing: .1rem;"> المجموع: <span>10 ريال</span></h2>   
                <div class="d-flex">
                    <a href="{{ route('arabicPay') }}" class="d-flex justify-content-center align-items-center back">  < تأكيد الدفع</button>
                        <a href="{{ route('arabicCode') }}" class="d-flex justify-content-center align-items-center pay">></a>
                    </div> 
                    
            </div>
        </div>

        </div>
 
       </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


    <script>
        let custom = false
        document.getElementById("CopiesNumber").style.opacity = "0.5"
        const uncheck = (id, e) => {
            document.getElementById(id).checked = false
            if (e == "custom") {
                document.getElementById("CopiesNumber").style.opacity = "1"
                custom = true
            } else if (e == "all") {
                document.getElementById("CopiesNumber").style.opacity = "0.5"
                custom = false
            }
        }

        const documentFiles = document.querySelector(".documentFiles")
        const currentPage = document.querySelectorAll(".currentPage")
        const paginationBtn = document.querySelector(".pagination button")
        const paginationP = document.querySelector(".pagination .number")
        const PDFs = "@if (isset($file)) {{ $file }} @endif"
        const canvas = document.querySelector("canvas")

        let InitalPage = 1
        const PDFJS = ()=>{
    pdfjsLib.getDocument(`${PDFs}`).promise.then(doc => {

    doc.getPage(InitalPage).then(page => {
console.log(page)

const context = canvas.getContext("2d")
// console.log(page.getViewport({scale:1}))
var viewport = page.getViewport({ scale: 1 })
// console.log(viewport)
canvas.width = viewport.width
canvas.height = viewport.height
paginationP.innerHTML = doc._pdfInfo.numPages
page.render({
    canvasContext: context,
    viewport: viewport
})
})
})

}

PDFJS()
       

        
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


        let from = document.getElementById("from").value
        let to = document.getElementById("from").value
        let copies = document.getElementById("from").value


        const IncreaseCount = (id, value) => {


            if (id == "from") {
                if (custom) {
                    if (value) {
                        document.getElementById(id).value++

                    } else {
                        if (document.getElementById(id).value <= 0) {
                            document.getElementById(id).value = 0
                        } else {
                            document.getElementById(id).value--
                        }

                    }
                }
            }
            else if (id == "to") {
            if (custom) {

                if (value) {
                    document.getElementById(id).value++

                } else {
                    if (document.getElementById(id).value <= 0) {
                        document.getElementById(id).value = 0
                    }
                    else {
                        document.getElementById(id).value--

                    }
                }
            }
            } if (id == "copies") {
                if (value) {
                    document.getElementById(id).value++

                } else {
                    if (document.getElementById(id).value <= 0) {
                        document.getElementById(id).value = 0
                    } else {
                        document.getElementById(id).value--
                    }

                }
            }


        }

    </script>
</body>
@endsection