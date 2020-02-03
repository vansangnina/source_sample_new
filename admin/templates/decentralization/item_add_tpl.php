<?php
	$d->reset();
	$sql = "select ten,id,ten_com,type,danhmuc,act from #_com order by id asc";
	$d->query($sql);
	$com = $d->result_array();

    $d->reset();
    $sql = "select id,ten_vi from #_product_list order by id desc";
    $d->query($sql);
    $row_list = $d->result_array();
?>

<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
            <li><a href="index.php?com=phanquyen&act=add<?php if($type!='') echo'&type='. $type;?>"><span>Thêm com</span></a></li>
            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>



<form name="frm"  class="form"  method="post" action="index.php?com=phanquyen&act=save" enctype="multipart/form-data" class="nhaplieu">
<div class="widget">
    <div class="formRow">
        <label>Quyền :</label>
        <div class="formRight">
            <input type="text" name="ten" value="<?=@$item['ten']?>" class="input" />
        </div>
        <div class="clear"></div>
    </div>
    
    <style>
        .chon_danhmuc select{ padding:5px; width:300px;}
        .tbl_per{width: 100%; font-size: 13px; background: #fff; border: 1px solid #eee; position: relative;}
        .tbl_per tr:nth-child(even) {background: #fafafa}
        .tbl_per tr:hover{background: #efefef;}
        .tbl_per div.checker{float: none; margin: auto;}
        .tbl_per thead{position: sticky;}
        .tbl_per thead th{padding: 15px 10px 15px 10px; font-size: 15px; background: #c02026; color: #fff; }
        .tbl_per td.name_per{text-align: left; font-size: 14px; font-weight: bold;}
        .tbl_per tbody td{padding: 15px 10px; border: 1px solid #eee;}
    </style>
    <div class="formRow">
        <label>Phân Quyền:</label>
        <div class="formRight">
            <table class="tbl_per">
                <thead>
                    <th>Danh mục</th>
                    <th width="10%">Xem</th>
                    <th width="10%">Thêm</th>
                    <th width="10%">Xóa</th>
                    <th width="10%">Sửa</th>
                </thead>
                <tbody>
                    

                    <tr>
                        <td class="name_per">Bài viết hướng dẫn mua hàng</td>
                        <td align="center" colspan="4">
                            <input name="permiss[]" type="checkbox" value="info__capnhat__muahang" <?=check_permission('info__capnhat__muahang',$item['permission'])?>>
                        </td>
                        
                        <input name="permiss[]" type="hidden" checked="checked" value="info__save__muahang">
                    </tr>
                    <tr>
                        <td class="name_per">Bài viết khuyến mãi</td>
                        <td align="center" colspan="4">
                            <input name="permiss[]" type="checkbox" value="info__capnhat__khuyenmai" <?=check_permission('info__capnhat__khuyenmai',$item['permission'])?>>
                        </td>
                        
                        <input name="permiss[]" type="hidden" checked="checked" value="info__save__khuyenmai">
                    </tr>
                    <tr>
                        <td class="name_per">Bài viết tích điểm</td>
                        <td align="center" colspan="4">
                            <input name="permiss[]" type="checkbox" value="info__capnhat__tichdiem" <?=check_permission('info__capnhat__tichdiem',$item['permission'])?>>
                        </td>
                        
                        <input name="permiss[]" type="hidden" checked="checked" value="info__save__tichdiem">
                    </tr>
                    


                    <!-- BEGIN: Product -->
                    <tr>
                        <td class="name_per">Danh mục sản phẩm cấp 1</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__man_list__product" <?=check_permission('product__man_list__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__add_list__product" <?=check_permission('product__add_list__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__delete_list__product" <?=check_permission('product__delete_list__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__edit_list__product" <?=check_permission('product__edit_list__product',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="product__save_list__product">
                    </tr>
                    <tr>
                        <td class="name_per">Danh mục sản phẩm cấp 2</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__man_cat__product" <?=check_permission('product__man_cat__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__add_cat__product" <?=check_permission('product__add_cat__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__delete_cat__product" <?=check_permission('product__delete_cat__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__edit_cat__product" <?=check_permission('product__edit_cat__product',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="product__save_cat__product">
                    </tr>
                    <tr>
                        <td class="name_per">Quản lý sản phẩm</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__man__product" <?=check_permission('product__man__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__add__product" <?=check_permission('product__add__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__delete__product" <?=check_permission('product__delete__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__edit__product" <?=check_permission('product__edit__product',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="product__save__product">
                    </tr>
                    <tr>
                        <td class="name_per">Thêm thuộc tích cho sản phẩm vừa thêm</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__man_properties__product" <?=check_permission('product__man_properties__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__add_properties__product" <?=check_permission('product__add_properties__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__edit_properties__product" <?=check_permission('product__edit_properties__product',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="product__delete_properties__product" <?=check_permission('product__delete_properties__product',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="product__save_properties__product">
                    </tr>
                    <tr>
                        <td class="name_per">Quản lý đơn hàng</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="order__man" <?=check_permission('order__man',$item['permission'])?>>
                        </td>
                        <td align="center">
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="order__delete" <?=check_permission('order__delete',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="order__edit" <?=check_permission('order__edit',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="order__save">
                    </tr>
                    <!-- END: Product -->

                    
                    <!-- BEGIN: Đặc tính -->
                    <tr>
                        <td class="name_per">Thuộc tính sản phẩm </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="properties__man__properties" <?=check_permission('properties__man__properties',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="properties__add__properties" <?=check_permission('properties__add__properties',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="properties__delete__properties" <?=check_permission('properties__delete__properties',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="properties__edit__properties" <?=check_permission('properties__edit__properties',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="properties__save__properties">
                    </tr>
                    <tr>
                        <td class="name_per">Thương hiệu sản phẩm </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="properties__man__trademark" <?=check_permission('properties__man__trademark',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="properties__add__trademark" <?=check_permission('properties__add__trademark',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="properties__delete__trademark" <?=check_permission('properties__delete__trademark',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="properties__edit__trademark" <?=check_permission('properties__edit__trademark',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="properties__save__trademark">
                    </tr>
                    <tr>
                        <td class="name_per">Mức giá tìm kiếm</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="gia__man" <?=check_permission('gia__man',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="gia__add" <?=check_permission('gia__add',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="gia__delete" <?=check_permission('gia__delete',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="gia__edit" <?=check_permission('gia__edit',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="gia__save">
                    </tr>
                    <tr>
                        <td class="name_per">Hình thức thanh toán</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="httt__man" <?=check_permission('httt__man',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="httt__add" <?=check_permission('httt__add',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="httt__delete" <?=check_permission('httt__delete',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="httt__edit" <?=check_permission('httt__edit',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="httt__save">
                    </tr>
                    
                    <!-- END: Đặc tính -->

                    <tr>
                        <td class="name_per">Quản lý bài viết tin công nghệ</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__man__tintuc" <?=check_permission('baiviet__man__tintuc',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__add__tintuc" <?=check_permission('baiviet__add__tintuc',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__delete__tintuc" <?=check_permission('baiviet__delete__tintuc',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__edit__tintuc" <?=check_permission('baiviet__edit__tintuc',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="baiviet__save__tintuc">
                    </tr>

                    <tr>
                        <td class="name_per">Quản lý bài viết phản hồi khách hàng</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__man__khachhang" <?=check_permission('baiviet__man__khachhang',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__add__khachhang" <?=check_permission('baiviet__add__khachhang',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__delete__khachhang" <?=check_permission('baiviet__delete__khachhang',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__edit__khachhang" <?=check_permission('baiviet__edit__khachhang',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="baiviet__save__khachhang">
                    </tr>

                    
                    <tr>
                        <td class="name_per">Quản lý bài viết chính sách công ty</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__man__chinhsach" <?=check_permission('baiviet__man__chinhsach',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__add__chinhsach" <?=check_permission('baiviet__add__chinhsach',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__delete__chinhsach" <?=check_permission('baiviet__delete__chinhsach',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="baiviet__edit__chinhsach" <?=check_permission('baiviet__edit__chinhsach',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="baiviet__save__chinhsach">
                    </tr>
                        
                    <tr>
                        <td class="name_per">Quản lý chi nhánh</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="chinhanh__man__branch" <?=check_permission('chinhanh__man__branch',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="chinhanh__add__branch" <?=check_permission('chinhanh__add__branch',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="chinhanh__delete__branch" <?=check_permission('chinhanh__delete__branch',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="chinhanh__edit__branch" <?=check_permission('chinhanh__edit__branch',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="chinhanh__save__branch">
                    </tr>
                    
                    <tr>
                        <td class="name_per">Quản lý thành viên</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="thanhvien__man" <?=check_permission('thanhvien__man',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="thanhvien__add" <?=check_permission('thanhvien__add',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="thanhvien__delete" <?=check_permission('thanhvien__delete',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="thanhvien__edit" <?=check_permission('thanhvien__edit',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="thanhvien__save">
                    </tr>
                    <tr>
                        <td class="name_per">Quản lý xưởng sản xuất</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="album__man__album" <?=check_permission('album__man__album',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="album__add__album" <?=check_permission('album__add__album',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="album__delete__album" <?=check_permission('album__delete__album',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="album__edit__album" <?=check_permission('album__edit__album',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="album__save__album">
                    </tr>
                    <tr>
                        <td class="name_per">Cập nhật Logo</td>
                        <td align="center" colspan="4">
                            <input name="permiss[]" type="checkbox" value="bannerqc__capnhat__logo" <?=check_permission('bannerqc__capnhat__logo',$item['permission'])?>>
                        </td>
                        
                        <input name="permiss[]" type="hidden" checked="checked" value="bannerqc__save__logo">
                    </tr>

                    

                    <tr>
                        <td class="name_per">Cập nhật nội dung liên hệ</td>
                        <td align="center" colspan="4">
                            <input name="permiss[]" type="checkbox" value="company__capnhat__lienhe" <?=check_permission('company__capnhat__lienhe',$item['permission'])?>>
                        </td>
                        
                        <input name="permiss[]" type="hidden" checked="checked" value="company__save__lienhe">
                    </tr>

                    <tr>
                        <td class="name_per">Cập nhật nội dung footer</td>
                        <td align="center" colspan="4">
                            <input name="permiss[]" type="checkbox" value="company__capnhat__footer" <?=check_permission('company__capnhat__footer',$item['permission'])?>>
                        </td>
                        
                        <input name="permiss[]" type="hidden" checked="checked" value="company__save__footer">
                    </tr>

                    <tr>
                        <td class="name_per">Quản lý yêu cầu gọi lại</td>
                        <td align="center" colspan="4">
                            <input name="permiss[]" type="checkbox" value="newsletter__man" <?=check_permission('newsletter__man',$item['permission'])?>>
                        </td>
                        
                        <input name="permiss[]" type="hidden" checked="checked" value="newsletter__delete">
                    </tr>

                    <tr>
                        <td class="name_per">Cập nhật thông tin Website/Công ty</td>
                        <td align="center" colspan="4">
                            <input name="permiss[]" type="checkbox" value="setting__capnhat" <?=check_permission('setting__capnhat',$item['permission'])?>>
                        </td>
                        
                        <input name="permiss[]" type="hidden" checked="checked" value="setting__save">
                    </tr>

                    <tr>
                        <td class="name_per">Quản lý hình ảnh slide</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__man_photo__slider" <?=check_permission('photo__man_photo__slider',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__add_photo__slider" <?=check_permission('photo__add_photo__slider',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__delete_photo__slider" <?=check_permission('photo__delete_photo__slider',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__edit_photo__slider" <?=check_permission('photo__edit_photo__slider',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="photo__save_photo__slider">
                    </tr>

                    <tr>
                        <td class="name_per">Quản lý hình ảnh mạng xã hội</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="lkweb__man__mxh" <?=check_permission('lkweb__man_photo__mxh',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="lkweb__add__mxh" <?=check_permission('lkweb__add__mxh',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="lkweb__delete__mxh" <?=check_permission('lkweb__delete__mxh',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="lkweb__edit__mxh" <?=check_permission('lkweb__edit__mxh',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="lkweb__save__mxh">
                    </tr>
                    <tr>
                        <td class="name_per">Quản lý hình ảnh khuyến mãi</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__man_photo__sale" <?=check_permission('photo__man_photo__sale',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__add_photo__sale" <?=check_permission('photo__add_photo__sale',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__delete_photo__sale" <?=check_permission('photo__delete_photo__sale',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__edit_photo__sale" <?=check_permission('photo__edit_photo__sale',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="photo__save_photo__sale">
                    </tr>
                    <tr>
                        <td class="name_per">Quản lý hình ảnh đối tác</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__man_photo__partner" <?=check_permission('photo__man_photo__partner',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__add_photo__partner" <?=check_permission('photo__add_photo__partner',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__delete_photo__partner" <?=check_permission('photo__delete_photo__partner',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__edit_photo__partner" <?=check_permission('photo__edit_photo__partner',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="photo__save_photo__partner">
                    </tr>
                    <tr>
                        <td class="name_per">Quản lý hình ảnh quảng cáo</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__man_photo__quangcao" <?=check_permission('photo__man_photo__quangcao',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__add_photo__quangcao" <?=check_permission('photo__add_photo__quangcao',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__delete_photo__quangcao" <?=check_permission('photo__delete_photo__quangcao',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="photo__edit_photo__quangcao" <?=check_permission('photo__edit_photo__quangcao',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="photo__save_photo__quangcao">
                    </tr>

                    <tr>
                        <td class="name_per">Quản lý Video</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="video__man__video" <?=check_permission('video__man__video',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="video__add__video" <?=check_permission('video__add__video',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="video__delete__video" <?=check_permission('video__delete__video',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="video__edit__video" <?=check_permission('video__edit__video',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="video__save__video">
                    </tr>

                    <tr>
                        <td class="name_per">Quản lý email liên hệ</td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="contact__man" <?=check_permission('contact__man',$item['permission'])?>>
                        </td>
                        <td align="center">
                            
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="contact__delete" <?=check_permission('contact__delete',$item['permission'])?>>
                        </td>
                        <td align="center">
                            <input name="permiss[]" type="checkbox" value="contact__edit" <?=check_permission('contact__edit',$item['permission'])?>>
                        </td>
                        <input name="permiss[]" type="hidden" checked="checked" value="contact__save">
                    </tr>

                    <input name="permiss[]" type="hidden" checked="checked" value="user__admin_edit">
                    <input name="permiss[]" type="hidden" checked="checked" value="user__logout">
                </tbody>
            </table>
        </div>
        <div class="clear"></div>
    </div>

   <!-- 
    <div class="formRow">
        <label>Hiển thị :</label>
        <div class="formRight">
            <input type="checkbox" name="hienthi" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?>>
        </div>
        <div class="clear"></div>
    </div>
         -->
    <div class="formRow">
    <label></label>
    <div class="formRight">
        <input type="hidden" name="id" id="id" value="<?=@$item['id']?>" />
        <input type="submit" value="Lưu"  class="button blueB" />
        <input type="button" value="Thoát" onclick="javascript:window.location='index.php?com=phanquyen&act=man'" class="button blueB" />
    </div>
    <div class="clear"></div>
    </div>
</div>
</form>