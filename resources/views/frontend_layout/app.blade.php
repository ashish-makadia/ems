<!DOCTYPE html>

<html lang="en">
@php
$company_name = "Start & Grow";
$logo = asset('/assets/app/media/img/logos/logo_.png');
$siteinfo=Config::get('constants.siteinfo');

@endphp
{{-- {{$siteinfo['domain']}} --}}
<head>
    <meta charset="utf-8">
    <title>{{$company_name}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="{{$siteinfo['keywords']}}">
    <meta content="Free HTML Templates" name="{{$siteinfo['descriptions']}}">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
    <style>
        #loader_img {
            display:none;
			height: 100%;
			width: 100%;
			z-index: 1000;
			background: #fcfcfc url("http://www.mvgen.com/loader.gif") no-repeat scroll center center / 40px 40px;
			top: 0;
			left: 0;
			opacity: 0.5;
		}

/* Support css */

.formbold-mb-5 {
  margin-bottom: 20px;
}
.formbold-pt-3 {
  padding-top: 12px;
}
.formbold-main-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px;
    position: absolute;
    right: 73px;
    top: 0;
}

.formbold-form-wrapper {
  margin: 0 auto;
  max-width: 550px;
  width: 100%;
  background: white;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  display: none;
}

.formbold-form-wrapper.active {
  display: block;
  position: fixed;
    left: 53%;
    z-index: 11111;
}

.formbold-form-label {
  display: block;
  margin-bottom: 5px;
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 16px;
    color: #626F75;
}
.formbold-form-label-2 {
  font-weight: 600;
  font-size: 20px;
  margin-bottom: 20px;
}

.formbold-form-input {
  width: 100%;
  padding: 8px 10px;
  border-radius: 6px;
  border: 1px solid #e0e0e0;
  background: white;
  font-weight: 500;
  font-size: 16px;
  color: #6b7280;
  outline: none;
  resize: none;
}
.formbold-form-input:focus {
  border-color: #6a64f1;
  box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
}

.formbold-btn {
  text-align: center;
  font-size: 16px;
  border-radius: 6px;
  padding: 14px 32px;
  border: none;
  font-weight: 600;
  background-color: #39B1F9;
  color: white;
  cursor: pointer;
}
.formbold-btn:hover {
  box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
}

