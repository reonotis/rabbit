<x-user-layout>
    <x-slot name="header"><h2>スタッフ</h2></x-slot>

    <div class="p-4">
        <table class="userListTbl" >
            <thead>
                <tr>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>他所属店舗</th>
                    <th>権限</th>
                    <th>選択</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users AS $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td></td>
                        <td>{{ Common::AUTHORITY_LIST[$user->authority_level] }}</td>
                        <td>
                            <a href="{{ route('user.belongSelected',['user' => $user->id]) }}" class="min-btn register-btn">選択する</a>　
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-user-layout>

