<x-user-layout>
    <x-slot name="header"><h2>スタッフ</h2></x-slot>

    <div class="p-4">
        <div class="p-4">
            <img src='{{ $qrcode }}' alt='QR Code' width='50%' height='50%'>
        </div>


        <div class="" >
            <a href="{{ $url }}" >{{ $url }}</a>
        </div>
    </div>
</x-user-layout>

