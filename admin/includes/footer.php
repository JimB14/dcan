<!--=======  footer  =================================-->
<footer id="footer">
    <div class="bg-footer">
        <div class="container wow fadeInUp">
            <div class="row">
                <div class="grid_5">
                    <a style="display:inline;padding-right:10px;" href="http://www.bbb.org/north-east-florida/business-reviews/elderly-senior-specialty-services/dedicated-care-always-near-by-in-jacksonville-fl-235966548" target="_blank" title="BBB review"><img src="images/bbb_162x312.png" width="50" height="100" alt="Better Business Bureau A+"></a>                               
                        <a  style="display:inline;" href="https://www.napw.com/users/cindy-brown-36" target="_blank" title="NAPW"><img src="images/napw_portrait.jpg" width="78" height="103"></a>
                        <!--<span class="lg">DCAN</span><br><br>-->
                        <!--<span class="dcan_logo_footer"><img src="images/logo_300x112.png" alt="DCAN logo"></span> -->                  
                </div>
                <div class="grid_3">
                    <h3>contact us</h3>
                    <p><a href="tel:9046077935"><img style="padding-top:3px;" src="images/glyphicons-443-earphone.png" width="12" height="12"><span> 904-607-7935</span></a></p>
                    <p><img style="padding-top:2px;" src="images/glyphicons-16-print.png" width="12" height="12"> 904-647-6652</p>
                    <p class="ind-top"> <a href="mailto:info@dcan.us?Subject=Website%20Inquiry"><img style="padding-top:5px;" src="images/glyphicons-11-envelope.png" width="12" height="8"> info@dcan.us</a></p>
                    <p class="ind-top"><a href="contact.php#contact_form"><img src="images/glyphicons-31-pencil.png" width="12" height="12"> contact form</a></p>

                </div>
                <div class="grid_4">
                    <div class="loc">
                        <h3>location</h3>
                        <p>2318 Park St <br> Jacksonville, FL 32204</p>
                        <p><a href="contact.php#find_us" class="ind-top p1"><img src="images/current-location-45x55.png" width="16" height="16"> Google map</a></p>                      
                    </div>
                </div>
            </div>

        </div><!-- // .container -->       
    </div><!-- // .bg-footer -->
</footer>
<!-- ================  Addendum  ========================-->
<div id="addendum" class="bg-addendum text-center">
    <div class="container">
        <div class="row">
            <div class="grid_12">
                <div class="copyright">
                    &copy; 2010 - <?php echo htmlspecialchars(date('Y')); ?> All Rights Reserved &nbsp;
                    <br>                   
                    &nbsp;<a href="code-of-ethics.php">Code of Ethics</a>
                    | &nbsp;<a href="testimonials.php">Testimonials</a>
                    | &nbsp;<a href="privacy.php#content">Privacy Policy</a>
                </div>               
            </div>
        </div><!-- // .row -->

        <div id="social-bar" class="row">
            <div class="grid_12">
                <ul class="social-network social-circle">
                    <!--<li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>-->
                    <!--<li><a href="#"  target="_blank" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>-->
                    <li><a href="https://twitter.com/dcancindy"  target="_blank" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                    <!--<li><a href="#" class="icoGoogle"  target="_blank" title="Google +"><i class="fa fa-google-plus"></i></a></li>-->
                    <li><a href="https://www.linkedin.com/in/cindy-brown-5b78654" class="icoLinkedin"  target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div><!-- // .row -->

        <div class="row">
            <div class="grid_12">
                <p class="wmp">Web development by <a href="http://www.webmediapartners.com" target="_blank" rel="follow">Web Media Partners</a></p>
            </div>
        </div>
    </div><!--  // .container -->
</div><!-- // .bg-addendum -->
<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
            navigation: true,
            pagination: false,
            items: 4,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [979, 3],
            itemsTablet: [767, 2],
            itemsTabletSmall: [479, 1],
            itemsMobile: [320, 1]
        });
    });
</script>
</body>
</html>