.formbold--mx-3 {
  margin-left: -12px;
  margin-right: -12px;
}
.formbold-px-3 {
  padding-left: 12px;
  padding-right: 12px;
}
.flex {
  display: flex;
}
.flex-wrap {
  flex-wrap: wrap;
}
.w-full {
  width: 100%;
}
.formbold-form-header {
  background: #1365FF;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 36px;
  border-radius: 8px 8px 0px 0px;
}
.formbold-form-header h3 {
  font-weight: 700;
  font-size: 20px;
  color: white;
}
.formbold-form-header button {
  color: white;
  background: transparent;
  border: none;
}
.formbold-chatbox-form {
  padding: 32px 36px;
  margin: 0 auto;
    max-height: calc(100vh - 20vh);
    /* width: 640px; */
    overflow: auto;
}
.formbold-action-buttons {
  /* max-width: 550px;
  margin-left: auto;
  margin-right: auto; */
  display: flex;
  align-items: center;
  justify-content: flex-end;
  margin-top: 48px;
  position: fixed;
    /* display: none; */
    right: 45px;
    bottom: 110px;
    z-index: 99;
}
.formbold-action-btn {
  width: 70px;
  height: 70px;
  background: #F3525A;
  color: white;
  border-radius: 50%;
  margin-left: 20px;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.formbold-action-btn .formbold-cross-icon {
  display: none;
}

.formbold-action-btn.active .formbold-cross-icon {
  display: block;
}

.formbold-action-btn.active .formbold-chat-icon {
  display: none;
}
@media (min-width: 540px) {
  .sm\:w-half {
    width: 50%;
  }
}

        </style>
</head>

@include('frontend_layout.navigation')
<div id="loader_img"></div>
    @yield('content')


    <div class="formbold-main-wrapper">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="w-full">
          <div class="formbold-form-wrapper">
            <div class="formbold-form-header">
              <h3>Customer Support Request Form</h3>
              <button onclick="chatboxToogleHandler()">
                 <svg width="17" height="17" viewBox="0 0 17 17" fill="white">
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M0.474874 0.474874C1.10804 -0.158291 2.1346 -0.158291 2.76777 0.474874L16.5251 14.2322C17.1583 14.8654 17.1583 15.892 16.5251 16.5251C15.892 17.1583 14.8654 17.1583 14.2322 16.5251L0.474874 2.76777C-0.158291 2.1346 -0.158291 1.10804 0.474874 0.474874Z"
                  />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M0.474874 16.5251C-0.158291 15.892 -0.158291 14.8654 0.474874 14.2322L14.2322 0.474874C14.8654 -0.158292 15.892 -0.158291 16.5251 0.474874C17.1583 1.10804 17.1583 2.1346 16.5251 2.76777L2.76777 16.5251C2.1346 17.1583 1.10804 17.1583 0.474874 16.5251Z"
                  />
                </svg>
              </button>
            </div>
            <form
              action="{{ route('customer.supportstore')}}"
              method="POST"  enctype="multipart/form-data" 
              class="formbold-chatbox-form"
            >
            @csrf
              <div class="formbold-mb-5">
                <label for="name" class="formbold-form-label"> Subject </label>
                <input
                  type="text"
                  name="subject"
                  id="subject"
                  placeholder="Subject"
                  class="formbold-form-input"
                />
              </div>
              <div class="formbold-mb-5">
                <label for="description" class="formbold-form-label"> Description </label>
                <textarea
                  rows="6"
                  name="description"
                  id="description"
                  placeholder="Description"
                  class="formbold-form-input"
                ></textarea>
              </div>
              <div class="formbold-mb-5">
                <label for="website" class="formbold-form-label"> Mobile </label>
                <input
                  type="text"
                  name="mobile"
                  id="mobile"
                  placeholder="9999999999"
                  class="formbold-form-input"
                />
                <div class="formbold-mb-5">
                  <label  class="formbold-form-label" for="website">File upload</label>
                      <input type="file" id="file_upload" name="file_upload" class="formbold-form-input" />
              </div>
              </div>
              
              <div class="formbold-mb-5">
                  <label for="website" class="formbold-form-label"> Website </label>
                  <input
                    type="text"
                    name="website"
                    id="website"
                    placeholder="example@domain.com"
                    class="formbold-form-input"
                  />
                </div>
              <div class="formbold-mb-5">
                  <label for="mail" class="formbold-form-label"> Mail </label>
                  <input
                    type="text"
                    name="mail"
                    id="mail"
                    placeholder="example@domain.com"
                    class="formbold-form-input"
                  />
                </div>
              <div class="formbold-mb-5">
                <label for="firstname" class="formbold-form-label"> First Name </label>
                <input
                  type="text"
                  name="firstname"
                  id="firstname"
                  placeholder="First Name"
                  class="formbold-form-input"
                />
              </div>
              <div class="formbold-mb-5">
                <label for="lastname" class="formbold-form-label"> Last Name </label>
                <input
                  type="text"
                  name="lastname"
                  id="lastname"
                  placeholder="Last Name"
                  class="formbold-form-input"
                />
              </div>
              <div class="formbold-mb-5">
                <label for="company" class="formbold-form-label"> Company </label>
                <input
                  type="text"
                  name="company"
                  id="company"
                  placeholder="Company"
                  class="formbold-form-input"
                />
              </div>
              <div class="formbold-mb-5">
                  <label class="form-label" for="form6Example7">Priority</label>
                  <select class="form-control" name="priority" id="priority">
                    <option value="">Select priority</option>
                    <option value="high" >High</option>
                    <option value="low" >Low</option>
                </select>

                </div>

              <div>
                <button type="submit" class="formbold-btn w-full">Submit</button>
              </div>
            </form>
          </div>
          <div class="formbold-action-buttons">
            <button class="formbold-action-btn" onclick="chatboxToogleHandler()">
              <span class="formbold-cross-icon">
              <!-- <img class="w-100" src="{{asset('frontend/img/ds.png')}}" alt="Image"> -->
                <svg
                  width="17"
                  height="17"
                  viewBox="0 0 17 17"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M0.474874 0.474874C1.10804 -0.158291 2.1346 -0.158291 2.76777 0.474874L16.5251 14.2322C17.1583 14.8654 17.1583 15.892 16.5251 16.5251C15.892 17.1583 14.8654 17.1583 14.2322 16.5251L0.474874 2.76777C-0.158291 2.1346 -0.158291 1.10804 0.474874 0.474874Z"
                    fill="white"
                  />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M0.474874 16.5251C-0.158291 15.892 -0.158291 14.8654 0.474874 14.2322L14.2322 0.474874C14.8654 -0.158292 15.892 -0.158291 16.5251 0.474874C17.1583 1.10804 17.1583 2.1346 16.5251 2.76777L2.76777 16.5251C2.1346 17.1583 1.10804 17.1583 0.474874 16.5251Z"
                    fill="white"
                  />
                </svg>
              </span>
              <span class="formbold-chat-icon">
              <img class="w-100" src="{{asset('frontend/img/ds.png')}}" alt="Image">
                <!-- <svg
                  width="28"
                  height="28"
                  viewBox="0 0 28 28"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M19.8333 14.0002V3.50016C19.8333 3.19074 19.7103 2.894 19.4915 2.6752C19.2728 2.45641 18.976 2.3335 18.6666 2.3335H3.49992C3.1905 2.3335 2.89375 2.45641 2.67496 2.6752C2.45617 2.894 2.33325 3.19074 2.33325 3.50016V19.8335L6.99992 15.1668H18.6666C18.976 15.1668 19.2728 15.0439 19.4915 14.8251C19.7103 14.6063 19.8333 14.3096 19.8333 14.0002ZM24.4999 7.00016H22.1666V17.5002H6.99992V19.8335C6.99992 20.1429 7.12284 20.4397 7.34163 20.6585C7.56042 20.8772 7.85717 21.0002 8.16659 21.0002H20.9999L25.6666 25.6668V8.16683C25.6666 7.85741 25.5437 7.56066 25.3249 7.34187C25.1061 7.12308 24.8093 7.00016 24.4999 7.00016Z"
                    fill="white"
                  />
                </svg> -->
              </span>
            </button>
          </div>
        </div>
      </div>

  <!-- Footer Start -->
  <div class="container-fluid bg-primary text-secondary p-5">
    <div class="row g-5">
        <div class="col-12 text-center">
            <h1 class="display-5 mb-4">Stay Update!!!</h1>
            <form class="mx-auto" style="max-width: 600px;">
                <div class="input-group">
                    <input type="text" class="form-control border-white p-3" placeholder="Your Email">
                    <button class="btn btn-dark px-4">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid bg-dark text-secondary p-5">
    <div class="row g-5">
        <div class="col-lg-3 col-md-6">
            <h3 class="text-white mb-4">Quick Links</h3>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog Post</a>
                <a class="text-secondary" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <h3 class="text-white mb-4">Popular Links</h3>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog Post</a>
                <a class="text-secondary" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <h3 class="text-white mb-4">Get In Touch</h3>
            <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>{{$siteinfo['address']}}</p>
            <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i>{{$siteinfo['email']}}</p>
            <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>{{$siteinfo['phone']}}</p>
        </div>
        <div class="col-lg-3 col-md-6">
            <h3 class="text-white mb-4">Follow Us</h3>
            <div class="d-flex">
                <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-2" href="{{$siteinfo['twiter']}}"><i class="fab fa-twitter fw-normal"></i></a>
                <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-2" href="{{$siteinfo['facebook']}}"><i class="fab fa-facebook-f fw-normal"></i></a>
                <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-2" href="{{$siteinfo['linkdin']}}"><i class="fab fa-linkedin-in fw-normal"></i></a>
                <a class="btn btn-lg btn-primary btn-lg-square rounded-circle" href="{{$siteinfo['instagram']}}"><i class="fab fa-instagram fw-normal"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid bg-dark text-secondary text-center border-top py-4 px-5" style="border-color: rgba(256, 256, 256, .1) !important;">
    <p class="m-0">&copy; <a class="text-secondary border-bottom" href="#">{{$siteinfo['name']}}</a>. {{$siteinfo['copyright']}}<a class="text-secondary border-bottom" href="{{$siteinfo['domain']}}"></a></p>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('frontend/lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('frontend/js/main.js') }}"></script>

<script>
    const formWrapper = document.querySelector(".formbold-form-wrapper");
    const formActionButton = document.querySelector(".formbold-action-btn");
    function chatboxToogleHandler() {
      formWrapper.classList.toggle("active");
      formActionButton.classList.toggle("active");
    }

  </script>

</html>
