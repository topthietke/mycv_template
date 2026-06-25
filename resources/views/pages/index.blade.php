<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CV - Trần Ngọc Tú</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:wght@400;600;700&family=Source+Sans+3:wght@300;400;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/inter-ui/4.1.1/inter.min.css"
        integrity="sha512-sKm1yZUWI/+DDMju+xd5GBXqNF2pnI9F3obEZP9boHbobmxCvaByoyeyvjc+lhiH5KtInOvxUJazjaS1WFnAsg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- PDF libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="/assets/css/main.css">

</head>

<body>
    <!-- ══ DOWNLOAD BUTTON ══ -->
    <!-- ----------------------------------------------------------------------------------------------------------------------- -->
    @include('pages.download')
    <!-- ----------------------------------------------------------------------------------------------------------------------- -->
    <!-- Trang 1 -->
    @include('pages.page_1')
    <!-- ----------------------------------------------------------------------------------------------------------------------- -->
    <!-- ══════ PAGE 2 ═══════ -->
    @include('pages.page_2')
    <!-- ----------------------------------------------------------------------------------------------------------------------- -->
    <!-- ══════ PAGE 3 ═══════ -->
    @include('pages.page_3')
    <!-- ----------------------------------------------------------------------------------------------------------------------- -->
    <!-- ══════ PAGE 4 ═══════ -->
    @include('pages.page_4')
    <!------------------------------------------------------------------------------------------------------------------------- -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{--
    <script src="/assets/js/main.js"></script> --}}

</body>

</html>