<x-app-layout>
    <x-slot name="header">
        <h2>店舗選択</h2>
    </x-slot>

    <div class="p-4">
        @foreach($shops as $shop)
            <div class="" >
                <a href="{{ route('shop.selecting', ['shop'=>$shop->id])}} ">
                    <div class="selectShopBTN" >
                        {{ $shop->shop_name }}
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</x-app-layout>

