<?php
	$report = $_GET['rp']?$_GET['rp']:"";
	if($report == 1)
		$messages = report($report, "Bạn đã thoát khỏi hệ thống. nếu muốn vào tiếp xin vui lòng đăng nhập lại");
	else if($report == 2)
		$messages = report($report, "Sai tên đăng nhập hoặc mật khẩu.vui lòng đăng nhập lại");
	else if($report == 3)
		$messages = report($report, "Tài khoản của bạn chưa được kích hoạt. Vui lòng liên hệ với quản trị để  kích hoạt lại");
?>

<div class="container_12">
<?php if(!empty($messages)) echo $messages;?>
    <div class="prefix_3 grid_6 suffix_3">
        <div class="module">
             <h2><span>Đăng nhập</span></h2>
             <div class="module-body">
                <form method="post" action="index.php?mod=member&act=process_login" class="login"> 
                    
                    <fieldset>
                    <p>
                        <label>Tên đăng nhập</label>
                        <input class="input-medium" type="text" name="username" />
                    </p>
                    <p>
                        <label>Mật khẩu</label>
                        <input type="password" class="input-medium" name="password"/>
                    </p>
                    <p>
                        <label><input type="checkbox"/> nhớ mật khẩu</label>
                    </p>

                        <input class="submit-green" type="submit" value="Đăng nhập" name="submit"/> 
                    </fieldset>
                </form>
                
                <ul>
                    <li><a href="">Quên mật khẩu?</a></li>
                    <!--li><a href="">Đăng ký</a></li-->
                </ul>
                
             </div> <!-- End .module-body -->
        </div> <!-- End .module -->
    </div> <!-- End .grid_6 -->
    <div class="clear"></div>
</div>