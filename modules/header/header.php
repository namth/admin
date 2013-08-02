<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo $title; ?></title>
        <!-- CSS Reset -->
		<link rel="stylesheet" type="text/css" href="<?php echo $sitepathadmin; ?>css/reset.css" media="screen" />
        <!-- Fluid 960 Grid System - CSS framework -->
		<link rel="stylesheet" type="text/css" href="<?php echo $sitepathadmin; ?>css/grid.css" media="screen" />
        <!-- IE Hacks for the Fluid 960 Grid System -->
        <!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" /><![endif]-->
        <!-- Main stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo $sitepathadmin; ?>css/styles.css" media="screen" />
        <!-- WYSIWYG editor stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo $sitepathadmin; ?>css/jquery.wysiwyg.css" media="screen" />
        <!-- Upload stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo $sitepathadmin; ?>css/upload.css" media="screen" />
        <!-- List sorter stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo $sitepathadmin; ?>css/list_style.css" media="screen" />
        <!-- Table sorter stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo $sitepathadmin; ?>css/tablesorter.css" media="screen" />
        <!-- Thickbox stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo $sitepathadmin; ?>css/thickbox.css" media="screen" />
        <!-- Themes. Below are several color themes. Uncomment the line of your choice to switch to different color. All styles commented out means blue theme. -->
        <link rel="stylesheet" type="text/css" href="<?php echo $sitepathadmin; ?>css/theme-blue.css" tppabs="http://www.xooom.pl/work/magicadmin/css/theme-blue.css" media="screen" />
        <!--<link rel="stylesheet" type="text/css" href="css/theme-red.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="css/theme-yellow.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="css/theme-green.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="css/theme-graphite.css" media="screen" />-->
		<!-- JQuery engine script-->
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>-->
        <script type="text/javascript" src="<?php echo $sitepathadmin; ?>js/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="<?php echo $sitepathadmin; ?>js/jquery-1.7.2-ui.js"></script>
        <!-- JQuery tablesorter plugin script-->
		<script type="text/javascript" src="<?php echo $sitepathadmin; ?>js/jquery.tablesorter.min.js"></script>
		<!-- JQuery pager plugin script for tablesorter tables -->
		<script type="text/javascript" src="<?php echo $sitepathadmin; ?>js/jquery.tablesorter.pager.js"></script>
		<!-- JQuery password strength plugin script -->
		<script type="text/javascript" src="<?php echo $sitepathadmin; ?>js/jquery.pstrength-min.1.2.js"></script>
		<!-- JQuery thickbox plugin script -->
		<script type="text/javascript" src="<?php echo $sitepathadmin; ?>js/thickbox.js"></script>
        <!-- TinyMCE script -->
        <script type="text/javascript" src="<?php echo $sitepathadmin; ?>js/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript">
        tinymce.init({
			// General options
            mode : "textareas",
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false

         });
        </script>
        <!-- Initiate menulist Sorter script -->
        <script type="text/javascript">
        $(document).ready(function(){ 	
        	  function slideout(){
                  setTimeout(function(){
                  $("#response").slideUp("slow", function(){});
              }, 5000);}
        	
              $("#response").hide();
        	$(function() {
        	$("ul.list_box").sortable({ opacity: 0.8, cursor: 'move', update: function() {
        			
        			var order = $(this).sortable("serialize") + '&update=update'; 
        			$.post("<?php echo $sitepath; ?>admin/modules/menu/update_list.php", order, function(theResponse){
        				$("#response").html(theResponse);
        				$("#response").slideDown('slow');
        				slideout();
        			}); 															 
        		}								  
        		});
        	});	
        });	
        </script>
        <!-- Initiate tablesorter script -->
        <script type="text/javascript">
			$(document).ready(function() { 
				$("#myTable") 
				.tablesorter({
					// zebra coloring
					widgets: ['zebra'],
					// pass the headers argument and assing a object 
					headers: { 
						// assign the sixth column (we start counting zero) 
						6: { 
							// disable it by setting the property sorter to false 
							sorter: false 
						} 
					}
				}) 
			.tablesorterPager({container: $("#pager")}); 
		}); 
		</script>
        
        <!-- Initiate password strength script -->
		<script type="text/javascript">
			$(function() {
			$('.password').pstrength();
			});
        </script>
        <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="js/global.js"></script>
        <link rel="stylesheet" type="text/css" href="css/list_style.css" media="screen" />
        
	</head>
	<body style="cursor: auto;">
    	<!-- Header -->
        <div id="header">
            <!-- Header. Status part -->
            <div id="header-status">
                <div class="container_12">
                    <div class="grid_8">
					&nbsp;
                    </div>
                    <div class="grid_4">
                        <a href="index.php?mod=member&act=logout" id="logout">
                        Logout
                        </a>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End #header-status -->
            
            <!-- Header. Main part -->
            <div id="header-main">
            
                <div class="container_12">
                    <div class="grid_12">
                        <div id="logo">
                            <ul id="nav">
                            
                             <?php if($_SESSION['ok']==1){?>
                            <?php
							$str_sub_mod1 = "select level from tbl_link where  permalink like '".$module."%'";
							$rs_sub_mod1 = mysql_query($str_sub_mod1);
							$ro_sub_mod1 = mysql_fetch_array($rs_sub_mod1);
							
							$rs_mod = mysql_query("select  t2.id, t2.permalink, t2.name from tbl_permision t1, tbl_link t2 where t2.id = t1.modules_id and t2.level=0 and t1.group_user_id =".$_SESSION['idgu']);
							while($ro_module = mysql_fetch_array($rs_mod)){
							?>
								<li <?php if($module==$ro_module['permalink'] || $ro_module['id'] == $ro_sub_mod1['level']) echo "id='current'"?>><a href="index.php?mod=<?php echo $ro_module['permalink'];?>"><?php echo $ro_module['name']?></a></li>
							<?php
							}
							 }
							?>
                            </ul>
                        </div><!-- End. #Logo -->
                    </div><!-- End. .grid_12-->
                    <div style="clear: both;"></div>
                </div><!-- End. .container_12 -->
            </div> <!-- End #header-main -->
            <div style="clear: both;"></div>
            <!-- Sub navigation -->
            <div id="subnav">
                <div class="container_12">
                    <div class="grid_12">
                        <ul>
                        
                        <?php
						if($_SESSION['ok']==1){
						$str_sub_mod = "select t2.id, t2.permalink, t2.name, t2.level from tbl_permision t1, tbl_link t2 where t2.id = t1.modules_id  and t1.group_user_id =".$_SESSION['idgu']. " and t2.level = (select id from tbl_link where level = 0 and permalink = '".$module."' limit 1) group by(name)";	
						
						$rs_sub_mod = mysql_query($str_sub_mod);
						while($ro_sub_mod = mysql_fetch_array($rs_sub_mod)){
							
							?>
						<li><a href="index.php?mod=<?php echo $ro_sub_mod['permalink']?>"><?php echo $ro_sub_mod['name']?></a></li>						
							<?php	
						}

						if($module == 'image'){
                            $q = "SELECT id, name FROM tbl_link WHERE type='image' AND level=0";
                            $r = mysql_query($q);
                            while($links = mysql_fetch_array($r)){  
                        ?>
                            <li><a href="index.php?mod=image&lid=<?php echo $links['id']; ?>"><?php echo $links['name']; ?></a></li>
                        <?php
                            }}?>
                            
						<?php
						
						
						if($ro_sub_mod1['level'] != 0){
							$str_sub_mod2 = "select t2.id, t2.permalink, t2.name, t2.level from tbl_permision t1, tbl_link t2 where t2.id = t1.modules_id  and t1.group_user_id =".$_SESSION['idgu']. " and t2.level = ".$ro_sub_mod1['level']." group by(name)";
							//echo $str_sub_mod2;
							$rs_sub_mod2 = mysql_query($str_sub_mod2);
							while($ro_sub_mod2 = mysql_fetch_array($rs_sub_mod2)){
								
							?>
                            
							<li><a href="index.php?mod=<?php echo $ro_sub_mod2['permalink']?>"><?php echo $ro_sub_mod2['name']; ?></a></li>
							<?php
							}
						}
						}
                        ?>
                        </ul>
                        
                    </div><!-- End. .grid_12-->               
                  </div><!-- End. .container_12 -->
                <div style="clear: both;"></div>
            </div> <!-- End #subnav -->
        </div> <!-- End #header -->