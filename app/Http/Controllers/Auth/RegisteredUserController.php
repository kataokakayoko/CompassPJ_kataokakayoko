<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use DB;

use App\Models\Users\Subjects;
use App\Models\Users\User;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
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
        ], [
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
        ]);

        if (!checkdate((int)$request->old_month, (int)$request->old_day, (int)$request->old_year)) {
            return back()->withErrors(['old_day' => '正しい日付を入力してください'])->withInput();
        }

        DB::beginTransaction();
        try{
            $birth_day = sprintf('%04d-%02d-%02d', $request->old_year, $request->old_month, $request->old_day);

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]);
            if($request->role == 4 && $request->has('subject')) {
                $user_get->subjects()->attach($request->subject);
            }
            DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('loginView')->with('error', '登録に失敗しました。');
        }
    }
}
