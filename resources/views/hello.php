<html>

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $siteName; ?></title>
    <meta name="Nova theme" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" href="assets/css/responsive.css"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

    <meta property="og:title" content="<?php echo $siteName; ?> is a Wine-based container for Windows applications"/>
    <meta property="og:url" content="<?php echo $siteUrl; ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="<?php echo $siteUrl; ?>/assets/images/screenshot.png"/>

</head>

<body>

<!-- Navigation
    ================================================== -->
<div class="hero-background">

    <div>
        <img class="strips" src="assets/images/strips.png">
    </div>

    <div class="container">
        <div class="header-container header">
            <a class="logo" alt="SonoBus" href="#">
                <img class="logo" src="assets/images/favicon.png"/>
                <span class="logo-text"><?php echo $siteName; ?></span>
            </a>

            <div class="header-right">
                <a class="navbar-item" href="#features">Features</a>
<!--                <a class="navbar-item" href="#tips">Tips</a>-->
                <a class="navbar-item" href="#download">Download</a>
            </div>

        </div>
        <!--navigation-->


        <!-- Hero-Section
          ================================================== -->

        <div class="row">
            <div class="hero-right  col-sm-4 ">
                <h3 class="header-headline">
                    Open Source software for play games on Linux
                </h3>
                <br>
                <div class="header-running-text light">
                    Wine Launcher is a container for Wine based Windows applications.
                </div>

                <!--
                <h3 class="header-headline">   &nbsp;</h3>

                 <h3 class="header-headline"> Multi-user, multi-platform, open-source, completely
                free.</h3>
                -->

                <!--
                <a href="#email-form">
                      <button class="hero-btn"> Download FREE!</button>
                  </a>
                -->

            </div><!--hero-left-->


            <div class="hero-right col-sm-8">
                <div class="header-running-text light">
                    <img class="img-responsive" src="/assets/images/screenshot.png"/>
                </div>

                <!--
                <h4 class="header-running-text light">

                </h4>
                -->
            </div>

            <!--
            <div><img class="mouse" src="assets/images/mouse.svg"/></div>
            -->
        </div><!--hero-->

        <?php /*
        <div class="hero row">
            <div class="hero-right  col-sm-4 ">
                <h3 class="header-headline">
                    Multi-user, multi-platform, open-source, completely free.
                </h3>
            </div><!--hero-left-->


            <div class="hero-right col-sm-8">

                <h4 class="header-running-text light">
                    &nbsp;
                </h4>

                <div class="header-running-text light">
                    Simply choose a unique group name (with optional
                    password), and instantly connect multiple people
                    together to make music, remote sessions, podcasts,
                    etc. Easily record the audio from everyone, as well as
                    playback any audio content to the whole group.
                </div>

                <!--
                <h4 class="header-running-text light">

                </h4>
                -->
            </div>

            <!--
            <div><img class="mouse" src="assets/images/mouse.svg"/></div>
            -->
        </div><!--hero-->
        */ ?>

    </div> <!--hero-container-->

</div><!--hero-background-->


<!-- Features
  ================================================== -->

<div id="features" class="features-section">

    <div class="features-container row">

        <h2 class="features-headline light">
            FEATURES
        </h2>

        <div class="col-sm-4 feature">

<!--            <div class="feature-icon feature-display ">-->
<!--                <img class="feature-img" src="assets/images/customizable.svg">-->
<!--            </div>-->

            <h4 class="feature-head-text feature-display"> SANDBOX </h4>
            <p class="feature-subtext light feature-display">
                Wine Launcher completely isolates the application from the system.
                A separate Wine and Prefix are used to run games.
            </p>
        </div>


        <div class="col-sm-4 feature">

<!--            <div class="feature-icon feature-display">-->
<!--                <img class="feature-img" src="assets/images/responsive.svg">-->
<!--            </div>-->

            <h4 class="feature-head-text feature-display">
                COMPRESSING
            </h4>
            <p class="feature-subtext light feature-display">
                The ability to compress Wine and Games into Squashfs images.
            </p>
        </div>

        <div class="col-sm-4 feature">

<!--            <div class="feature-icon feature-display">-->
<!--                <img class="bullet-img" src="assets/images/design.svg">-->
<!--            </div>-->

            <h4 class="feature-head-text feature-display">PATCHES</h4>
            <p class="feature-subtext light feature-display">
                Automatic generation of patches based on Prefix changes.
            </p>
        </div>
    </div> <!--features-container-->
</div> <!--features-section-->

<!-- Logos
  ================================================== -->


<!--<div class="logos-section">-->
<!--    <img class="logos" src="assets/images/logos.png"/>-->
<!--</div>-->


<!--logos-section-->


<!-- White-Section
  ================================================== -->

