<?php  if(!defined('SOURCE')){ die("Error"); }
	
	$d->reset();
    $sql="select p.ten_$lang,p.file,l.id,l.ten_$lang as ten";
    $sql.=" from #_download p,#_tags l";
    $sql.=" where p.id_list=l.id and l.type='tailieu' and l.hienthi=1  and p.hienthi=1";
    $sql.=" order by l.stt,l.id desc, p.stt,p.id desc";
    $d->query($sql);
    $result_productlist = $d->result_array();

    foreach ($result_productlist as $key => $val_l) {
        $list_pro[$val_l['id']]['list'] = array('ten'=>$val_l['ten'],'id'=>$val_l['id']);
        // tao moi danh sach product theo list
        if($list_pro[$val_l['id']]['file']){
            array_push($list_pro[$val_l['id']]['file'],array('ten_file'=>$val_l['ten_'.$lang],'file'=>$val_l['file']));
        }else{
            $list_pro[$val_l['id']]['file'] = array();
            array_push($list_pro[$val_l['id']]['file'],array('ten_file'=>$val_l['ten_'.$lang],'file'=>$val_l['file']));
        }
    }
?>