<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/7/2017
 * Time: 3:06 PM
 */

namespace App\Http\Controllers\Site;


use App\Entity\SubcribeEmail;
use Illuminate\Http\Request;

class SubcribeEmailController extends SiteController
{
    public function index(Request $request) {
        $email = $request->input('email');

        $isExistEmail = SubcribeEmail::where('email', $email)->exists();
        // nếu tồn tại email thì trả ra lỗi email tồn tại
        if ($isExistEmail) {
            return response([
                'status' => 200,
                'message' => 'Email đã tồn tại, vui lòng nhập email khác!'
            ])->header('Content-Type', 'text/plain');

        }

        // nếu email truyền vào là rỗng thì trả ra là bắt buộc nhập email
        if (empty($email)) {
            return response([
                'status' => 200,
                'message' => 'Bạn chưa nhập email, vui lòng nhập email!'
            ])->header('Content-Type', 'text/plain');
        }

        // Nếu đúng thì thêm vào admin
        SubcribeEmail::insert([
            'email' => $email,
            'created_at' => new \DateTime()
        ]);

        return response([
            'status' => 200,
            'message' => 'Cảm ơn bạn đã đăng ký nhận mail của chúng tôi!'
        ])->header('Content-Type', 'text/plain');
    }
}
