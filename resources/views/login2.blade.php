<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Referral System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('resources/img/favicon1.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('resources/medilab/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('resources/medilab/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/medilab/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/medilab/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/medilab/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/medilab/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/medilab/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/medilab/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/medilab/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('resources/medilab/assets/css/style.css?version=7') }}" rel="stylesheet">

    <!-- Lobibox -->
    <link rel="stylesheet" href="{{ asset('resources/plugin/Lobibox/lobibox.css') }}">
</head>

<body>

<!-- ======= Top Bar ======= -->
<div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex justify-content-between">
        <div class="contact-info d-flex align-items-center">
            <i class="bi bi-envelope"></i> <a href="mailto:dohcvchd711it@gmail.com">dohcvchd711it@gmail.com</a>
            <i class="bi bi-phone"></i> (032)411-6900
        </div>
        <div class="d-none d-lg-flex social-links align-items-center">
            <a href="https://facebook.com/DOH7govph" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="https://twitter.com/DOH7govph" target="_blank" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
    </div>
</div>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto"><a href="{{ asset("/") }}"><img src="{{ asset('resources/img/doh.png') }}"> E-REFERRAL 7</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">Tutorial</a></li>
                <li><a class="nav-link scrollto" href="#services">Services</a></li>
                <li><a class="nav-link scrollto" href="#appointment">Appointment</a></li>
                <li class="dropdown"><a href="#"><span>Contact us</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a class="nav-link scrollto" href="#call_center">711 HealthLine</a></li>
                        <li><a class="nav-link scrollto" href="#system_error">System Error</a></li>
                        <li><a class="nav-link scrollto" href="#system_down">System Down</a></li>
                        <li><a class="nav-link scrollto" href="#training">Training</a></li>
                        <li><a class="nav-link scrollto" href="#register_account">Register Account</a></li>
                        <li><a class="nav-link scrollto" href="#non-technical">Non-technical</a></li>
                    </ul>
                </li>
                <li><a class="nav-link scrollto" href="#faq">FAQ</a></li>
                <li class="d-lg-none d-xl-block d-xl-block"><a class="nav-link scrollto" href="#testimonials">Testimonials</a></li>
                <li class="d-lg-none d-xl-block d-xl-block"><a class="nav-link scrollto" href="#gallery">Journey</a></li>
                <li><a class="nav-link scrollto" href="#feedback">Feedback</a></li>
                <li><a class="nav-link scrollto" href="#footer">Links</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->

<!-- ======= Header ======= -->
{{--<header id="header" class="fixed-top" style="background-color: #59ab91;">
    <div class="container d-flex align-items-center">
        <h1 class="logo me-auto d-xl-none"><a href="#"><img src="{{ asset('resources/img/doh.png') }}" style="width: 60px;"> E-REFERRAL REG 7</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar order-last order-lg-0">
          <ul>
            <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
            <li><a class="nav-link scrollto" href="#about">About</a></li>
            <li><a class="nav-link scrollto" href="#services">Services</a></li>
            <li><a class="nav-link scrollto" href="#departments">Departments</a></li>
            <li><a class="nav-link scrollto" href="#doctors">Doctors</a></li>
            <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="#">Drop Down 1</a></li>
                <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                  <ul>
                    <li><a href="#">Deep Drop Down 1</a></li>
                    <li><a href="#">Deep Drop Down 2</a></li>
                    <li><a href="#">Deep Drop Down 3</a></li>
                    <li><a href="#">Deep Drop Down 4</a></li>
                    <li><a href="#">Deep Drop Down 5</a></li>
                  </ul>
                </li>
                <li><a href="#">Drop Down 2</a></li>
                <li><a href="#">Drop Down 3</a></li>
                <li><a href="#">Drop Down 4</a></li>
              </ul>
            </li>
            <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->

        <!-- <a href="#appointment" class="appointment-btn scrollto"><span class="d-none d-md-inline">Make an</span> Appointment</a> -->
        <div class="container d-none d-xl-block">
            <img src="{{ asset('resources/img/referral_banner.png') }}" class="img-responsive">
        </div>
    </div>
</header>--}}<!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
    <div class="container" id="hero_content_modify">
        <h1>Welcome to E-REFERRAL</h1>
        <h2>It is an online and real-time web-based application</h2>
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-5 d-flex align-items-stretch">
                <div class="content" style="width: 100%">
                    {{--<a href="#about" class="btn-get-started scrollto">Get Started</a>--}}
                    <form role="form" method="POST" action="{{ asset('login') }}" class="form-submit">
                        {{ csrf_field() }}
                        <input type="hidden" name="login_type" value="{{ url()->current() == 'https://cvchd7.com/login' ? 'cloud' : 'doh' }}">
                        <input type="hidden" name="login_link" value="{{ url()->current() }}">
                        <div class="login-block" id="login_form_card">
                            <div class="{{ Session::has('error') ? ' has-error' : '' }}">
                                <input id="username" autocomplete="off" type="text" placeholder="Username" class="form-control" name="username" value="{{ Session::get('username') }}">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                                <span class="help-block">
                                @if(Session::has('error'))
                                        <strong class="text-danger">{{ Session::get('error') }}</strong><br><br>
                                    @endif
                            </span>
                                <button type="submit" class="btn-submit">Login</button>
                            </div>
                        </div>
                    </form>
                    {{--<div class="d-none d-lg-block d-xl-block">
                        <br><br>
                    </div>--}}
                </div>
            </div>
        </div>
        {{--<a href="#about" class="btn-get-started scrollto">Get Started</a>--}}
    </div>
</section><!-- End Hero -->

<main id="main">
    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us">
        <div class="container">

            <div class="row">
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="content">
                        <h3>Why Choose E-REFERRAL?</h3>
                        <ul>
                            <li>Expedite the referral from facility to facility</li>
                            <li>Lessen the number of times a patient is referred and transported back and forth from one facility to another</li>
                            <li>Real-time and paperless transaction with notification</li>
                            <li>If referral is not accepted within 30 minutes, the 711 agents will call the receiving facility for an update</li>
                        </ul>
                        <div class="text-center">
                            <a href="#" class="more-btn">Learn More <i class="bx bx-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="icon-boxes d-flex flex-column justify-content-center">
                        <div class="row">
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-3 mt-xl-0">
                                    <i class="bx bx-receipt"></i>
                                    <h4>PHA-CheckUp</h4>
                                    <p>Profiling of population</p>
                                </div>
                            </div>
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-3 mt-xl-0">
                                    <i class="bx bx-cube-alt"></i>
                                    <h4>711 DOH CVCHD HealthLine</h4>
                                    <p>A web based application for call center agent</p>
                                </div>
                            </div>
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-3 mt-xl-0">
                                    <i class="bx bx-images"></i>
                                    <h4>Bed Occupancy Status</h4>
                                    <p>Check the availability of beds in health facilities.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- End .content-->
                </div>
            </div>

        </div>
    </section><!-- End Why Us Section -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative">
                    <a href="https://www.youtube.com/watch?v=00zumdAGgNc" class="glightbox play-btn mb-4"></a>
                </div>
                <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    <h3 style="font-weight: bold" class="text-success">WHAT'S NEW?</h3>
                    <div class="">
                <span style="font-size:1.1em;">
                    <strong>Central Visayas Electronic Health Referral System(CVe-HRS) Version 6.7</strong><br>
                </span>
                    </div>
                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-fingerprint"></i></div>
                        <h4 class="title"><a href="">ICD-10 CODE</a></h4>
                        <p class="description">
                            A feature that allows the user to easily choose the patient's diagnosis for an accurate and uniform diagnosis.
                        </p>
                    </div>

                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-gift"></i></div>
                        <h4 class="title"><a href="">Reason for Referral</a></h4>
                        <p class="description">
                            A drop-down feature in Clinical Referral Form and in Pregnant Form, wherein the referring facility/ies can choose the reasons for Referral.
                        </p>
                    </div>

                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-atom"></i></div>
                        <h4 class="title"><a href="">File Attachment</a></h4>
                        <p class="description">
                            A new feature in Clinical Referral Form and in Pregnant Form that allows the user to attach documents or files of their patients.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="fas fa-user-md"></i>
                        <span data-purecounter-start="0" data-purecounter-end="3928" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Doctors</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                    <div class="count-box">
                        <i class="far fa-hospital"></i>
                        <span data-purecounter-start="0" data-purecounter-end="79" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Government Hospital</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="fas fa-flask"></i>
                        <span data-purecounter-start="0" data-purecounter-end="54" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Private Hospital</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="fas fa-award"></i>
                        <span data-purecounter-start="0" data-purecounter-end="177" data-purecounter-duration="1" class="purecounter"></span>
                        <p>RHU</p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Counts Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
        <div class="container">

            <div class="section-title">
                <h2>Services</h2>
                <p>PHA Check-Up as 2-way referral system</p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-heartbeat"></i></div>
                        <h4><a href="">Refer Patient</a></h4>
                        <p>Allows to refer a patient from one facility to another facility.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-pills"></i></div>
                        <h4><a href="">Accept Patient</a></h4>
                        <p>Allows to accept patient referrals from the referring facility.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-hospital-user"></i></div>
                        <h4><a href="">Arrive Patient</a></h4>
                        <p>Indication that the patient is arrived in the accepting facility</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-dna"></i></div>
                        <h4><a href="">Admit Patient</a></h4>
                        <p>Allows to admit the patient as soon as the patient has arrived in the accepting facility.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-wheelchair"></i></div>
                        <h4><a href="">Discharge Patient</a></h4>
                        <p>Allows to update the patient status whenever the patient is already recovered and discharged from the hospital.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-notes-medical"></i></div>
                        <h4><a href="">Transfer Patient</a></h4>
                        <p>Allows to Transfer a patient upon arrival in the accepting facility if the patient requested to be transferred to another facility.</p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Services Section -->

    <!-- ======= Appointment Section ======= -->
    <section id="appointment" class="appointment section-bg">
        <div class="container">
            <div class="section-title">
                <h2>Make an Appointment</h2>
                <p>
                    Connect with our DOH CV CHD Team to set up a <b><u>training request schedule</u></b>
                    or to address any <b><u>system issues and concerns</u></b> you may have.
                </p>
            </div>
            <form method="post" action="" class="appt_form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4 form-group">
                        <input type="text" name="name" class="form-control" id="pointment_name" placeholder="Your Name/Facility Name" required>
                    </div>
                    <div class="col-md-4 form-group mt-3 mt-md-0">
                        <input type="email" class="form-control" name="email" id="pointment_email" placeholder="Your Email" required>
                    </div>
                    <div class="col-md-4 form-group mt-3 mt-md-0">
                        <input type="tel" class="form-control" name="contact" id="pointment_phone" placeholder="Your Contact Number" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group mt-3">
                        <small>Preferred Date of Training:</small>
                        <?php $morrow = new DateTime('tomorrow'); $morrow = $morrow->format('Y-m-d');?>
                        <input type="date" name="date" id="pointment_date" class="form-control" min="{{ $morrow }}">
                        <small class="text-danger" id="warning_date">&emsp;Invalid Date!</small>
                    </div>
                    <div class="col-md-6 form-group mt-3">
                        <small>Category:</small>
                        <select name="category" id="pointment_category" class="form-select" required>
                            <option value="">Select...</option>
                            <option value="Training Request">Training Request</option>
                            <option value="System Issues/Concerns">System Issues/Concerns</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <textarea class="form-control" style="resize: none;" name="message" id="pointment_msg" rows="7" placeholder="Message" required></textarea>
                    <small class="text-danger" id="warning_pointment">
                        *Note: Please check if the entered information is correct before clicking submit button!</small><br>
                </div><br>
                <div class="text-center">
                    <button class="btn btn-success" type="submit" id="btn_appt">Make an Appointment </button>
                </div>
            </form>
        </div>
    </section><!-- End Appointment Section -->

    <!-- ======= Departments Section ======= -->
    <section id="departments" class="departments">
        <div class="container">

            <div class="section-title">
                <h2>Departments</h2>
                <p>Responsible for the maintenance and upkeep of an organization's buildings, ensuring that they meet legal requirements and health and safety standards. Facility managers (FMs) operate across different business functions, working on both a strategic and operational level.</p>
            </div>

            <div class="row gy-4">
                <div class="col-lg-3">
                    <ul class="nav nav-tabs flex-column">
                        <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">ER TRAUMA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-2">ER NON-TRAUMA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-3">ER OB</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-4">OPD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-5">ER PSYCHIATRY</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab-1">
                            <div class="row gy-4">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>ER TRAUMA</h3>
                                    <p class="fst-italic">treats a wider variety of ailments, ranging from non-life threatening injuries to potential heart attacks and strokes</p>
                                    <p>trauma center is equipped to handle the most serious of conditions such as car accident injuries, gunshot wounds, traumatic brain injuries, stab wounds, serious falls, and blunt trauma.</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="{{ asset('resources/medilab/assets/img/departments-1.jpg') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-2">
                            <div class="row gy-4">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>ER NON TRAUMA</h3>
                                    <p class="fst-italic">When a patient is in need of non-emergency assistance</p>
                                    <p>typically addresses broader, non-life threatening injuries such as broken bones, minor burns or injuries that may require stitches.</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="{{ asset('resources/medilab/assets/img/departments-2.jpg') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-3">
                            <div class="row gy-4">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>ER OB</h3>
                                    <p class="fst-italic">A branch of medicine that specializes in the care of women during pregnancy and childbirth and in the diagnosis and treatment of diseases of the female reproductive organs</p>
                                    <p>It also specializes in other women’s health issues, such as menopause, hormone problems, contraception (birth control), and infertility. Also called ob/gyn.</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="{{ asset('resources/medilab/assets/img/departments-4.jpg') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-4">
                            <div class="row gy-4">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>OPD</h3>
                                    <p class="fst-italic">The full form of OPD is the Outpatient Department. An OPD is structured to be the primary point of communication among the patient and the medical professionals in a medical department.</p>
                                    <p>A patient who first arrives at the hospital goes straight to OPD, and then the OPD decides the unit to which a patient will go.</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="{{ asset('resources/medilab/assets/img/departments-3.jpg') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-5">
                            <div class="row gy-4">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>ER PSYCHIATRY</h3>
                                    <p class="fst-italic">Emergency psychiatry is the clinical application of psychiatry in emergency settings.</p>
                                    <p>Conditions requiring psychiatric interventions may include attempted suicide, substance abuse, depression, psychosis, violence or other rapid changes in behavior.</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="{{ asset('resources/medilab/assets/img/departments-5.jpg') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Departments Section -->

    <section id="call_center" class="doctors">
        <div class="container">
            <center>
                <div class="col-lg-6 d-flex align-items-stretch">
                    <img src="{{ asset('resources/medilab/assets/img/contact/call_center.jpg') }}" alt class="img-fluid">
                </div>
            </center>
        </div>
    </section><!-- End Doctors Section -->

    <!-- ======= Doctors Section ======= -->
    <section id="system_error" class="doctors">
        <div class="container">
            <div class="section-title">
                <h2>System Error</h2>
                <p>Responsible for system development as well as troubleshooting and fixing concerns related to system usage</p>
            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/tayong_rusel.JPG') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Rusel T. Tayong</h4>
                            <span>Information System Analyst II</span>
                            <p>09238309990</p>
                            <div class="social">
                                <a href="https://twitter.com/DOH7govph" target="_blank"><i class="ri-twitter-fill"></i></a>
                                <a href="https://www.facebook.com/DOH7govph" target="_blank"><i class="ri-facebook-fill"></i></a>
                                <a href="#"><i class="ri-instagram-fill"></i></a>
                                <a href="#"> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/catubig.png') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Christine Anne I. Catubig</h4>
                            <span>Computer Programmer I</span>
                            <p>09226204186</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/maningo_fmj.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Flora May Joy Maningo</h4>
                            <span>Computer Programmer I</span>
                            <p>09171562951</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-lg-6 mt-4">
                  <div class="member d-flex align-items-start">
                    <div class="pic"><img src="assets/img/doctors/doctors-4.jpg" class="img-fluid" alt=""></div>
                    <div class="member-info">
                      <h4>Amanda Jepson</h4>
                      <span>Neurosurgeon</span>
                      <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
                      <div class="social">
                        <a href=""><i class="ri-twitter-fill"></i></a>
                        <a href=""><i class="ri-facebook-fill"></i></a>
                        <a href=""><i class="ri-instagram-fill"></i></a>
                        <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                      </div>
                    </div>
                  </div>
                </div> -->

            </div>

        </div>
    </section><!-- End Doctors Section -->


    <!-- ======= Doctors Section ======= -->
    <section id="system_down" class="doctors">
        <div class="container">

            <div class="section-title">
                <h2>Server - The request URL not found</h2>
                <p>Responsible to UP the server</p>
            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/gorosin.g.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Gerwin D. Gorosin</h4>
                            <span>Admin Assistant III</span>
                            <p>09436467174 or 09154512989</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/reyan.jpg') }}" class="img-fluid" alt="" style="width: 170px;"></div>
                        <div class="member-info">
                            <h4>Reyan M. Sugabo</h4>
                            <span>Computer Maintenance Technologist II</span>
                            <p>09359504269</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{--<div class="col-lg-6 mt-4">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/divina_h.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Harry John Divina</h4>
                            <span>Computer Maintenance Technogist I</span>
                            <p>09323633961 or 09158411553</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>--}}

                <!-- <div class="col-lg-6 mt-4">
                  <div class="member d-flex align-items-start">
                    <div class="pic"><img src="assets/img/doctors/doctors-4.jpg" class="img-fluid" alt=""></div>
                    <div class="member-info">
                      <h4>Amanda Jepson</h4>
                      <span>Neurosurgeon</span>
                      <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
                      <div class="social">
                        <a href=""><i class="ri-twitter-fill"></i></a>
                        <a href=""><i class="ri-facebook-fill"></i></a>
                        <a href=""><i class="ri-instagram-fill"></i></a>
                        <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                      </div>
                    </div>
                  </div>
                </div> -->

            </div>

        </div>
    </section><!-- End Doctors Section -->

    <section id="training" class="doctors">
        <div class="container">

            <div class="section-title">
                <h2>System Implementation / Training</h2>
                <p>Responsible for conducting and facilitating training and orientation for the effective implementation and sustainability of the electronic referral system of local health facilities within the Region 7 network. Perform other tasks such as observing and gathering data about implementation in order to support continuous improvement of the system.</p>
            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/sumalinog.r.jpg') }}" style="width: 140px;" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Rachel Sumalinog, LPT</h4>
                            <span>Computer Programmer II</span>
                            <p>09484693136</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/divina_h.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Harry John Divina</h4>
                            <span>Computer Maintenance Technologist I</span>
                            <p>09323633961 or 09158411553</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{--<div class="col-lg-6 mt-4">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/ermac_a.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Ann Ermac</h4>
                            <span>Planning Officer II</span>
                            <p>09988449332</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>--}}

                <!-- <div class="col-lg-6 mt-4">
                  <div class="member d-flex align-items-start">
                    <div class="pic"><img src="assets/img/doctors/doctors-4.jpg" class="img-fluid" alt=""></div>
                    <div class="member-info">
                      <h4>Amanda Jepson</h4>
                      <span>Neurosurgeon</span>
                      <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
                      <div class="social">
                        <a href=""><i class="ri-twitter-fill"></i></a>
                        <a href=""><i class="ri-facebook-fill"></i></a>
                        <a href=""><i class="ri-instagram-fill"></i></a>
                        <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                      </div>
                    </div>
                  </div>
                </div> -->

            </div>

        </div>
    </section><!-- End Doctors Section -->

    <section id="register_account" class="doctors">
        <div class="container">

            <div class="section-title">
                <h2>Register Account and Forget Password</h2>
                <p>Responsible in creating, updating and recovering your account and any technical related concern in accessing our E Referral system.</p>
            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/jaypee_pic.png') }}" style="width: 160px;" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Jaypee Dingal</h4>
                            <span>Data Encoder I</span>
                            <p>09267313376</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/remwel_pic.png') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Remwel Sanchez</h4>
                            <span>Data Encoder I</span>
                            <p>09067334425</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/anora2.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Mechelle Añora</h4>
                            <span>Data Encoder I</span>
                            <p>09912043267</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{--<div class="col-lg-6 mt-4">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/realmark_pic.png') }}" style="width: 165px;" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Real Mark Sabuero</h4>
                            <span>Data Encoder I</span>
                            <p>09058277663</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>--}}

            </div>

        </div>
    </section><!-- End Doctors Section -->

    <section id="non-technical" class="doctors">
        <div class="container">

            <div class="section-title">
                <h2>Non - Technical</h2>
                <p>Responsible for Memorandum Policy</p>
            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/blanco_s.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Dr. Shelbay G. Blanco</h4>
                            <span>Medical Officer IV</span>
                            <p>HEMS Cluster Head</p>
                            <p>DRRM-H manager</p>
                            <p>09451576004</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/omus.n.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Dr. Nelner D. Omus</h4>
                            <span>Medical Officer IV</span>
                            <p>09175748119</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/raagas_j.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Jane Michelle E. Raagas, RN, MAN</h4>
                            <span>Development Management Officer IV</span>
                            <p>09173100611</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4">
                  <div class="member d-flex align-items-start">
                    <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/ermac_a.jpg') }}" class="img-fluid" alt=""></div>
                    <div class="member-info">
                      <h4>Ann S. Ermac</h4>
                      <span>Planning Officer III</span>
                      <p>09773344909</p>
                      <div class="social">
                        <a href=""><i class="ri-twitter-fill"></i></a>
                        <a href=""><i class="ri-facebook-fill"></i></a>
                        <a href=""><i class="ri-instagram-fill"></i></a>
                        <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6 mt-4">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/Liporada, Patrick.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Patrick Liporada</h4>
                            <span>Senior Health Program Officer</span>
                            <p>09231586707</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="{{ asset('resources/medilab/assets/img/contact/theo.png') }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Theofanis P. Carpiso, Jr.</h4>
                            <span>Nurse II</span>
                            <p>09193460060</p>
                            <div class="social">
                                <a href=""><i class="ri-twitter-fill"></i></a>
                                <a href=""><i class="ri-facebook-fill"></i></a>
                                <a href=""><i class="ri-instagram-fill"></i></a>
                                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Doctors Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
        <div class="container">

            <div class="section-title">
                <h2>Frequently Asked Questions! Need Help?</h2>
                <p>We've got you covered</p>
            </div>

            <div class="faq-list">
                <ul>
                    <li data-aos="fade-up">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">How can we request for user credentials in our Facility? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                            <p>
                                <b>For IT/ admin account:</b>  Please request your log-in credentials from any one of the 711 DOH CV CHD Health Line IT Tech Support Team via email or call.<br>
                                <b>For end-user accounts (i.e. Doctor, Nurse, Midwife, etc.):</b>  Please request your login credentials from your IT department or your respective CVeHRS Point Person.
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="100">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">Can we use user credentials in multiple accounts? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                Each user will be given a credential. Account sharing is <b>not permitted.</b><br>
                                <b class="text-danger">One user = One User </b>
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="200">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">How can a user reset a password? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                <b>For IT/ Admin Account:</b> To update account, send an email or call the 711 DOH CV CHD Health Line Tech Support Team. After setting up or updating your account, our Tech Support representative will contact you to provide an update on your reported issues.
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="300">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-4" class="collapsed">I want to update my account information. What do I do? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                <b>For end-user account (i.e., Doctor, Nurses, Midwives, etc.):</b> You may request the IT Department or Admin from your facility to update your password or account information.
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="400">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-5" class="collapsed">How can a user's account be deleted if he or she is no longer connected to the facility? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                We cannot delete, however your CVeHRS/ eReferral Admin can manage the status of each user's account by signing in to their Admin Account. Just simply click the <b>"Manage Users"</b> menu (users directory will displayed); input the user name on <b>search box</b> and click search button, once the name is displayed select username you wish to deactivate. Then go to <b>"status field"</b> and change to <b>"Inactive"</b>  then click <b>"Update Button"</b>, for changes to take effect. The user will no longer be able to log in to his/ her account after deactivation.
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="400">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-6" class="collapsed">What is the best way for us to report issues or request user training? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-6" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                For any encountered issues or training requests, please email us at dohcvchd711it@gmail.com with the subject <b>"Reporting Issue"</b> or <b>"Letter of Intent"</b> (for training request). Once we receive the email, 711 DOH CV CHD Health Line representative will respond or contact you as soon as possible.
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="400">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-7" class="collapsed">Is there any app version for CVeHRS/ eReferral System? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-7" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                App is ongoing development. For now you can access via Google Chrome browser on you desktop, laptop , tablet and smartphone
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="400">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-8" class="collapsed">Can I refer my patient to two or more facilities at same time? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-8" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                In referring a patient to more than 1 facility take note that you cannot refer a patient to various facility unless you were being redirected once. After being redirected once you can go to your dashboard click "Referral" menu then click referred patients then choose the patient that was being redirected. Click” Redirected to other facility" then select facility and select department" then click redirected. Then click view more under the patient history then repeat the process and refer to another facility.
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="400">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-9" class="collapsed">Doctors credentials that connected to multiple facilities. <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-9" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                Doctor will require a user account for each facility where he or she is working to avoid system overwrite. However, while creating his or her user account, make a dash in the "last name" section of his or her user details <b>(e.g. Dela Cruz-GMPH).</b>
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="400">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-10" class="collapsed">Cannot Access the system. <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-10" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                Check if there are problem in logging in to the system or if other facility has the same concerns. If not check if the concerned facility has internet connection. Advise to restart their pc or their router. For “no internet connection” advise to call their facility IT or their internet provider to escalate their concerns about their internet.
                                If internet connection is not the problem still advice to restart their pc if problem still exist escalate the concern to the System Development Team to check if there are bugs or error in the system. Once the Development Team fixed the problem inform the facility to try to log in again if problem got resolve.
                            </p>
                        </div>
                    </li>

                </ul>
            </div>

        </div>
    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
        <div class="container">

            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonial-wrap">
                            <div class="testimonial-item">
                                <img src="{{ asset('resources/medilab/assets/img/testimonials/tagbilaran.jpg') }}" class="testimonial-img" alt="">
                                <h3>Tagbilaran City Health Office</h3>
                                <h4>RHU</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    What is good about the system in that it is great way to reduce the waiting time of the patient at the emergency unit and we will know who is the referring unit or who accepted the patient with their contact numbers and communicate with them for lacking information or updates, however because not all is computer literate and not all using the system yet, we still have to let patient bring the paper form just in case they need to be rushed to the emergency as soon possible so they can be entertained. Hopefully, everything will be paperless and the healthcare system will be better.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-wrap">
                            <div class="testimonial-item">
                                <img src="{{ asset('resources/medilab/assets/img/testimonials/gmph.jpg') }}" class="testimonial-img" alt="">
                                <h3>Garcia Memorial Provincial Hospital</h3>
                                <h4>Level 1</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    When I attended the launching of the E-Referral a few months back. I was skeptical as to the outcome. Well, am I glad to be proven wrong. There are already tangible improvements as far as inter hospital/local health units referrals is concern. Although we encountered issue & problems along the way. It doesn't in any way hamper our services, with more health units implementing the system, patients will definitely benefit from such. As proper, coordinated medical inyervention between health institutions is achieved, resulting to a better health outcome especially patients.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-wrap">
                            <div class="testimonial-item">
                                <img src="{{ asset('resources/medilab/assets/img/testimonials/gallares.jpg') }}" class="testimonial-img" alt="">
                                <h3>Gov. Celestino Gallares Memorial Hospital</h3>
                                <h4>Level 3</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    The E-Referral system had definitely leveled-up the patient transfer are being facilitated from one medical unit to another here in Bohol. For those patients transfer who have utilized this system, it has resulted in better coordination between healthcare workers and in better patient outcomes.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    {{--<div class="swiper-slide">
                        <div class="testimonial-wrap">
                            <div class="testimonial-item">
                                <img src="{{ asset('resources/medilab/assets/img/testimonials/testimonials-4.jpg') }}" class="testimonial-img" alt="">
                                <h3>Matt Brandon</h3>
                                <h4>Freelancer</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-wrap">
                            <div class="testimonial-item">
                                <img src="{{ asset('resources/medilab/assets/img/testimonials/testimonials-5.jpg') }}" class="testimonial-img" alt="">
                                <h3>John Larson</h3>
                                <h4>Entrepreneur</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->--}}

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
        <div class="container">

            <div class="section-title">
                <h2>Our Journey</h2>
                <p>The Department of Health Central Visayas Center for Health Development (DOH CVCHD) conducts training, orientations, and meetings to create a safe environment by emphasizing precautions, safety, and welfare of everyone.</p>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row g-0">

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('resources/medilab/assets/img/training/gallery1.jpg') }}" class="galelry-lightbox">
                            <img src="{{ asset('resources/medilab/assets/img/training/gallery1.jpg') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('resources/medilab/assets/img/training/gallery2.jpg') }}" class="galelry-lightbox">
                            <img src="{{ asset('resources/medilab/assets/img/training/gallery2.jpg') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('resources/medilab/assets/img/training/gallery3.jpg') }}" class="galelry-lightbox">
                            <img src="{{ asset('resources/medilab/assets/img/training/gallery3.jpg') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('resources/medilab/assets/img/training/gallery4.jpg') }}" class="galelry-lightbox">
                            <img src="{{ asset('resources/medilab/assets/img/training/gallery4.jpg') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('resources/medilab/assets/img/training/launch1.jpg') }}" class="galelry-lightbox">
                            <img src="{{ asset('resources/medilab/assets/img/training/launch1.jpg') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('resources/medilab/assets/img/training/launch2.jpg') }}" class="galelry-lightbox">
                            <img src="{{ asset('resources/medilab/assets/img/training/launch2.jpg') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('resources/medilab/assets/img/training/launch3.jpg') }}" class="galelry-lightbox">
                            <img src="{{ asset('resources/medilab/assets/img/training/launch3.jpg') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('resources/medilab/assets/img/training/launch4.jpg') }}" class="galelry-lightbox">
                            <img src="{{ asset('resources/medilab/assets/img/training/launch4.jpg') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Gallery Section -->

    <!-- ======= Contact Section ======= -->
    <section id="feedback" class="contact">
        <div class="container">

            <div class="section-title">
                <h2>Feedback</h2>
                <p>We'd love your feedback!</p>
            </div>
        </div>

        <div>
            <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.4253709207023!2d123.89121421531463!3d10.307801970485654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a99951d8484415%3A0x5a8b6d8d8565633d!2sDepartment%20of%20Health%20Region%207!5e0!3m2!1sen!2sph!4v1654753116007!5m2!1sen!2sph" frameborder="0" allowfullscreen></iframe>
        </div>

        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-4">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Location:</h4>
                            <p>8V5V+496, Osmeña Blvd, Cebu City, Cebu</p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p>dohcvchd711it@gmail.com</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Call:</h4>
                            <p>(032)411-6900</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 mt-5 mt-lg-0">
                    <form action="" method="post" class="feedback_form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="feedback_name" placeholder="Your Name/Facility Name" required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="feedback_email" placeholder="Your Email" required>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="text" class="form-control" name="subject" id="feedback_subject" placeholder="Subject" required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="tel" class="form-control" name="contact" id="feedback_contact" placeholder="Your Contact Number" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <textarea style="resize: none;" class="form-control" id="feedback_msg" name="message" rows="5" placeholder="Message" required></textarea>
                        </div><br>
                        <div class="text-center">
                            <button class="btn btn-sm btn-primary" id="feedback_btn" type="submit">Send Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">

    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-contact">
                    <h3>E-REFERRAL</h3>
                    <p>
                        Osmeña Blvd <br>
                        Cebu City<br>
                        Philippines <br><br>
                        <strong>Phone:</strong> (032)411-6900<br>
                        <strong>Email:</strong> dohcvchd711it@gmail.com<br>
                    </p>
                </div>

                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ asset('public/manual/eReferral-Users-Manual-2nd-Edition_final.pdf') }}" target="_blank">E-REFERRAL Manual 2nd Edition</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ asset('public/manual/Users-Manual-2nd-Edition_final.pdf') }}" target="_blank">Users Manual 2nd Edition</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ asset('public/manual/POLICY-2022-13_final.pdf') }}" target="_blank">E-Referral Policy Memo</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ asset('public/manual/E-Referral-Management.docx') }}">E-Referral Management</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ asset('public/manual/Service-Request-Form.docx') }}">E-Referral Service Request</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ asset('public/manual/NDCA-CVeHRS-healthcare-facility.doc') }}">NDCA CVeHRS Healthcare Facility</a></li>
                    </ul>
                </div>

                {{--<div class="col-lg-4 col-md-6 footer-newsletter">
                    <h4>Join Our Newsletter</h4>
                    <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                    <form action="" method="post">
                        <input type="email" name="email"><input type="submit" value="Subscribe">
                    </form>
                </div>--}}

            </div>
        </div>
    </div>

    <div class="container d-md-flex py-4">

        <div class="me-md-auto text-center text-md-start">
            <div class="copyright">
                &copy; Copyright <strong><span>DOH CVCHD</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/ -->
                Designed by <a href="#">DOH 7-ICTU</a>
            </div>
        </div>
        <div class="social-links text-center text-md-right pt-3 pt-md-0">
            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>
    </div>
