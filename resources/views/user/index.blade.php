<x-user-layout>
    <x-slot name="header"><h2>スタッフ</h2></x-slot>

    <div class="p-4">
        <div class="p-4"><a href="{{ route('user.belongSelect') }}">既存スタッフを&nbsp;{{ session()->get(SessionConst::SELECTED_SHOP)->shop_name }}&nbsp;に登録する</a></div>
        <div class="p-4">
            <div class="p-4">
                <form action="{{ route('user.search') }}" method="post" >
                    @csrf
                    <table class="w-1/2 m-auto user_search_tbl" >
                        <tr>
                            <th>名前</th>
                            <td>
                                <div class="w-full" >
                                    <input type="text" name="name" value="{{ request('name') }}" >
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td>
                                <div class="w-full" >
                                    <input type="email" name="email" value="{{ request('email') }}" >
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>在籍ステータス</th>
                            <td>
                                <div class="flex" >
                                    <div class="" ><label>全ての在籍ステータスを表示する</label></div>
                                    <div class="" >
                                        <input type="checkbox" name="otherAuthorityLevel" value="true" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="flex mt-4">
                        <input type="submit" value="検索" class="register-btn">
                    </div>
                </form>
            </div>
            <div class="p-4">
                <table class="userListTbl" >
                    <thead>
                        <tr>
                            <th>名前</th>
                            <th>メールアドレス</th>
                            <th>在籍ステータス</th>
                            <th>所属店舗</th>
                            <th>確認</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users AS $user)
                            <tr>
                                <td>{{ $user->name}}</td>
                                <td>{{ $user->email}}</td>
                                <td>{{ Common::AUTHORITY_LIST[$user->authority_level]}}</td>
                                <td>
                                    @foreach($user->userShops AS $userShops)
                                        <p>{{ $userShops->shop->shop_name }}</p>
                                    @endforeach
                                </td>
                                <td><a href="{{route('user.show', ['user' => $user->id])}}" >確認</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-user-layout>

