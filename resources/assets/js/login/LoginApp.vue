<template>
    <link :href="font_google" rel="stylesheet">
    <link :href="font_awesome" rel="stylesheet">
    <link :href="animate_css" rel="stylesheet">
    <link :href="bootstrap_css" rel="stylesheet">
    <link :href="bootstrap_icon_css" rel="stylesheet">
    <link :href="boxicons_css" rel="stylesheet">
    <link :href="glightbox_css" rel="stylesheet">
    <link :href="remixicon_css" rel="stylesheet">
    <link :href="swiper_css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link :href="style_css" rel="stylesheet">

    <!-- Lobibox -->
    <link rel="stylesheet" :href="lobibox_css">

    <div id="preloader"></div>

    <body v-show="on_mounted">

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

        <header id="header" class="fixed-top">
            <div class="container d-flex align-items-center">
                <h1 class="logo me-auto"><a href=""><img :src="doh_logo"> E-REFERRAL 7</a></h1>
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
                </nav>
            </div>
        </header>

        <section id="hero" class="d-flex align-items-center">
            <div class="container" id="hero_content_modify">
                <h1>Welcome to E-REFERRAL</h1>
                <h2>It is an online and real-time web-based application</h2>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-lg-5 d-flex align-items-stretch">
                        <div class="content" style="width: 100%">
                            <credentials></credentials>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main id="main">
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
                                            <h4>Telemedicine</h4>
                                            <p>Allows patients to connect with healthcare professionals via video calls, phone calls.</p>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End .content-->
                        </div>
                    </div>
                </div>
            </section>

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
                                <div class="icon"><i class="bx bxl-android"></i></div>
                                <h4 class="title"><a href="">Telemedicine Mobile App for Android Version 1.0.0</a></h4>
                                <p class="description">
                                    Introducing our brand new Android app, designed to provide seamless access to healthcare services. With this app, patients can now have video consultations with healthcare professionals, and securely access their medical records, all from the convenience of their Android devices. Stay connected with your healthcare team and receive the care you need, anytime and anywhere.
                                    
                                    <br><br>This app is your dedicated healthcare companion, designed to make your health journey smoother and more efficient. Say goodbye to long waiting times and hello to healthcare on your terms.

                                    <strong class="text-primary"><a href="#">Click here to download and experience healthcare reinvented!</a></strong>
                                </p>
                            </div>

                            <div class="icon-box">
                                <div class="icon"><i class="bx bxl-apple"></i></div>
                                <h4 class="title"><a href="">Telemedicine iOS App Version 1.0.0</a></h4>
                                <p class="description">
                                    We are excited to announce the release of our iOS app, bringing telemedicine to your Apple devices. The Telemedicine iOS App offers a user-friendly interface, enabling patients to consult with healthcare professionals through high-quality video calls,and securely manage their health information. Experience the future of healthcare at your fingertips with our iOS app.
                                    
                                    <br><br>This app is not just about convenience; it's about a new era of healthcare that prioritizes your needs and empowers you to make informed decisions.

                                    <strong class="text-primary"><a href="#">Click here to download and embrace the future of healthcare!</a></strong>
                                </p>
                            </div>

                            <!-- <div class="icon-box">
                                <div class="icon"><i class="bx bx-fingerprint"></i></div>
                                <h4 class="title"><a href="">ICD-10 CODE</a></h4>
                                <p class="description">
                                    Our ICD-10 CODE feature is a powerful tool designed to enhance the accuracy and uniformity of patient diagnoses. With this feature, healthcare professionals can easily access and select the appropriate ICD-10 code for a patient's medical condition. This not only streamlines the diagnostic process but also ensures that medical records are consistently coded, making it easier for healthcare providers to track and manage patient health. Improve the precision of your diagnoses with our ICD-10 CODE feature.
                                </p>
                            </div> -->

                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-merge"></i></div>
                                <h4 class="title"><a href="">E-referral and Telemedicine Integration</a></h4>
                                <p class="description">
                                    Our E-referral and Telemedicine Integration feature revolutionizes the way healthcare is accessed and coordinated. This innovative integration allows healthcare providers to seamlessly refer patients to specialists or telemedicine services within the same platform. Patients can now receive specialized care. This streamlined process not only improves patient convenience but also enhances the continuity of care, ensuring that medical information is securely shared between providers. Experience a more connected and efficient healthcare ecosystem with our E-referral and Telemedicine Integration.
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
                                <span data-purecounter-start="0" :data-purecounter-end="count_doctor" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Doctors</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                            <div class="count-box">
                                <i class="far fa-hospital"></i>
                                <span data-purecounter-start="0" :data-purecounter-end="count_gov_hosp" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Government Hospital</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                            <div class="count-box">
                                <i class="fas fa-flask"></i>
                                <span data-purecounter-start="0" :data-purecounter-end="count_private_hosp" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Private Hospital</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                            <div class="count-box">
                                <i class="fas fa-award"></i>
                                <span data-purecounter-start="0" :data-purecounter-end="count_rhu" data-purecounter-duration="1" class="purecounter"></span>
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
                        <p>PHA Check-Up as a two-way referral system</p>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                            <div class="icon-box">
                                <div class="icon"><i class="fas fa-heartbeat"></i></div>
                                <h4><a href="">Refer Patient</a></h4>
                                <p>Allows to refer a patient from one facility to another.</p>
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
                                <p>Indication that the patient has arrived in the accepting facility.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                            <div class="icon-box">
                                <div class="icon"><i class="fas fa-dna"></i></div>
                                <h4><a href="">Admit Patient</a></h4>
                                <p>Allows to admit the patient as soon as the patient arrives in the accepting facility.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                            <div class="icon-box">
                                <div class="icon"><i class="fas fa-wheelchair"></i></div>
                                <h4><a href="">Discharge Patient</a></h4>
                                <p>Allows to update the patient status when the patient has already recovered and discharged from the hospital.</p>
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

            <appointment></appointment>

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
                                            <p class="fst-italic">Treats a wider variety of ailments, ranging from non-life threatening injuries to potential heart attacks and strokes</p>
                                            <p>Trauma center is equipped to handle the most serious of conditions such as car accident injuries, gunshot wounds, traumatic brain injuries, stab wounds, serious falls, and blunt trauma.</p>
                                        </div>
                                        <div class="col-lg-4 text-center order-1 order-lg-2">
                                            <img :src="department1" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-2">
                                    <div class="row gy-4">
                                        <div class="col-lg-8 details order-2 order-lg-1">
                                            <h3>ER NON TRAUMA</h3>
                                            <p class="fst-italic">When a patient is in need of non-emergency assistance</p>
                                            <p>Typically addresses broader, non-life threatening injuries such as broken bones, minor burns or injuries that may require stitches.</p>
                                        </div>
                                        <div class="col-lg-4 text-center order-1 order-lg-2">
                                            <img :src="department2" alt="" class="img-fluid">
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
                                            <img :src="department4" alt="" class="img-fluid">
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
                                            <img :src="department3" alt="" class="img-fluid">
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
                                            <img :src="department5" alt="" class="img-fluid">
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
                    <div class="col-lg-6 d-flex align-items-stretch center">
                        <img :src="call_center" alt class="img-fluid">
                    </div>
                </div>
            </section>

            <!-- ======= System Development ======= -->
            <section id="system_error" class="doctors">
                <div class="container">
                    <div class="section-title">
                        <h2>System Error</h2>
                        <p>Responsible for system development as well as troubleshooting and fixing concerns related to system usage</p>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="member d-flex align-items-start">
                                <div class="pic"><img :src="rtayong" class="img-fluid" alt=""></div>
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
                                <div class="pic"><img :src="JGonzales" class="img-fluid" alt=""></div>
                                <div class="member-info">
                                    <h4>Jondy D. Gonzales</h4>
                                    <span>Computer Programmer I</span>
                                    <p>09917382477</p>
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
                                <div class="pic"><img :src="fmaningo" class="img-fluid" alt=""></div>
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
                    </div>
                </div>
            </section><!-- End System Development -->

            <!-- ======= System Down ======= -->
            <section id="system_down" class="doctors">
                <div class="container">
                    <div class="section-title">
                        <h2>Server - The request URL not found</h2>
                        <p>Responsible to UP the server</p>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="member d-flex align-items-start">
                                <div class="pic"><img :src="ggorosin" class="img-fluid" alt=""></div>
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

                        <!--<div class="col-lg-6 mt-4 mt-lg-0">-->
                        <!--<div class="member d-flex align-items-start">-->
                        <!--<div class="pic"><img :src="rsugabo" class="img-fluid" alt="" style="width: 170px;"></div>-->
                        <!--<div class="member-info">-->
                        <!--<h4>Reyan M. Sugabo</h4>-->
                        <!--<span>Computer Maintenance Technologist II</span>-->
                        <!--<p>09359504269</p>-->
                        <!--<div class="social">-->
                        <!--<a href=""><i class="ri-twitter-fill"></i></a>-->
                        <!--<a href=""><i class="ri-facebook-fill"></i></a>-->
                        <!--<a href=""><i class="ri-instagram-fill"></i></a>-->
                        <!--<a href=""> <i class="ri-linkedin-box-fill"></i> </a>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                    </div>
                </div>
            </section><!-- End System Down -->

            <!-- ======= Training/Implementation ======= -->
            <section id="training" class="doctors">
                <div class="container">
                    <div class="section-title">
                        <h2>System Implementation / Training</h2>
                        <p>Responsible for conducting and facilitating training and orientation for the effective implementation and sustainability of the electronic referral system of local health facilities within the Region 7 network. Perform other tasks such as observing and gathering data about implementation in order to support continuous improvement of the system.</p>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="member d-flex align-items-start">
                                <div class="pic"><img :src="rsumalinog" style="width: 140px;" class="img-fluid" alt=""></div>
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
                                <div class="pic"><img :src="hdivina" class="img-fluid" alt=""></div>
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
                    </div>
                </div>
            </section><!-- End Training/Implementation -->

            <!-- ======= Register Account/Forgot Password ======= -->
            <section id="register_account" class="doctors">
                <div class="container">
                    <div class="section-title">
                        <h2>Register Account and Forget Password</h2>
                        <p>Responsible in creating, updating and recovering your account and any technical related concern in accessing our E Referral system.</p>
                    </div>

                    <div class="row">
                        <!--<div class="col-lg-6">-->
                        <!--<div class="member d-flex align-items-start">-->
                        <!--<div class="pic"><img :src="jdingal" style="width: 160px;" class="img-fluid" alt=""></div>-->
                        <!--<div class="member-info">-->
                        <!--<h4>Jaypee Dingal</h4>-->
                        <!--<span>Data Encoder I</span>-->
                        <!--<p>09267313376</p>-->
                        <!--<div class="social">-->
                        <!--<a href=""><i class="ri-twitter-fill"></i></a>-->
                        <!--<a href=""><i class="ri-facebook-fill"></i></a>-->
                        <!--<a href=""><i class="ri-instagram-fill"></i></a>-->
                        <!--<a href=""> <i class="ri-linkedin-box-fill"></i> </a>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->

                        <div class="col-lg-6 mt-4 mt-lg-0">
                            <div class="member d-flex align-items-start">
                                <div class="pic"><img :src="rsanchez" class="img-fluid" alt=""></div>
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

                        <!--<div class="col-lg-6 mt-4">-->
                        <!--<div class="member d-flex align-items-start">-->
                        <!--<div class="pic"><img :src="manora" class="img-fluid" alt=""></div>-->
                        <!--<div class="member-info">-->
                        <!--<h4>Mechelle Añora</h4>-->
                        <!--<span>Data Encoder I</span>-->
                        <!--<p>09912043267</p>-->
                        <!--<div class="social">-->
                        <!--<a href=""><i class="ri-twitter-fill"></i></a>-->
                        <!--<a href=""><i class="ri-facebook-fill"></i></a>-->
                        <!--<a href=""><i class="ri-instagram-fill"></i></a>-->
                        <!--<a href=""> <i class="ri-linkedin-box-fill"></i> </a>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                    </div>
                </div>
            </section><!-- End Register Account/Forgot Password -->

            <!-- ======= Non-Technical ======= -->
            <section id="non-technical" class="doctors">
                <div class="container">
                    <div class="section-title">
                        <h2>Non - Technical</h2>
                        <p>Responsible for Memorandum Policy</p>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="member d-flex align-items-start">
                                <div class="pic"><img :src="sblanco" class="img-fluid" alt=""></div>
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
                                <div class="pic"><img :src="nomus" class="img-fluid" alt=""></div>
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
                                <div class="pic"><img :src="jraagas" class="img-fluid" alt=""></div>
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
                                <div class="pic"><img :src="aermac" class="img-fluid" alt=""></div>
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
                                <div class="pic"><img :src="pliporada" class="img-fluid" alt=""></div>
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
                                <div class="pic"><img :src="tcarpiso" class="img-fluid" alt=""></div>
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
            </section><!-- End Non-Technical -->

            <!-- ======= Frequently Asked Questions Section ======= -->
            <section id="faq" class="faq section-bg">
                <div class="container">
                    <div class="section-title">
                        <h2>Frequently Asked Questions! Need Help?</h2>
                        <p>We've got you covered!</p>
                    </div>

                    <div class="faq-list">
                        <ul>
                            <li data-aos="fade-up">
                                <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">How can we request for user credentials of our Facility? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                                <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                                    <p>
                                        <b>For IT/ admin account:</b>  Please request for your log-in credentials from any of the 711 DOH CV CHD Health Line IT Tech Support Team via email or call.<br>
                                        <b>For end-user accounts (i.e. Doctor, Nurse, Midwife, etc.):</b>  Please request for your login credentials from your IT department or your respective CVeHRS Point Person.
                                    </p>
                                </div>
                            </li>

                            <li data-aos="fade-up" data-aos-delay="100">
                                <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">Can we use the same user credentials in multiple accounts? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                                <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                                    <p>
                                        Each user will be given a credential. Account sharing is <b>not permitted.</b><br>
                                        <b class="text-danger">One user = One User Credential </b>
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
                                        We cannot delete user accounts, however your CVeHRS/ eReferral Admin can manage the status of each user's account by signing in to their Admin Account. Just simply click the <b>"Manage Users"</b> menu (users directory will be displayed); input the user name on the <b>search box</b> and click search button, once the name is displayed select the username you wish to deactivate. Then go to <b>"status field"</b> and change status to <b>"Inactive"</b>. Click <b>"Update Button"</b> for changes to take effect. The user will no longer be able to log in to his/ her account after deactivation.
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
                                        App is ongoing development. For now you can access via Google Chrome browser on your desktop, laptop, tablet and smartphones.
                                    </p>
                                </div>
                            </li>

                            <li data-aos="fade-up" data-aos-delay="400">
                                <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-8" class="collapsed">Can I refer my patient to two or more facilities at the same time? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                                <div id="faq-list-8" class="collapse" data-bs-parent=".faq-list">
                                    <p>
                                        In referring a patient to more than one facility take note that you cannot refer a patient to various facilities unless patient is redirected at least once. After being redirected once, you can go to your dashboard click "Referral" menu, click referred patients then choose the patient that was being redirected. Click” Redirect to other facility" then select facility and select department" then click redirected. Then click view more under the patient history then repeat the process and refer to another facility.
                                    </p>
                                </div>
                            </li>

                            <li data-aos="fade-up" data-aos-delay="400">
                                <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-9" class="collapsed">Doctors credentials that are connected to multiple facilities. <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                                <div id="faq-list-9" class="collapse" data-bs-parent=".faq-list">
                                    <p>
                                        Doctors will require a user account for each facility where he or she is working to avoid system overwrite. However, while creating his or her user account, make a dash in the "last name" section of his or her user details <b>(e.g. Dela Cruz-GMPH).</b>
                                    </p>
                                </div>
                            </li>

                            <li data-aos="fade-up" data-aos-delay="400">
                                <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-10" class="collapsed">Cannot Access the system. <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                                <div id="faq-list-10" class="collapse" data-bs-parent=".faq-list">
                                    <p>
                                        Check if there are problems in logging in to the system or if other facilities have the same concerns. If not, check if the concerned facility has internet connection. Advise to restart their pc or their router. For “no internet connection” advise to call their facility IT or their internet provider to escalate their concerns about their internet.
                                        If internet connection is not the problem, advise to restart their pc, if the problem still exists, escalate the concern to the System Development Team to check if there are bugs or error in the system. Once the Development Team fixes the problem inform the facility to try to log in again once problem was resolved.
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
                                        <img :src="testimony_tagbilaran" class="testimonial-img" alt="">
                                        <h3>Tagbilaran City Health Office</h3>
                                        <h4>RHU</h4>
                                        <p>
                                            <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                            What is good about the system in that it is great way to reduce the waiting time of the patient at the emergency unit and we will know who is the referring unit or who accepted the patient with their contact numbers and communicate with them for lacking information or updates, however because not all is computer literate and not all using the system yet, we still have to let patient bring the paper form just in case they need to be rushed to the emergency as soon possible so they can be entertained. Hopefully, everything will be paperless and the healthcare system will be better.
                                            <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="testimonial-wrap">
                                    <div class="testimonial-item">
                                        <img :src="testimony_gmph" class="testimonial-img" alt="">
                                        <h3>Garcia Memorial Provincial Hospital</h3>
                                        <h4>Level 1</h4>
                                        <p>
                                            <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                            When I attended the launching of the E-Referral a few months back. I was skeptical as to the outcome. Well, am I glad to be proven wrong. There are already tangible improvements as far as inter hospital/local health units referrals is concern. Although we encountered issue & problems along the way. It doesn't in any way hamper our services, with more health units implementing the system, patients will definitely benefit from such. As proper, coordinated medical inyervention between health institutions is achieved, resulting to a better health outcome especially patients.
                                            <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="testimonial-wrap">
                                    <div class="testimonial-item">
                                        <img :src="testimony_gallares" class="testimonial-img" alt="">
                                        <h3>Gov. Celestino Gallares Memorial Hospital</h3>
                                        <h4>Level 3</h4>
                                        <p>
                                            <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                            The E-Referral system had definitely leveled-up the patient transfer are being facilitated from one medical unit to another here in Bohol. For those patients transfer who have utilized this system, it has resulted in better coordination between healthcare workers and in better patient outcomes.
                                            <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
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
                                <a :href="gallery1" class="galelry-lightbox">
                                    <img :src="gallery1" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4">
                            <div class="gallery-item">
                                <a :href="gallery2" class="galelry-lightbox">
                                    <img :src="gallery2" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4">
                            <div class="gallery-item">
                                <a :href="gallery3" class="galelry-lightbox">
                                    <img :src="gallery3" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4">
                            <div class="gallery-item">
                                <a :href="gallery4" class="galelry-lightbox">
                                    <img :src="gallery4" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4">
                            <div class="gallery-item">
                                <a :href="launch1" class="galelry-lightbox">
                                    <img :src="launch1" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4">
                            <div class="gallery-item">
                                <a :href="launch2" class="galelry-lightbox">
                                    <img :src="launch2" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4">
                            <div class="gallery-item">
                                <a :href="launch3" class="galelry-lightbox">
                                    <img :src="launch3" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4">
                            <div class="gallery-item">
                                <a :href="launch4" class="galelry-lightbox">
                                    <img :src="launch4" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </section><!-- End Gallery Section -->

            <!-- ======= Feedback Section ======= -->
            <section id="feedback" class="contact">
                <div class="container">
                    <div class="section-title">
                        <h2>Feedback</h2>
                        <p>We'd love your feedback!</p>
                    </div>
                </div>

                <div v-if="showIframe">
                    <iframe
                        style="border: 0; width: 100%; height: 350px;"
                        :src="iframeSrc"
                        frameborder="0"
                        allowfullscreen
                    ></iframe>
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
                            <feedback></feedback>
                        </div>
                    </div>
                </div>
            </section><!-- End Feedback Section -->
        </main>

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
                                <li><i class="bx bx-chevron-right"></i> <a :href="eref_manual" target="_blank">E-REFERRAL Manual 2nd Edition</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a :href="user_manual" target="_blank">Users Manual 2nd Edition</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a :href="policy_memo" target="_blank">E-Referral Policy Memo</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a :href="eref_management">E-Referral Management</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Useful Links</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a :href="request_form">E-Referral Service Request</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a :href="ndca">NDCA CVeHRS Healthcare Facility</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container d-md-flex py-4">

                <div class="me-md-auto text-center text-md-start">
                    <div class="copyright">
                        &copy; Copyright <strong><span>DOH CVCHD</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
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
    </body>
