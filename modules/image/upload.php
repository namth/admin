<div class="container_12">      
    <!-- Dashboard icons -->
    <div class="prefix_2 grid_8 suffix_2">
    <?php if(!empty($messages)) echo $messages; ?> 
    	<form id="upload" method="post" action="index.php?mod=image&act=process_upload" enctype="multipart/form-data">
			<div id="drop">
				Drop Here<br/>

				<a>Browse</a>
				<input type="file" name="thumbnail" />
			</div>

			<ul>
				<!-- The file uploads will be shown here -->
			</ul>

		</form>
        
        
    <div style="clear: both"></div>
    </div> <!-- End .grid_12 -->
    
    <div style="clear:both;"></div>



</div> <!-- End .container_12 -->

<!-- JavaScript Includes -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/jquery.knob.js"></script>

<!-- jQuery File Upload Dependencies -->
<script src="js/jquery.ui.widget.js"></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/jquery.fileupload.js"></script>

<!-- Our main JS file -->
<script src="js/script.js"></script>
