<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CV - Trần Ngọc Tú</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;600;700&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/inter-ui/4.1.1/inter.min.css" integrity="sha512-sKm1yZUWI/+DDMju+xd5GBXqNF2pnI9F3obEZP9boHbobmxCvaByoyeyvjc+lhiH5KtInOvxUJazjaS1WFnAsg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- PDF libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="/assets/css/main.css">

</head> 

<body>
  <!-- ══ DOWNLOAD BUTTON ══ -->
  <!-- ----------------------------------------------------------------------------------------------------------------------- -->
  <div id="dl-bar">
    <button id="dl-pdf-btn" onclick="downloadPDF()">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="white">
        <path d="M5 20h14v-2H5v2zm7-18v12.17l-3.59-3.58L7 12l5 5 5-5-1.41-1.41L13 14.17V2h-1z" />
      </svg>
      <span id="btn-text">Tải xuống PDF</span>
      <div id="dl-progress">
        <div id="dl-progress-fill"></div>
      </div>
    </button>
    <a href="#" class="btn btn-primary">
      <i class="fa fa-edit"></i>
      Chỉnh sửa
    </a>
    <a href="/logout" class="btn btn-primary">
      <i class="fa fa-lock"></i>
      Đăng xuất
    </a>

  </div>
  <!-- ----------------------------------------------------------------------------------------------------------------------- -->
  <!-- Trang 1 -->
  <div class="cv-page" id="cv-page-1">
    <!-- HEADER -->
    <div class="cv-header">
      <div class="cv-header__photo">
        <img src="/assets/img/avatar.png" alt="Trần Ngọc Tú" />
      </div>
      <div class="cv-header__info">
        <div class="cv-header__name">Trần Ngọc Tú</div>
        <div class="cv-header__title">Lập trình viên PHP Laravel - VueJS</div>
        <div class="cv-header__divider"></div>
        <div class="cv-header__contacts">
          <!-- <span>
            <i class="fa fa-edit"></i>
            <svg viewBox="0 0 24 24">
              <path d="M19 4H5a3 3 0 00-3 3v10a3 3 0 003 3h14a3 3 0 003-3V7a3 3 0 00-3-3zm0 2l-7 5-7-5h14zm0 12H5a1 1 0 01-1-1V8.5l7 5 7-5V17a1 1 0 01-1 1z" />
            </svg>
            23/04/1986
          </span> -->
          <span>
            <svg viewBox="0 0 24 24">
              <path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.45 11.45 0 003.58.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.49 11.49 0 00.57 3.57 1 1 0 01-.25 1.02l-2.2 2.2z" />
            </svg>
            0765132999
          </span>
          <span>
            <svg viewBox="0 0 24 24" width="40" height="40" fill="#007bff">
              <path d="M19 4H5a3 3 0 00-3 3v10a3 3 0 003 3h14a3 3 0 003-3V7a3 3 0 00-3-3zm0 2l-7 5-7-5h14zm0 12H5a1 1 0 01-1-1V8.5l7 5 7-5V17a1 1 0 01-1 1z" />
            </svg>
            ngoctusoftware@gmail.com
          </span>
          <span>
            <svg viewBox="0 0 24 24">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z" />
            </svg>
            Phường Tây Mỗ - Hà Nội
          </span>
           <span>
            <svg viewBox="0 0 24 24">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z" />
            </svg>
            CV online: <a href="https://https://ngoctusoftware.42web.io/" target="_blank">ngoctusoftware.42web.io</a>
          </span>
        </div>
      </div>
    </div>
    <!-- BODY -->
    <div class="cv-body">
      <!-- ---------------------------------------    Mục tiêu nghề nghiệp    --------------------------------------------------------- -->
      <div class="cv-section">
        <div class="cv-section__header">
          <div class="cv-section__label">Mục tiêu nghề nghiệp</div>
          <div class="cv-section__line"></div>
        </div>
        <div class="cv-intro">
          <span>
            Với 5 năm kinh nghiệm phát triển hệ thống web bằng PHP (Laravel) và VueJS, tôi mong muốn phát triển sự nghiệp tại Viettel với vai trò Lập trình viên PHP. Mục tiêu của tôi là áp dụng kiến thức chuyên sâu về kiến trúc phần mềm, tối ưu hóa website và server , cùng khả năng ứng dụng AI để giải quyết các bài toán phức tạp, qua đó xây dựng các hệ thống lớn có performance cao. Tôi kỳ vọng được đồng hành cùng những đồng nghiệp ưu tú, không ngừng học hỏi và đóng góp trực tiếp vào sứ mệnh kiến tạo xã hội số của Tập đoàn
          </span>
        </div>
      </div>

      <!-- ---------------------------------------     Quá trình đào tạo     ---------------------------------------------------------------->
      <div class="cv-section">
        <!-- Tiêu đề Quá trình đào tạo -->
        <div class="cv-section__header">
          <div class="cv-section__label">Quá trình đào tạo</div>
          <div class="cv-section__line"></div>
        </div>
        <table class="table table-striped">
          <thead class="table-secondary">
            <tr>
              <th class="text-left" scope="col">Tên trường</th>
              <th class="text-left" scope="col">Chuyên ngành</th>
              <th class="text-left" scope="col">Loại tốt nghiệp</th>
              <th class="text-left" scope="col">Năm tốt nghiệp</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Trường Đại học Thái Nguyên</td>
              <td>Công nghệ thông tin</td>
              <td class="text-center">Khá</td>
              <td>09/2017 - 05/2019</td>
            </tr>
            <tr>
              <td>Trường Cao Đăng Sư phạm</td>
              <td>Công nghệ thông tin</td>
              <td class="text-center">Khá</td>
              <td>09/2006 - 05/2008</td>
            </tr>
            <tr>
              <td>Trường Điện tử Điện lạnh</td>
              <td>Công nghệ thông tin</td>
              <td class="text-center">Khá</td>
              <td>09/2024 - 05/2006</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- ---------------------------------------     KỸ NĂNG    ---------------------------------------------------------------->
      <!-- KỸ NĂNG -->
      <div class="cv-section">
        <div class="cv-section__header">
          <div class="cv-section__label">Kỹ năng</div>
          <div class="cv-section__line"></div>
        </div>
        <table class="table table-striped">
          <thead class="table-secondary">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Công nghệ</th>
              <th scope="col">Mức độ</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>PHP: Laravel, Lumen, Thuần, MVC, Wordpress, OOP, Design Pattern</td>
              <td>Thành thạo</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Resful API, VueJS, HTML, CSS, JS, Bootstrap, Docker</td>
              <td>Thành thạo</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Linux, Windows, Nginx, Apache, XAMPP, WinSCP, Putty, Gitlab, GitHub</td>
              <td>Thành thạo</td>
            </tr>
            <tr>
              <td>4</td>
              <td>Thành thạo sử dụng AI: Google Gemini, Claude AI, ChatGPT</td>
              <td>Thành thạo</td>
            </tr>
            <tr>
              <td>5</td>
              <td>CI/CD, NextJS, NuxtJS,ReactJS, NodeJS, Flutter Dart, Liferay (CMS - Java)</td>
              <td>Cơ bản, Tìm hiểu</td>
            </tr>
            <tr>
              <td>6</td>
              <td>MySQL, MariaDB, MongoDB, SQL Server</td>
              <td>Hiểu biết</td>
            </tr>
          </tbody>
        </table>
      </div>


    </div><!-- /cv-body -->
  </div>
  <!-- ----------------------------------------------------------------------------------------------------------------------- -->
  <!-- ══════ PAGE 2 ═══════ -->
  <div class="cv-page" id="cv-page-2" style="margin-top: 30px;">
    <div class="cv-body" style="padding-top:30px;">
      <!-- KINH NGHIỆM LÀM VIỆC và Dự án thực tế -->
      <div class="cv-section">

        <div class="cv-section__header">
          <div class="cv-section__label">Kinh nghiệm làm việc và Dự án thực tế</div>
          <div class="cv-section__line"></div>
        </div>

        <div class="cv-entry">
          <!-------------------------------  Công ty Cổ phần Công nghệ HTECOM  ---------------------------------->
          <div class="cv-entry__row">
            <div class="cv-entry__school">Công ty Cổ phần Công nghệ HTECOM</div>
            <div class="cv-entry__school">Chuyên viên lập trình</div>
            <div class="cv-entry__date">07/2024 - nay</div>
          </div>
          <!------------------------------------------------------------------------------------------------------->
          <ul class="cv-entry__bullets">
            <li><b>Công nghệ: </b> PHP (Laravel), MySQL, HTML5, CSS3, Bootstrap 5, JavaScript, jQuery, Queue, Docker</li>
            <li><b>Dự án phụ trách:</b>
              <div class="cv-entry__bullets">- Dự án tuyển sinh du học Vangunu: <a class="lnk_project" href="https://vangunu.com" target="_blank">vangunu.com</a> </div>
              <div class="cv-entry__bullets">- Dự án Booking Spa cho khách hàng Châu Âu: <a class="lnk_project" href="https://cicireluxe.com.au" target="_blank">cicireluxe.com.au</a> </div>
              <div class="cv-entry__bullets">- Dự án Hệ thống CRM tuyển sinh của ĐH Mở HCM: <a class="lnk_project" href="https://crm.elolms.edu.vn" target="_blank">crm.elolms.edu.vn</a> </div>
              <div class="cv-entry__bullets">- Dự án mạng xã hội thanh thiếu niên: <a class="lnk_project" href="https://vlingai.com" target="_blank">vlingai.com</a> </div>
              <div class="cv-entry__bullets">- Dự án Liferay (CMS Java) Đường cao tốc Việt Nam: <a class="lnk_project" href="http://portal.tctvec.vn/web/guest" target="_blank">portal.tctvec.vn</a></div>
            </li>
            <li><b>Nội dung công việc:</b>
              <div class="cv-entry__bullets">- Phân tích yêu cầu, thiết kế giải pháp và kiến trúc phần mềm cho dự án.</div>
              <div class="cv-entry__bullets">- Triển khai các chức năng chính của dự án (Backend, Frontend).</div>
              <div class="cv-entry__bullets">- Review code và đảm bảo chất lượng.</div>
              <div class="cv-entry__bullets">- Deploy ứng dụng lên server.</div>
              <div class="cv-entry__bullets">- Debug và khắc phục lỗi.</div>
              <div class="cv-entry__bullets">- Sử dụng Google Gemini, Claude AI chỉnh sửa, nâng cấp hệ thống.</div>
            </li>
          </ul>
          <!------------------------------  Tập đoàn Omigroup  -------------------------------------->
          <div class="cv-entry__row">
            <div class="cv-entry__school">Tập đoàn Omigroup</div>
            <div class="cv-entry__school">Chuyên viên lập trình</div>
            <div class="cv-entry__date">06/2022 đến 06/2024</div>
          </div>
          <!------------------------------------------------------------------------------------------------------->
          <ul class="cv-entry__bullets">
            <li><b>Công nghệ: </b> PHP (Laravel), MySQL, HTML5, CSS3, Bootstrap 5, JavaScript, jQuery, Queue, Docker</li>
            <li><b>Dự án phụ trách:</b>
              <div>- Hệ thống bán hàng dược phẩm trực tuyến: <a href="http://vangunu.com" target="_blank">Bán hàng
                  Omipharma</a></div>
              <div>- Hệ thống Quản lý bán hàng nội bộ (Ominext): <a href="https://omi-pos.ominext.dev/xadmin/login">Omi-pos
                  Ominext</a></div>
            </li>
            <li><b>Nội dung công việc:</b>
              <div class="cv-entry__bullets">- Phối hợp các thành viên trong nhóm, tham gia phát triển và nâng cấp hệ thống API từ phiên bản PHP thuần sang PHP Lumen.</div>
              <div class="cv-entry__bullets">- Tham gia nghiên cứu, thiết kế và tối ưu database: MySQL, MongoDB.</div>
              <div class="cv-entry__bullets">- Tham gia nghiên cứu, phát triển, tích hợp các sàn TMĐT: Shopee, Lazada về hệ thống Omipos.</div>
              <div class="cv-entry__bullets">- Phối hợp với nhóm Kiểm thử kiểm tra và sửa lỗi.</div>
              <div class="cv-entry__bullets">- Tận dụng Google Gemini, Claude AI tra cưu bug logic của hệ thống.</div>              
            </li>
          </ul>
        </div>


      </div>

    </div><!-- /cv-body -->


  </div>
  <!-- ----------------------------------------------------------------------------------------------------------------------- -->
  <!-- ══════ PAGE 3 ═══════ -->
  <div class="cv-page" id="cv-page-3" style="margin-top: 30px;">
    <div class="cv-body" style="padding-top:30px;">
      <!-- KINH NGHIỆM LÀM VIỆC và Dự án thực tế -->
      <div class="cv-section">
        <div class="cv-section__header">
          <div class="cv-section__label">Kinh nghiệm làm việc và Dự án thực tế</div>
          <div class="cv-section__line"></div>
        </div>

        <div class="cv-entry">
          <!-------------------------------  Công ty trực tuyến Hoàng Kim  ---------------------------------->
          <div class="cv-entry__row">
            <div class="cv-entry__school">Công ty trực tuyến Hoàng Kim</div>
            <div class="cv-entry__school">Chuyên viên lập trình PHP Laravel</div>
            <div class="cv-entry__date">03/2020 đến 04/2022</div>
          </div>
          <!------------------------------------------------------------------------------------------------------->
          <ul class="cv-entry__bullets">
            <li><b>Công nghệ: </b> PHP Laravel, MySQL, HTML5, CSS3, Bootstrap 5, JavaScript, jQuery, Queue, Docker, Gitlab, GitHub</li>
            <li><b>Dự án phụ trách:</b>
              <div class="cv-entry__bullets">- Phần mềm quản lý bán hàng POD nội bộ </a></div>
              <div class="cv-entry__bullets">- Website bán hàng POD trên shopify </a></div>
              <div class="cv-entry__bullets">- Website bán hàng POD trên wordpress </a></div>
            </li>
            <li><b>Nội dung công việc:</b>
              <div class="cv-entry__bullets">- Phát triển, tối ưu code, maintain và xây dựng các module hệ thống quản trị bán hàng của Công ty.</div>
              <div class="cv-entry__bullets">- Cắt chuyển giao diện HTML sang PHP Laravel, tối ưu hiệu suất và khả năng tái sử dụng code.</div>
              <div class="cv-entry__bullets">- Phát triển và nâng cấp các tính năng trên web bán hàng trên nền tảng Shopify, Wordpress, đảm bảo trải nghiệm người dùng tốt.</div>
              <div class="cv-entry__bullets">- Thiết kế và tích hợp API, kết nối hệ thống với bên thứ ba (cổng thanh toán, vận chuyển...).</div>
              <div class="cv-entry__bullets">- Quản lý cơ sở dữ liệu MySQL, tối ưu câu lệnh SQL và cải thiện hiệu năng hệ thống.</div>
              <div class="cv-entry__bullets">- Sử dụng GitLab để quản lý source code và làm việc nhóm hiệu quả.</div>
            </li>
          </ul>
          <!------------------------------  Dự án cá nhân  -------------------------------------->
          <div class="cv-entry__row">
            <div class="cv-entry__school">Dự án cá nhân</div>
            <div class="cv-entry__school">Freelance</div>
            <div class="cv-entry__date">05/2018 đến 01/2022</div>
          </div>
          <!------------------------------------------------------------------------------------------------------->
          <ul class="cv-entry__bullets">
            <li><b>Công nghệ: </b> PHP Laravel, Wordpress, MySQL, HTML5, CSS3, Bootstrap 5, Js, Gitlab</li>
            <li><b>Dự án phụ trách:</b>
              <div class="cv-entry__bullets">- Dự án quản lý bán hàng TMAS: <a class="lnk_project" href="http://tmas.vn" target="_blank"> tmas.vn </a></div>
              <div class="cv-entry__bullets">- Dự án xây dựng HVHome: <a class="lnk_project" href="https://hvhomevn.com/" target="_blank">hvhomevn.com </a></div>
              <div class="cv-entry__bullets">- Dự án thực phẩm sạch <a class="lnk_project text-dark" href="#" target="_blank"> halofoods.vn </a></div>
              <div class="cv-entry__bullets">- Dự án năng lượng mặt trời <a class="lnk_project text-dark" href="#" target="_blank"> tctsolar.com </a></div>
            </li>
            <li><b>Nội dung công việc:</b>
              <div class="cv-entry__bullets">- Phối hợp các thành viên trong nhóm, tham gia phát triển và nâng cấp hệ thống API từ phiên bản PHP thuần sang PHP Lumen.</div>
              <div class="cv-entry__bullets">- Tham gia nghiên cứu, thiết kế và tối ưu database: MySQL, MongoDB.</div>
              <div class="cv-entry__bullets">- Tham gia nghiên cứu, phát triển, tích hợp các sàn TMĐT: Shopee, Lazada về hệ thống Omipos.</div>
              <div class="cv-entry__bullets">- Phối hợp với nhóm Kiểm thử kiểm tra và sửa lỗi.</div>
            </li>
          </ul>
          <!------------------------------  Tập đoàn Omigroup  -------------------------------------->


        </div>


      </div>

    </div><!-- /cv-body -->
  </div>
  <!-- ----------------------------------------------------------------------------------------------------------------------- -->
  <!-- ══════ PAGE 4 ═══════ -->
  <div class="cv-page" id="cv-page-4" style="margin-top: 30px;">
    <div class="cv-body" style="padding-top:30px;">
      <!-- HOẠT ĐỘNG -->
      <div class="cv-section">
        <div class="cv-section__header">
          <div class="cv-section__label">Hoạt động</div>
          <div class="cv-section__line"></div>
        </div>
        <div class="cv-section__body">
          <div class="cv-content">
            <b>Tại Tập đoàn Omigroup</b>: Tham gia giải bóng đá thường niên của Omigroup, nâng cao tinh thần và gắn kết đồng đội.
          </div>
          <div class="cv-content">
            <div><b>Tổng công ty sản xuất thiết bị Viettel (Tên cũ: Công ty Thông tin M1):</b></div>
            <div class="mx-3">- Tham gia Ngày hội sáng kiến ý tưởng để tạo ra những cách làm mới nâng cao hiệu quả trong trong việc.</div>
            <div class="mx-3">- Tham gia huấn luyện quân sự và đội phòng cháy chữa cháy (PCCC), rèn luyện tinh thần kỷ luật, tác phong sẵn sàng ứng phó tình huống.</div>
          </div>
        </div>
      </div>
      <!-- NGOẠI NGỮ -->

      <div class="cv-section">
        <div class="cv-section__header">
          <div class="cv-section__label">Ngoại ngữ</div>
          <div class="cv-section__line"></div>
        </div>
        <div class="cv-section__body">
          <div class="cv-content">
            <b>Tiếng Việt:</b> Thành thạo ngôn ngữ mẹ đẻ, có khả năng giao tiếp và viết lách tốt, sử dụng thành thạo trong công việc và cuộc sống hàng ngày.
          </div>
          <div class="cv-content">
            <b>Tiếng Anh:</b> Đọc hiểu tài liệu chuyên ngành, Có thể giao tiếp qua Chat Messenger, Email, Zalo với đồng nghiệp và khách hàng nước ngoài. Đang trong quá trình học tập để nâng cao kỹ năng giao tiếp và viết lách tiếng Anh.
          </div>
        </div>
      </div>
    </div>


  </div>
  <!------------------------------------------------------------------------------------------------------------------------- -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  {{-- <script src="/assets/js/main.js"></script> --}}
  
</body>

</html>