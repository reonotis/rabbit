<x-customer-layout>
    <x-slot name="header">
        <h2>顧客登録</h2>
    </x-slot>

    <div class="flex p-4">
        <div class="w-1/2">
            <div class="customerContentsArea">
                <form action="{{ route('customer.store') }}" method="post">
                    @csrf
                    <div class="">基本情報</div>
                    <div class="customer_row">
                        <div class="customer_title">顧客番号</div>
                        <div class="customer_contents">
                            未記入の場合、顧客番号は自動で割り振られます
                            <input type="text" name="customer_no" id="customer_no" value="{{ old('customer_no') }}" placeholder="CA99999" >
                        </div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">顧客名</div>
                        <div class="customer_contents">
                            <div class="flex mb-1">
                                <div class="w-1/2 pr-2">
                                    @php
                                        $fNameClass = (!empty(session(SessionConst::FLASH_MESSAGE_ERROR)['f_name']))? 'form-control input-error': 'form-control';
                                    @endphp
                                    {{ Form::text('f_name',  // name
                                        old('f_name')? old('f_name'): '',  // value
                                        [
                                            'class' => $fNameClass,
                                            'id' => 'f_name',
                                            'placeholder' => '田中',
                                            'onblur' => 'check_f_name()',
                                            'onChange' => 'check_f_name()',
                                        ])
                                    }}
                                </div>
                                <div class="w-1/2 pr-2">
                                    @php
                                        $lNameClass = (!empty(session(SessionConst::FLASH_MESSAGE_ERROR)['f_name']))? 'form-control input-error': 'form-control';
                                    @endphp
                                    {{ Form::text('l_name',  // name
                                        old('l_name')? old('l_name'): '',  // value
                                        [
                                            'class' => $lNameClass,
                                            'id' => 'l_name',
                                            'placeholder' => '太郎',
                                            'onblur' => 'check_l_name()',
                                            'onChange' => 'check_l_name()',
                                        ])
                                    }}
                                </div>
                            </div>
                            <div class="flex">
                                <div class="w-1/2 pr-2">
                                    <input type="text" name="f_read" id="f_read" value="{{ old('f_read') }}" placeholder="タナカ" >
                                </div>
                                <div class="w-1/2 pr-2">
                                    <input type="text" name="l_read" id="l_read" value="{{ old('l_read') }}" placeholder="タロウ" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">性別</div>
                        <div class="customer_contents">
                            <div class="flex">
                                @foreach(Common::SEX_LIST as $sexId => $sexName)
                                    <label>
                                        <input type="radio" name="sex" value="{{ $sexId }}" >{{ $sexName }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">メールアドレス</div>
                        <div class="customer_contents">
                            @php
                                $emailClass = (!empty(session(SessionConst::FLASH_MESSAGE_ERROR)['email']))? 'input-error': '';
                            @endphp
                            {{ Form::email('email',  // name
                                old('email')? old('email'): '',  // value
                                [
                                    'class' => $emailClass,
                                    'id' => 'email',
                                    'placeholder' => 'sample@hairmake.jp',
                                    'onblur' => 'check_email()',
                                    'onChange' => 'check_email()',
                                ])
                            }}
                        </div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">電話番号</div>
                        <div class="customer_contents">
                            <input type="text" name="tel" id="tel" value="{{ old('tel') }}" placeholder="090-1234-5678" >
                        </div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">担当スタイリスト</div>
                        <div class="customer_contents">
                            <select>
                                <option>--</option>
                                @foreach($users AS $user)
                                    <option value="{{ $user->id }}" >{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">住所</div>
                        <div class="customer_contents">
                            <div class="flex items-center mb-1">
                                <div class="w-20 pr-2">
                                    <input type="text" name="zip1" id="zip1" value="{{ old('zip1') }}" placeholder="100" >
                                </div>
                                <div class="pr-2">-</div>
                                <div class="w-24 pr-2">
                                    <input type="text" name="zip2" id="zip2" value="{{ old('zip2') }}" placeholder="0001" >
                                </div>
                            </div>
                            <div class="flex items-center mb-1">
                                <div class="w-32 pr-2">
                                    <input type="text" name="" id="" value="{{ old('') }}" placeholder="東京都" >
                                </div>
                                <div class="w-48 pr-2">
                                    <input type="text" name="" id="" value="{{ old('') }}" placeholder="千代田区" >
                                </div>
                            </div>
                            <div class="pr-2">
                                <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="苗字" >
                            </div>
                        </div>
                    </div>
                    <div class="customer_row">
                        <div class="customer_title">備考</div>
                        <div class="customer_contents">
                            <textarea name="" placeholder="備考が入ります。この内容はお客様には閲覧できません" ></textarea>
                        </div>
                    </div>
                    <div class="flex">
                        <input type="submit" value="登録" class="register-btn" onclick='return check_validation();' >
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-customer-layout>





