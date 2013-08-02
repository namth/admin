function check_form_news(){
    var check = true;
    //title
    titleid = document.getElementById("title");
	if(frm_news.post_title.value == ""){
		titleid.innerHTML = "<span class=\"notification-input ni-error\">Tiêu đề tin tức không được để trống.</span>";
		check = false;
	}
    //category
    var check_cat = false;
    var contents, vals = [], p_contents =  document.forms['frm_news']['catID[]'];
    for(var i=0,elm;elm = p_contents[i];i++) {
        if(elm.checked) {
            check_cat = true;   
        }
    }
    catid = document.getElementById("cat_new");
    if(check_cat == false){
    	catid.innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa chọn danh mục tin tức</span>";
    }
    
    return (check&&check_cat);
    
    }