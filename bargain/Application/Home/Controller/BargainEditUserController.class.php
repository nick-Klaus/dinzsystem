<?php

    namespace Home\Controller;

    use Think\Controller;

    class BargainEditUserController extends Controller
    {
        public function _initialize ()
        {
            header ( 'Access-Control-Allow-Origin: *' );
            header ( "Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept" );
            header ( 'Access-Control-Allow-Methods: GET, POST, PUT' );
        }

        // 为用户修改砍价活动
        public function edituser ()
        {
            $Bargain_user = M ( "Bargain_user" );
            function randomFloat ( $min = 0 , $max = 10 )
            {
                $num = $min + mt_rand () / mt_getrandmax () * ( $max - $min );

                return sprintf ( "%.2f" , $num );
            }

            // 最低砍价和最高砍价间取随机数
            $min_sale = I ( "post.min_sale" );
            $max_sale = I ( "post.max_sale" );
            // 需要砍掉的价格
            $bargain_price = randomFloat ( $min_sale , $max_sale );
            // 砍完价以后现在的价格
            $new_price = I ( "post.new_price" ) - $bargain_price;
            // 砍完价以后价格低于底价则修改为底价
            $floor_price = I ( "post.floor_price" );
            $where = [ "id" => I ( "post.user_id" ) ];
            $data = $Bargain_user -> where ( $where ) -> find ();
            // 砍到低价的时候不能超过底价  并且减去礼品
            if ( I ( "post.new_price" ) != $floor_price ) {
                if ( $new_price <= $floor_price ) {
                    $new_price = $floor_price;
                    $Bargain = M ( "Bargain" );
                    $Bargain_data = $Bargain -> where ( [ "id" => $data[ "bargain_id" ] ] ) -> find ();
                    // 砍到最低价礼物减掉1个最低价人数增加1个
                    $gift_num = intval($Bargain_data[ 'new_gift_quantity' ]);
                    if ( $gift_num > 0 ) {
                        $arr_gift = [
                            "new_gift_quantity" => $gift_num - 1 ,
                            "user_floor"        => intval($Bargain_data[ 'user_floor' ]) + 1
                        ];
                        $row = $Bargain -> where ( [ "id" => $data[ "bargain_id" ] ] ) -> save ( $arr_gift );
                    }
                }
            }
            else {
                $this -> ajaxReturn ( "底价和现价相等" );
            }
            // 找出当前用户的信息
            $create = [
                "new_price"     => abs($new_price) ,
                "bargain_type"  => I ( "post.bargain_type" ) ,
                "bargain_times" => $data[ "bargain_times" ] - 1 ,
                "bargain_time"  => date ( "Y-m-d H:i:s" , time () ) ,
            ];
            // 砍价的日志
            $create_log = [
                "openid"     => I ( "post.openid" ) ,
                "user_id"    => I ( "post.user_id" ) ,// 修改过
                "bargain_id" => $data[ "bargain_id" ] ,
                "price"      => $bargain_price ,
                "new_price"  => abs($new_price) ,
                "addtime"    => date ( "Y-m-d H:i:s" , time () ) ,
            ];
            $data[ "bargain_times" ] = 1;
            if ( $data[ "bargain_times" ] == 0 ) {
                $create_log[ 'price' ] = '砍价次数用完!';
                $create_log[ 'new_price' ] = I ( "post.new_price" );
                $this -> ajaxReturn ( $create_log );
                exit;
            }
            // 查询当前砍价人是否砍过价 没有则可以砍价并添加日志
            $bargain_log = M ( "bargain_log" );
            $where_log = [ "openid" => $create_log[ 'openid' ] , "user_id" => $create_log[ 'user_id' ] , "bargain_id" => $create_log[ 'bargain_id' ] ];
            $data_log = $bargain_log -> where ( $where_log ) -> find ();

            if ( $data_log ) {
                $create_log[ 'price' ] = '您已帮忙砍过价!';
                $create_log[ 'new_price' ] = I ( "post.new_price" );
                $this -> ajaxReturn ( $create_log );
                exit;
            }
            if ( $data ) {
                if ( $res = $Bargain_user -> where ( $where ) -> save ( $create ) ) {
                    $bargain_log -> add ( $create_log );
                    $this -> ajaxReturn ( $create_log );
                }
                else {
                    $this -> ajaxReturn ( '砍价失败' );
                }
            }
            else {
                $this -> ajaxReturn ( '你没有参加此活动' );
            }
        }

        // 为用户修改砍价活动 需支付定金
        public function edituser_pay ()
        {
            $Bargain_user = M ( "Bargain_user" );
            function randomFloat ( $min = 0 , $max = 10 )
            {
                $num = $min + mt_rand () / mt_getrandmax () * ( $max - $min );

                return sprintf ( "%.2f" , $num );
            }

            // 最低砍价和最高砍价间取随机数
            $min_sale = I ( "post.min_sale" );
            $max_sale = I ( "post.max_sale" );
            // 需要砍掉的价格
            $bargain_price = randomFloat ( $min_sale , $max_sale );
            // 砍完价以后现在的价格
            $new_price = I ( "post.new_price" ) - $bargain_price;
            // 砍完价以后价格低于底价则修改为底价
            $floor_price = I ( "post.floor_price" );
            $where = [ "id" => I ( "post.user_id" ) ];
            // 当前砍价的用户信息
            $data = $Bargain_user -> where ( $where ) -> find ();
            // 砍到低价的时候不能超过底价  并且减去礼品
            if ( I ( "post.new_price" ) != $floor_price ) {
                if ( $new_price < $floor_price ) {
                    // 砍到底价后 判断是否付定金
                    if ( $data[ 'pay_status' ] == 1 ) {
                        $new_price = $floor_price;
                        $Bargain = M ( "Bargain" );
                        $Bargain_data = $Bargain -> where ( [ "id" => $data[ "bargain_id" ] ] ) -> find ();
                        // 砍到最低价礼物减掉1个最低价人数增加1个
                        $gift_num = $Bargain_data[ 'new_gift_quantity' ];
                        if ( $gift_num > 0 ) {
                            $arr_gift = [
                                "new_gift_quantity" => $gift_num - 1 ,
                                "user_floor"        => $Bargain_data[ 'user_floor' ] + 1
                            ];
                            $row = $Bargain -> where ( [ "id" => $data[ "bargain_id" ] ] ) -> save ( $arr_gift );
                        }
                    }
                    else {
                        $new_price = intval ( $floor_price ) + 1.12;
                    }
                }
            }
            else {
                $this -> ajaxReturn ( "底价和现价相等" );
            }
            // 找出当前用户的信息
            $create = [
                "new_price"     => $new_price ,
                "bargain_type"  => I ( "post.bargain_type" ) ,
                "bargain_times" => $data[ "bargain_times" ] - 1 ,
                "bargain_time"  => date ( "Y-m-d H:i:s" , time () ) ,
            ];
            // 砍价的日志
            $create_log = [
                "openid"     => I ( "post.openid" ) ,
                "user_id"    => I ( "post.user_id" ) ,// 修改过
                "bargain_id" => $data[ "bargain_id" ] ,
                "price"      => $bargain_price ,
                "new_price"  => $new_price ,
                "addtime"    => date ( "Y-m-d H:i:s" , time () ) ,
            ];
            $data[ "bargain_times" ] = 1;
            if ( $data[ "bargain_times" ] == 0 ) {
                $create_log[ 'price' ] = '砍价次数用完!';
                $create_log[ 'new_price' ] = I ( "post.new_price" );
                $this -> ajaxReturn ( $create_log );
                exit;
            }
            // 查询当前砍价人是否砍过价 没有则可以砍价并添加日志
            $bargain_log = M ( "bargain_log" );
            $where_log = [ "openid" => $create_log[ 'openid' ] , "user_id" => $create_log[ 'user_id' ] , "bargain_id" => $create_log[ 'bargain_id' ] ];
            $data_log = $bargain_log -> where ( $where_log ) -> find ();

            if ( $data_log ) {
                $create_log[ 'price' ] = '您已帮忙砍过价!';
                $create_log[ 'new_price' ] = I ( "post.new_price" );
                $this -> ajaxReturn ( $create_log );
                exit;
            }
            if ( $data ) {
                if ( $res = $Bargain_user -> where ( $where ) -> save ( $create ) ) {
                    $bargain_log -> add ( $create_log );
                    $this -> ajaxReturn ( $create_log );
                }
                else {
                    $this -> ajaxReturn ( '砍价失败' );
                }
            }
            else {
                $this -> ajaxReturn ( '你没有参加此活动' );
            }
        }
    }