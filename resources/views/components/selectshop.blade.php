<div class="selectShopDisplayArea" >
    <div class="selectedShopName" >
        @if(!empty(session()->get(SessionConst::SELECTED_SHOP)->shop_name))
            {{ session()->get(SessionConst::SELECTED_SHOP)->shop_name }}
            @if(!empty(session()->get(SessionConst::SELECTABLE_SHOP)))
                <a href="{{ route('shop.deselect') }}"  class="deselect" >他の店舗を選択する</a>
            @endif
        @endif
    </div>
</div>
