
	<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
	<script src="<?= base_url() ?>assets/js/wow.min.js"></script>
	<script src="<?= base_url() ?>assets/js/jquery-1.12.4.javascript"></script>
	<script src="<?= base_url() ?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>

    
    

	<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7Qr6pzgwcITCpA0c0yf6o65Vr8swqvp8&libraries=places&callback=initAutocomplete"
        async defer></script>
	<script type="text/javascript">
		new WOW().init();
	</script>
	<script type="text/javascript">
		new WOW().init();

		/* NAVIGATION BAR */
			$(window).scroll(function() {
				 if($(this).scrollTop()>0) {
					  $( ".admin-header" ).addClass("nav-new");
				  } else {
				      $( ".admin-header" ).removeClass("nav-new");
				 }
			});

			/* NAVIGATION BAR */
			$(window).scroll(function() {
				 if($(this).scrollTop()>0) {
					  $( ".navbar-default" ).addClass("nav-new-res");
				  } else {
				      $( ".navbar-default" ).removeClass("nav-new-res");
				 }
			});


		 /*$(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });
            $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });

           	$('#example').dataTable({
			        "columnDefs": [{
			        "targets": 'no-sort',
			        "orderable": false,
			    }]
			});
        });*/
$('#example').dataTable({
			        "columnDefs": [{
			        "targets": 'no-sort',
			        "orderable": false,
			    }]
			});
	</script>
<script type="text/javascript">
$(window).load(function() {
$(".loader").fadeOut("slow");
});
setTimeout(function(){
    $('.alert').remove();
}, 5000)
</script>
</body>
</html>