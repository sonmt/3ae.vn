<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Book;
use App\Entity\Post;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class BookController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            return $next($request);
        });

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = new Book();
        $books = $book->orderBy('book_id', 'desc')->get();

        return view('admin.book.list', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $markTrades = Post::where('post_type', 'thuong-hieu-nha-hang')
            ->where('language', 'vn')
            ->orderBy('post_id')->get();

        return View('admin.book.add', compact('markTrades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('book.create'))
                ->withErrors($validation)
                ->withInput();
        }

        // if slug null slug create as title
        $book = new Book();
        $book->insert([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'message' => $request->input('message'),
            'time' => new \DateTime($request->input('time')),
            'restaurant' => $request->input('restaurant'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        return redirect(route('book.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $markTrades = Post::where('post_type', 'thuong-hieu-nha-hang')
            ->where('language', 'vn')
            ->orderBy('post_id')->get();

        return View('admin.book.edit', compact('book', 'markTrades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('book.edit', ['book_id' => $book->book_id]))
                ->withErrors($validation)
                ->withInput();
        }

        $book->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'message' => $request->input('message'),
            'time' => new \DateTime($request->input('time')),
            'restaurant' => $request->input('restaurant'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        return redirect(route('book.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect(route('book.index'));
    }
    public function exportToExcel(){
        $book = new Book();
        $books = $book->orderBy('book_id')->get();
        $data = array();
        $data[] = array(
            'Id',
            'Họ và tên',
            'Điên thoại',
            'Email',
            'Địa chỉ',
            'Message',
            'Nhà Hàng',
            'Thời gian',
            'Thời gian đăng ký'

        );
        foreach ($books as $item)
        {
            $date = date_create($item->created_at);

            $data[] = array(
                $item->book_id,
                $item->name,
                $item->phone,
                $item->email,
                $item->address,
                $item->message,
                $item->restaurant,
                $item->time,
                date_format($date,"H:i d/m/Y ")
            );
        }
        $date = new \DateTime();
        $filename = 'Dat-ban-'.$date->format("d/m/y");
        Excel::create($filename, function($excel) use ($data){
            $excel->sheet('sheetname', function($sheet) use ($data){
                $sheet->fromArray($data);
            });
        })->download('xls');

    }
}
