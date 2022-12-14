<?php

namespace App\Consts;

class Common
{
    // 画像ディレクトリ
    public const PRODUCT_IMG_DIR = 'public/images/product/';

    // 性別
    public const SEX_MEN = 1;
    public const SEX_WOMAN = 2;
    public const SEX_OTHER = 3;
    public const SEX_LIST = [
        self::SEX_MEN => '男性',
        self::SEX_WOMAN => '女性',
        self::SEX_OTHER => 'その他',
    ];
    public const SEX_SYMBOL = [
        self::SEX_MEN => '♂',
        self::SEX_WOMAN => '♀',
        self::SEX_OTHER => '-',
    ];

    // 曜日
    public const WEEK_LIST = [  // カレンダーの並び順
        0 => '日',
        1 => '月',
        2 => '火',
        3 => '水',
        4 => '木',
        5 => '金',
        6 => '土',
    ];

    // 在籍権限
    public const AUTHORITY_PLANING_JOIN = 1;
    public const AUTHORITY_ENROLLED = 2;
    public const AUTHORITY_REST = 5;
    public const AUTHORITY_RETIREMENT = 9;
    public const AUTHORITY_LIST = [
        self::AUTHORITY_PLANING_JOIN => '入社予定',
        self::AUTHORITY_ENROLLED => '在籍',
        self::AUTHORITY_REST => '長期休暇',
        self::AUTHORITY_RETIREMENT => '退職',
    ];

    // 在籍権限
    public const AUTHORIZATION_NOT_AVAILABLE  = 0;
    public const AUTHORIZATION_AVAILABLE  = 1;
    public const AUTHORIZATION_LIST = [
        self::AUTHORIZATION_NOT_AVAILABLE => '権限なし',
        self::AUTHORIZATION_AVAILABLE => '権限あり',
    ];


}
