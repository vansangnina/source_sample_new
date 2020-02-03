<nav id="menu_bootstrap">
  	<ul>
  		<li <?=$_GET['com']=='' ? 'class="menu_active"':''?>><a href="" class="transitionAll">Trang Chủ</a></li>
  		<li <?=$_GET['com']=='ve-chung-toi' ? 'class="menu_active"':''?>><a href="ve-chung-toi" class="transitionAll">Về Chúng Tôi</a></li>
        <li <?=$_GET['com']=='san-pham' ? 'class="menu_active"':''?>><a href="san-pham" class="transitionAll">Sản Phẩm</a>
            <ul>
            <?php foreach ($list as $key => $value_l) { 
                $d->reset();
                $d->query("select ten_vi as ten,tenkhongdau,id from #_product_cat where id_list='".$value_l['id']."' and type='product' and hienthi=1 order by stt,id desc");
                $catm = $d->result_array();
            ?>
                <li><a href="<?=$value_l['tenkhongdau']?>"><?=$value_l['ten']?></a>
                    <?php if($catm){ ?>
                        <ul>
                            <?php foreach ($catm as $key => $value_c) { ?>
                                <li><a href="<?=$value_c['tenkhongdau']?>"><?=$value_c['ten']?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>
            </ul>
        </li>
        <li <?=$_GET['com']=='dich-vu'?'class="menu_active"':''?>><a href="dich-vu" class="transitionAll">Dịch Vụ</a></li>
        <li <?=$_GET['com']=='tu-van-mua-hang'?'class="menu_active"':''?>><a href="tu-van-mua-hang" class="transitionAll">Tư Vấn Mua Hàng</a></li>
        <li <?=$_GET['com']=='tin-tuc'?'class="menu_active"':''?>><a href="tin-tuc" class="transitionAll"><?=TINTUC?></a></li>
        <li <?=$_GET['com']=='lien-he'?'class="menu_active"':''?>><a href="lien-he" class="transitionAll"><?=LIENHE?></a></li>
  	</ul>
</nav>

