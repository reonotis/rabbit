<?php
    $routeNum = 0;
    $routeName = \Route::currentRouteName();
    switch($routeName){
        case 'myPage':
            $routeNum = 1;
            break;
        case 'report':
            $routeNum = 2;
            break;
        case 'reserve.list':
            $routeNum = 3;
            break;
        case str_starts_with($routeName, 'customer'):
            $routeNum = 4;
            break;
        case str_starts_with($routeName, 'user'):
            $routeNum = 5;
            break;
        case str_starts_with($routeName, 'medical'):
            $routeNum = 6;
            break;
        case '':
            break;
    }
?>

<ul>
    <li><a href="{{ route('myPage') }}" class="sidebarTitle <?= ($routeNum === 1) ? "active": ""; ?>" >ホーム</a></li>
    <li><a href="{{ route('report') }}" class="sidebarTitle <?= ($routeNum === 2) ? "active": ""; ?>" >日報</a></li>
    <li><a href="{{ route('reserve') }}" class="sidebarTitle <?= ($routeNum === 3) ? "active": ""; ?>" >予約</a></li>
    <li>
        <div class="sidebarTitle parentMenu <?= ($routeNum == 4) ? "active open": ""; ?>" id="parentMenu_4"><p class="">顧客管理</p></div>
        <ul class="childMenu" id="childMenu_4" <?= ($routeNum <> 4) ? 'style="overflow: hidden; display: none;"': ""; ?> >
            <?php $subRoute = (request()->routeIs('customer.index') || request()->routeIs('customer.show') )? true : false; ?>
            <li><a href="{{ route('customer.index') }}" class="sidebarTitleIn <?= ($subRoute) ? 'active': ''; ?>" >顧客確認</a></li>
            <li><a href="{{ route('customer.create') }}" class="sidebarTitleIn <?= (request()->routeIs('customer.create')) ? 'active': ''; ?>" >顧客登録</a></li>
        </ul>
    </li>
    <li>
        <div class="sidebarTitle parentMenu <?= ($routeNum == 5) ? "active open": ""; ?>" id="parentMenu_5"><p class="">スタイリスト管理</p></div>
        <ul class="childMenu" id="childMenu_5" <?= ($routeNum <> 5) ? 'style="overflow: hidden; display: none;"': ""; ?> >
            <?php $subRoute = (request()->routeIs('user.index') || request()->routeIs('user.search') )? true : false; ?>
            @if(Auth::user()->userShop->userShopAuthorization->user_read)
                <li><a href="{{ route('user.index') }}" class="sidebarTitleIn <?= ($subRoute) ? 'active': ''; ?>" >スタイリスト一覧</a></li>
            @endif
            @if(Auth::user()->userShop->userShopAuthorization->user_create)
                <li><a href="{{ route('user.create') }}" class="sidebarTitleIn <?= (request()->routeIs('user.create')) ? 'active': ''; ?>" >スタイリスト登録</a></li>
            @endif
        </ul>
    </li>
    <li><a href="{{ route('medical.index') }}" class="sidebarTitle <?= ($routeNum === 6) ? "active": ""; ?>" >カルテ登録QR</a></li>
        <li>
        <div class="sidebarTitle parentMenu <?= ($routeNum == 7) ? "active open": ""; ?>" id="parentMenu_7"><p class="">各種設定</p></div>
        <ul class="childMenu" id="childMenu_7"  <?= ($routeNum <> 7) ? 'style="overflow: hidden; display: none;"': ""; ?>>
            <li><a href="" class="sidebarTitleIn" >ショップ基本情報</a></li>
            <li><a href="" class="sidebarTitleIn <?= (request()->routeIs('shop.setting.shipping')) ? 'active': ''; ?>" >発送日程設定</a></li>
            <li><a href="" class="sidebarTitleIn" >個人情報編集</a></li>
            <li><a href="" class="sidebarTitleIn" >税率設定</a></li>
            <li><a href="" class="sidebarTitleIn" >メール設定</a></li>
        </ul>
    </li>
</ul>

