		<br/>
		<br/>
		<footer class="footer navbar-fixed-bottom">
			<div class="colorpicker">
				<div class="colordiv blue" onclick="changecolor(0)"></div>
				<div class="colordiv black" onclick="changecolor(1)"></div>
				<div class="colordiv green" onclick="changecolor(2)"></div>
				<div class="colordiv yellow" onclick="changecolor(3)"></div>
			</div>
            <div class="container text-center">
                <p class="footersign" style="color: #ffffff">made by <b>David Varga</b> &amp; <b>David Szanto</b> | Bootstrap 3</p>
            </div>
        </footer>
		
		<!-- Bootstrap core JavaScript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
	    <script src="../js/jquery1.12.4.js"></script>	    
	    <script src="../js/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	    <script src="../js/bootbox.js" ></script>
	    <audio id="audio" src="../sound/alert.mp3" ></audio>
	   
	    <script>
		    alertcheck();
		    setInterval(function(){ alertcheck() }, 10000);		   
	    </script>
	    
	</body>
</html>
