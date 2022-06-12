<!-- css -->

<!-- js -->
<!-- jQuery -->
<script defer src="{{ asset('store') }}/js/jquery/jquery-2.2.4.min.js"></script>
<!-- JqueryUI -->
<script defer src="{{ asset('store') }}/js/jquery/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script defer src="{{ asset('store') }}/js/bootstrap/bootstrap.min.js"></script>
<!--magnific popup-->
<script defer src="{{ asset('store') }}/js/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- Jquery.counterup -->
<script defer src="{{ asset('store') }}/js/jquery.counterup/waypoints.min.js"></script>
<script defer src="{{ asset('store') }}/js/jquery.counterup/jquery.counterup.min.js"></script>
<!-- Owl-coursel -->
<script defer src="{{ asset('store') }}/js/owl-coursel/owl.carousel.min.js"></script>
<!-- Script -->
<script defer src="{{ asset('store') }}/js/script.js"></script>

<!-- GetButton.io widget -->
<script defer type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+51998178104", // WhatsApp number
            call: "+511 717-7027", // Call phone number
            call_to_action: "¡Contáctanos!", // Call to action
            button_color: "#E74339", // Color of button
            position: "right", // Position may be 'right' or 'left'
            order: "whatsapp,call", // Order of buttons
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->