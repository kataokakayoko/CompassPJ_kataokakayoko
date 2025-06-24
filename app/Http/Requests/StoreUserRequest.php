<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' => ['required', 'string', 'max:10'],
            'over_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ァ-ヶー]+$/u'],
            'under_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ァ-ヶー]+$/u'],
            'mail_address' => ['required', 'email', 'max:100', 'unique:users,mail_address'],
            'sex' => ['required', Rule::in([1, 2, 3])],
            'old_year' => ['required', Rule::in(range(1985, 2010))],
            'old_month' => ['required', Rule::in(range(1, 12))],
            'old_day' => ['required', Rule::in(range(1, 31))],
            'role' => ['required', Rule::in([1, 2, 3, 4])],
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
            'subject' => ['sometimes', 'array'], // role=4時のみ科目選択
            'subject.*' => ['integer', 'exists:subjects,id'],
        ];
    }

    public function messages()
    {
        return [
            'over_name.required' => '姓を入力してください。',
            'under_name.required' => '名を入力してください。',
            'over_name_kana.required' => 'セイを入力してください。',
            'under_name_kana.required' => 'メイを入力してください。',
            'over_name_kana.regex' => 'セイはカタカナで入力してください。',
            'under_name_kana.regex' => 'メイはカタカナで入力してください。',
            'mail_address.required' => 'メールアドレスを入力してください。',
            'mail_address.email' => '※メール形式で入力してください。',
            'mail_address.unique' => 'このメールアドレスは既に使われています。',
            'sex.required' => '性別を選択してください。',
            'old_year.required' => '生年月日（年）を選択してください。',
            'old_month.required' => '生年月日（月）を選択してください。',
            'old_day.required' => '生年月日（日）を選択してください。',
            'old_year.in' => '有効な年を選択してください。',
            'old_month.in' => '有効な月を選択してください。',
            'old_day.in' => '有効な日を選択してください。',
            'role.required' => '役職を選択してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード（確認）が一致しません。',
            'subject.array' => '科目は配列で指定してください。',
            'subject.*.integer' => '科目は整数値で指定してください。',
            'subject.*.exists' => '指定された科目が存在しません。',
        ];
    }

    protected function passedValidation()
    {
        $year = (int)$this->input('old_year');
        $month = (int)$this->input('old_month');
        $day = (int)$this->input('old_day');

        if (!checkdate($month, $day, $year)) {
            $this->validator->errors()->add('old_day', '正しい日付を入力してください。');
            throw new \Illuminate\Validation\ValidationException($this->validator);
        }
    }
}
