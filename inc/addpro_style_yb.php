<?php
    include "./../fun/eby_admin_api.php";
    include "./../fun/phpfile.php";
    $adduid = $_SESSION['uid'];

    if( $_POST['uid'] ){
        $adduid = $_POST['uid'];
    }
    $material = is_array($_POST['material']) ? $_POST['material'] : array();
    $style_son = $_POST['style_son'];
    $array = array
    (
        'style_no' => $_POST['style_no'],
        'style_name' => $_POST['style_name'],
        'style_thumb' => $_POST['style_thumb'],
        'style_video' => $_POST['style_video'],
        'style_mode' => $_POST['style_mode'],
        'style_sort' => $_POST['style_sort'],
        'style_new' => $_POST['style_new'],
        'style_hot' => $_POST['style_hot'],
        'times' => time(),
        'factory' => $_POST['factory'],
        'factory_no' => $_POST['factory_no'],
        'style_brand' => $_POST['style_brand'],
        'adduid' => 1,
        'cls1' => $_POST['cls1'],
        'cls2' => $_POST['cls2'],
        'cls3' => $_POST['cls3'],
        'MinPrice' => $_POST['MinPrice'],
        'MaxPrice' => $_POST['MaxPrice'],
        'material' => implode(',', $material),
        'GoodsSize' => addslashes($_POST['GoodsSize']),
        'StoneType' => addslashes($_POST['StoneType']),
        'StonePrice' => $_POST['StonePrice'],
        'StoneTxt' => $_POST['StoneTxt'],
        //'goldWeight'=>$goldWeight,
        'StoneShape' => addslashes($_POST['StoneShape']),
        'StoneNum' => addslashes($_POST['StoneNum']),
        'S_Weight' =>  addslashes($_POST['S_Weight']),
        'MaxStoneWeight' => addslashes($_POST['MaxStoneWeight']),
        'DeStoneNum' => addslashes($_POST['DeStoneNum']),
        'MinDeStoneWeight' => addslashes($_POST['MinDeStoneWeight']),
        'MaxDeStoneWeight' => addslashes($_POST['MaxDeStoneWeight']),
        'Color' => $_POST['Color'],
        'Clarity' => $_POST['Clarity'],
        'worksprice' => $_POST['worksprice'],
        'thumb_url' => json_encode(explode(",", $_POST['thumb_url'])),
        'content' => $_POST['content'],
        'price_18K' => $_POST['price_18K'],
        'price_pt' => $_POST['price_pt'],
        'goldWeight_18K' => $_POST['goldWeight_18K'],
        'goldWeight_pt950' => $_POST['goldWeight_pt950'],
        'stocks' => $_POST['stocks'],
        'keyword' => $_POST['keyword'],
        'qdz_type' => $_POST['qdz_type']
    );
    if ($style_son == 'error') {
        $array['adduid'] = 0;
    }

    if (insert($array, 'e_unified_sylte_new')) {
        echo 'go';
    }


?>