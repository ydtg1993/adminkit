<?php

return [

    'user' => [
        'integral_record' => [  //积分记录
            'register_gift' => '注册', //注册赠送
            'buy' => '购买', //购买赠送
            'exchange' => '兑换',//兑换
        ],
        'commission_source' => [ //佣金来源
            'buy' => '消费', //消费
        ],
        'rank' => [
            'one' => '小青铜',
            'two' => '白银',
            'three' => '黄金',
            'four' => '铂金',
            'five' => '钻石',
            'six' => '星耀',
            'seven' => '王者',
        ],
        'withdraw_status' => [
            'untreated' => '审核中', //1
            'refuse' => '已驳回', //2
            'adopt' => '已通过',//3
            'done' => '打款完成'// 4
        ]
    ],

    'product' => [
        'delivery_status' => [
            'wait' => '待发货',    //1
            'send' => '已发货',    //2
            'done' => '已完成',    //3
        ]
    ],
    'goods' => [
        'status' => [
            'down_shelves' => '下架', //下架
            'up_shelves' => '上架'   //上架
        ],
        'type' => [
            'ordinary' => '普通商品',           //普通商品
            'shopping_card' => '购物券',       //商城购物券
        ]
    ],
    'recharge' => [
        'type' => [
            'wechat' => '微信', //1
            'alipay' => '支付宝',  //2
            'offline' => '线下充值', //3
            'shopping_card' => '购物卡',  //4
            'gift' => '赠送',            //5
            'integral' => '积分兑换',        //6
            'commission' => '佣金充值'       //7
        ]
    ],
    'withdraw' => [
        'status' => [
            'untreated' => '未处理', //1
            'refuse' => '驳回', //2
            'adopt' => '通过',//3
            'done' => '已打款'// 4
        ]
    ]
];