</footer><!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('resources/medilab/assets/vendor/purecounter/purecounter.js') }}"></script>
<script src="{{ asset('resources/medilab/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('resources/medilab/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('resources/medilab/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('resources/medilab/assets/vendor/php-email-form/validate.js') }}"></script>

<!-- jQuery 2.1.4 -->
<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('resources/medilab/assets/js/main.js') }}"></script>


<script src="{{ asset('resources/assets/js/jquery.form.min.js') }}"></script>
<script src="{{ asset('resources/plugin/Lobibox/Lobibox.js') }}?v=2"></script>

<script>
    console.log('path: ' + window.location.origin);
    $('#warning_date').hide();
    $('.btn-submit').on('click',function() {
        console.log("asdasdasd");
        $(this).html('<i class="fa fa-spinner fa-spin"></i> Validating...');
    });

    $('#pointment_date').on('change', function() {
       var val = $(this).val();
       if(val <= new Date().toISOString().slice(0, 10)) {
           $('#warning_date').show();
           $('#btn_appt').prop('disabled', true);
       }
       else {
           $('#warning_date').hide();
           $('#btn_appt').prop('disabled', false);
       }
    });

    $('#pointment_category').on('change', function (e) {
        var val = $(this).val();
        if(val === 'Training Request') {
            $('#pointment_date').attr('required', true);
        } else {
            $('#pointment_date').attr('required', false);
        }
    });

    $('.appt_form').on('submit', function(e) {
        e.preventDefault();
        $('#btn_appt').attr('disabled',true);
        $('#btn_appt').html('<i class="fa fa-spinner fa-spin"></i> Sending...');
        $(this).ajaxSubmit({
            url: "{{ asset('appointment/create') }}",
            type: 'POST',
            success: function(result){
                console.log(result);
                console.log("created appointment successfully!");
                $('#pointment_name').val('');
                $('#pointment_email').val('');
                $('#pointment_phone').val('');
                $('#pointment_category').val('');
                $('#pointment_msg').val('');
                $('#pointment_date').val('');
                $('#btn_appt').attr('disabled',false);
                $('#btn_appt').html('Make an Appointment');
                Lobibox.notify('success', {
                    title: 'Appointment request sent successfully!',
                    img: '{{ asset('resources/img/doh.png') }}',
                    msg: ""
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Status: " + textStatus); console.log("Error: " + errorThrown);
            }
        });
    });

    $('.feedback_form').on('submit', function(e) {
        e.preventDefault();
        $('#feedback_btn').attr('disabled',true);
        $('#feedback_btn').html('<i class="fa fa-spinner fa-spin"></i> Sending...');
        $(this).ajaxSubmit({
            url: "{{ asset('user_feedback/create') }}",
            type: 'POST',
            success: function(){
                console.log("sent feedback successfully!");
                $('#feedback_name').val('');
                $('#feedback_email').val('');
                $('#feedback_subject').val('');
                $('#feedback_msg').val('');
                $('#feedback_contact').val('');
                $('#feedback_btn').attr('disabled',false);
                $('#feedback_btn').html('Send Feedback');
                Lobibox.notify('success', {
                    title: 'Feedback successfully sent!',
                    img: '{{ asset('resources/img/doh.png') }}'
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Status: " + textStatus); console.log("Error: " + errorThrown);
            }
        });
    });
</script>

</body>

</html>