<?php /*
<div id="tips" class="white-section row">

    <h2 class="pricing-section-header light text-center">
        BEST PRACTICES
    </h2>

    <!-- <p><br> </p> -->

    <div class="col-sm-6">

        <div class="white-section-text">

            <div class="imac-section-desc">
                SonoBus does not use any echo cancellation, or automatic noise
                reduction in order to maintain the highest audio quality. As a
                result, if you have a live microphone signal you will need
                to also use headphones to prevent echos and/or feedback.
            </div>

        </div>
    </div>

    <div class="col-sm-6">

        <div class="white-section-text">

            <!--            <h2 class="imac-section-header light">SIMPLE AND BEAUTIFUL</h2>-->

            <div class="imac-section-desc">
                For best results, and to achieve the lowest latencies, connect your computer with wired
                ethernet to your router. Although it will work
                with WiFi, the added network jitter and packet loss will
                require you to use a bigger jitter buffer to maintain a
                quality audio signal, which results in higher latencies.
            </div>
        </div>
    </div>
</div>

<div class="white-section row">

    <div class="col-sm-6">

        <div class="white-section-text">

            <div class="imac-section-desc">
                SonoBus does NOT currently use any encryption for the data communication, so while it
                is very unlikely that it will be intercepted, please keep that in mind. All
                audio is sent directly between users peer-to-peer, the connection server is
                only used so that the users in a group can find each other.
            </div>

        </div>
    </div>

    <div class="col-sm-6">

        <div class="white-section-text">

            <div class="imac-section-desc">
                For getting started and lots of more detailed information please look at the SonoBus User Guide.
            </div>

            <div class="imac-section-desc">
                For tutorial videos check out our YouTube channel.
            </div>

        </div>
    </div>
</div>
 */ ?>

<!--white-section-text-section--->


<!-- Download
  ================================================== -->
<div id="download" class="pricing-background">

    <h2 class="pricing-section-header light text-center">DOWNLOAD</h2>

<!--    <h4 class=" pricing-section-sub text-center light">Choose your platform</h4>-->

    <div class="pricing-table row">

        <div class="col-sm-4"></div>

        <div class="col-sm-4">

            <div class="plan">
                <h3 class="plan-title light">LINUX</h3>
                <h5 class="monthly">Multiple Distributions via AppImage</h5>
                <ul class="plan-features">
                    <li>Standalone application</li>
                    <li>64bit only</li>
                </ul>
                <div class="plan-price-div text-center">
                    <div class="choose-plan-div">
                        <a class="plan-btn light" href="https://github.com/hitman249/wine-launcher/releases">
                            Download for Linux
                        </a>
                    </div>
                </div>
            </div><!--pro-plan--->

        </div><!--col-->

        <div class="col-sm-4"></div>

    </div>  <!--pricing-table-->

</div><!--pricing-background-->


<div id="features" class="features-section">

    <div class="features-container row">

        <?php /*
        <div class="col-sm-6 feature">

            <h4 class="feature-head-text feature-display"> SUPPORT </h4>
            <p class="feature-subtext light feature-display">
                We need your feedback! Please join the SonoBus Users group or send a message to support@sonobus.net
                and let us and the community know what you discover while
                using the software, and get answers to your questions.
            </p>
        </div>
         */ ?>

        <div class="col-sm-3 feature"></div>
        <div class="col-sm-6 feature">

            <h4 class="feature-head-text feature-display"> DONATE </h4>
            <p class="feature-subtext light feature-display">
                <?php echo $siteName; ?> is free software, but if you want to help support development, please consider making
                a monetary donation via DonationAlerts, thanks!
            </p>

            <div class="text-center">
                <a href="https://www.donationalerts.com/r/winelauncher" target="_blank">
                    <img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="">
                </a>
            </div>

        </div>
        <div class="col-sm-3 feature"></div>

    </div> <!--features-container-->
</div> <!--features-section-->


<!-- Team
  ================================================== -->


<!-- Footer
  ================================================== -->

<div class="footer">

    <div class="container">
        <div class="row">
            <!--            <div class="col-sm-2"></div>-->
            <div class="col-sm-3"></div>
            <div class="col-sm-6 webscope">
                <span class="webscope-text"> Copyright <?php echo date('Y'); ?> © <?php echo $siteName; ?> LLC</span>
            </div>
            <div class="col-sm-3"></div>

<!--            <div class="col-sm-2">-->
<!--                <span><a class="navbar-item" href="">Contact</a>  </span>-->
<!--            </div>-->

<!--            <div class="col-sm-2">-->
<!--                <div class="social-links">-->
<!---->
<!--                    <a href="">-->
<!--                        <img class="social-link" src="assets/images/twitter.svg"/>-->
<!--                    </a>-->
<!---->
<!--                    <a href="">-->
<!--                        <img src="assets/images/facebook.svg"/>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->

        </div>

    </div>
</div>

<!--footer-->

<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="></script>

<script src="assets/js/script.js"></script>

</body>
</html>