</template>

<script>
    import Credentials from './Credentials.vue'
    import Appointment from './Appointment.vue'
    import Feedback from './UserFeedback.vue'
    import { loadScript } from "vue-plugin-load-script";
    import $ from "jquery";
    window.$ = window.jQuery = $;

    let path = $("#login_root_url").val();
    /*let path = window.location.origin;
    if(path === 'https://site.test' || path === 'http://site.test') {
        path += '/referral';
    }*/

    export default  {
        name: 'LoginApp',
        components : {
            'credentials': Credentials,
            'appointment': Appointment,
            'feedback': Feedback
        },
        data() {
            return {
                font_google: "https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i",
                font_awesome: path + "resources/medilab/assets/vendor/fontawesome-free/css/all.min.css",
                animate_css: path + "resources/medilab/assets/vendor/animate.css/animate.min.css",
                bootstrap_css: path + "resources/medilab/assets/vendor/bootstrap/css/bootstrap.min.css",
                bootstrap_icon_css: path + "resources/medilab/assets/vendor/bootstrap-icons/bootstrap-icons.css",
                boxicons_css: path + "resources/medilab/assets/vendor/boxicons/css/boxicons.min.css",
                glightbox_css: path + "resources/medilab/assets/vendor/glightbox/css/glightbox.min.css",
                remixicon_css: path + "resources/medilab/assets/vendor/remixicon/remixicon.css",
                swiper_css: path + "resources/medilab/assets/vendor/swiper/swiper-bundle.min.css",
                style_css: path + "resources/medilab/assets/css/style.css?version=7",
                lobibox_css: path + "resources/plugin/Lobibox/lobibox.css",

                doh_logo: path + "/resources/img/doh.png",
                call_center: path + "/resources/medilab/assets/img/contact/call_center.jpg",
                rtayong: path + "/resources/medilab/assets/img/contact/tayong_rusel.JPG",
                ccatubig: path + "/resources/medilab/assets/img/contact/catubig.png",
                JGonzales: path + "/resources/medilab/assets/img/contact/JGonzales.png",
                fmaningo: path + "/resources/medilab/assets/img/contact/maningo_fmj.png",
                ggorosin: path + "/resources/medilab/assets/img/contact/gorosin.g.jpg",
                rsugabo: path + "/resources/medilab/assets/img/contact/reyan.jpg",
                rsumalinog: path + "/resources/medilab/assets/img/contact/sumalinog.r.jpg",
                hdivina: path + "/resources/medilab/assets/img/contact/divina_h.png",
                jdingal: path + "/resources/medilab/assets/img/contact/jaypee_pic.png",
                rsanchez: path + "/resources/medilab/assets/img/contact/remwel_pic.png",
                manora: path + "/resources/medilab/assets/img/contact/anora2.jpg",
                sblanco: path + "/resources/medilab/assets/img/contact/blanco_s.jpg",
                nomus: path + "/resources/medilab/assets/img/contact/omus.n.jpg",
                jraagas: path + "/resources/medilab/assets/img/contact/raagas_j.jpg",
                aermac: path + "/resources/medilab/assets/img/contact/ermac_a.jpg",
                pliporada: path + "/resources/medilab/assets/img/contact/Liporada, Patrick.jpg",
                tcarpiso: path + "/resources/medilab/assets/img/contact/theo.png",
                testimony_tagbilaran: path + "/resources/medilab/assets/img/testimonials/tagbilaran.jpg",
                testimony_gmph: path + "/resources/medilab/assets/img/testimonials/gmph.jpg",
                testimony_gallares: path + '/resources/medilab/assets/img/testimonials/gallares.jpg',
                department1: path + '/resources/medilab/assets/img/departments-1.jpg',
                department2: path + '/resources/medilab/assets/img/departments-2.jpg',
                department3: path + '/resources/medilab/assets/img/departments-3.jpg',
                department4: path + '/resources/medilab/assets/img/departments-4.jpg',
                department5: path + '/resources/medilab/assets/img/departments-5.jpg',
                gallery1: path + '/resources/medilab/assets/img/training/gallery1.jpg',
                gallery2: path + '/resources/medilab/assets/img/training/gallery2.jpg',
                gallery3: path + '/resources/medilab/assets/img/training/gallery3.jpg',
                gallery4: path + '/resources/medilab/assets/img/training/gallery4.jpg',
                launch1: path + '/resources/medilab/assets/img/training/launch1.jpg',
                launch2: path + '/resources/medilab/assets/img/training/launch2.jpg',
                launch3: path + '/resources/medilab/assets/img/training/launch3.jpg',
                launch4: path + '/resources/medilab/assets/img/training/launch4.jpg',
                eref_manual: path + '/public/manual/eReferral-Users-Manual-2nd-Edition_final.pdf',
                user_manual: path + '/public/manual/Users-Manual-2nd-Edition_final.pdf',
                policy_memo: path + '/public/manual/POLICY-2022-13_final.pdf',
                eref_management: path + '/public/manual/E-Referral-Management.docx',
                request_form: path + '/public/manual/Service-Request-Form.docx',
                ndca: path + '/public/manual/NDCA-CVeHRS-healthcare-facility.doc',
                count_doctor: 0,
                count_gov_hosp: 0,
                count_private_hosp: 0,
                count_rhu: 0,
                on_mounted: false,
                showIframe: false,
                iframeSrc: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.4253709207023!2d123.89121421531463!3d10.307801970485654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a99951d8484415%3A0x5a8b6d8d8565633d!2sDepartment%20of%20Health%20Region%207!5e0!3m2!1sen!2sph!4v1654753116007!5m2!1sen!2sph"
            }
        },
        mounted() {
            (async () => {
                await loadScript(path+"/resources/medilab/assets/vendor/glightbox/js/glightbox.min.js")
                    .then(() => {
                        console.log("loaded: glightbox")
                    })
                    .catch(() => {
                        console.log("not loaded (glightbox)");
                    });
                await loadScript(path+"/resources/medilab/assets/vendor/swiper/swiper-bundle.min.js")
                    .then(() => {
                        console.log("loaded: swiper")
                    })
                    .catch(() => {
                        console.log("not loaded (swiper");
                    });
                await loadScript(path+"/resources/medilab/assets/vendor/bootstrap/js/bootstrap.bundle.min.js")
                    .then(() => {
                        console.log("loaded: boostrap bundle")
                    })
                    .catch(() => {
                        console.log("not loaded (boostrap bundle)");
                    });
                await loadScript(path+"/resources/medilab/assets/vendor/purecounter/purecounter.js")
                    .then(() => {
                        console.log("loaded: purecounter")
                    })
                    .catch(() => {
                        console.log("not loaded (purecounter)");
                    });
                await loadScript(path+"/resources/medilab/assets/js/main.js")
                    .then(() => {
                        console.log("loaded: main.js")
                    })
                    .catch(() => {
                        console.log("not loaded (main.js)");
                    });
            })();
            window.addEventListener('load', () => {
                this.on_mounted = true;
                // Load Template Main JS Files
                const formScript = document.createElement('script');
                formScript.src = path + 'resources/assets/js/jquery.form.min.js';
                document.head.appendChild(formScript);

                const lobiboxScript = document.createElement('script');
                lobiboxScript.src = path + 'resources/plugin/Lobibox/Lobibox.js?v=2';
                document.head.appendChild(lobiboxScript);

                this.showIframe = true;
            });
        },
        created() {
            this.count();
        },
        methods: {
            count() {
                axios.get('login/countUsers').then(response => {
                    this.count_doctor = response.data.doctor;
                    this.count_gov_hosp = response.data.government;
                    this.count_private_hosp = response.data.private;
                    this.count_rhu = response.data.rhu;
                })
            }
        }
    }
</script>

<style>
    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
</style>