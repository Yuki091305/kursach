<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // Показать страницу подписки
    public function show()
    {
        return view('subscription');
    }

    // Оформить подписку (симуляция оплаты)
    public function subscribe(Request $request)
    {
        $request->validate([
            'agree' => 'required|accepted',
        ], [
            'agree.accepted' => 'Необходимо принять условия подписки.',
        ]);

        $user = Auth::user();
        $user->is_subscribed = true;
        $user->save();

        return redirect('/profile')->with('success', 'Подписка оформлена! Теперь вы можете менять обложку профиля.');
    }

    // Отменить подписку
    public function unsubscribe()
    {
        $user = Auth::user();
        $user->is_subscribed = false;
        $user->cover = null;  // убираем обложку
        $user->save();

        return redirect('/profile')->with('success', 'Подписка отменена.');
    }
}
