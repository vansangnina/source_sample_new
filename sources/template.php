<?php
    $http = get_http();

    $d->reset();
    $d->query("select thumb_$lang from #_photo where type='favicon'");
    $favicon = $d->fetch_array();

    $d->reset();
    $d->query("select noidung_$lang as noidung from #_company where type='footer'  limit 0,1");
    $footer = $d->fetch_array();

    if($_SESSION['loginuser']){
        $d->reset();
        $d->query("select ten from #_thanhvien where id='".$_SESSION['loginuser']['id']."'");
        $info_user = $d->fetch_array();
    }
    
    $d->reset();
    $d->query("select photo_$lang from #_photo where type='logo'");
    $logo = $d->fetch_array();

    $d->reset();
    $d->query("select photo_vi,link from #_photo where type='bocongthuong' and hienthi=1");
    $bct = $d->fetch_array();

    $d->reset();
    $d->query("select photo_$lang from #_photo where type='bgbanner' and hienthi=1");
    $bgbanner = $d->fetch_array();

    $d->reset();
    $d->query("select photo_$lang from #_photo where type='banner'");
    $banner = $d->fetch_array();

    $d->reset();
    $d->query("select photo_$lang,link from #_photo where type='bgfooter'");
    $bgfooter = $d->fetch_array();

    $d->reset();
    $d->query("select ten_$lang as ten,id,url,photo from #_lkweb where hienthi=1 and type='mxh' order by id asc");
    $mxh = $d->result_array();

    $d->reset();
    $d->query("select ten_$lang as ten,tenkhongdau from #_product_list where  type='product' and hienthi=1 order by stt,id desc");
    $list = $d->result_array();


    $d->reset();
    $d->query("select ten_$lang as ten,tenkhongdau from #_baiviet where type='chinhsach' and noibat=1 and hienthi=1 order by stt,id desc limit 6");
    $chinhsach = $d->result_array();

?>