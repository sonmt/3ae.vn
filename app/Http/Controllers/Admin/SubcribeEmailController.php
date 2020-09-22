<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/7/2017
 * Time: 2:47 PM
 */

namespace App\Http\Controllers\Admin;

use App\Entity\GroupMail;
use App\Entity\Post;
use App\Entity\SubcribeEmail;
use App\Entity\User;
use App\Mail\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class SubcribeEmailController extends AdminController
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

    public function index() {
         $groupMails = GroupMail::orderBy('group_mail_id', 'desc')->get();

         return view('admin.subcribe_email.index', compact('groupMails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groupMails = GroupMail::orderBy('group_mail_id', 'desc')->get();
        
        return view('admin.subcribe_email.add', compact('groupMails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subcribeEmail = new SubcribeEmail();
        $subcribeEmail->insert([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'group_id' => $request->input('group'),
        ]);

        return redirect(route('subcribe-email.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\SubcribeEmail  $subcribeEmail
     * @return \Illuminate\Http\Response
     */
    public function show(SubcribeEmail $subcribeEmail)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\SubcribeEmail  $subcribeEmail
     * @return \Illuminate\Http\Response
     */
    public function edit(SubcribeEmail $subcribeEmail)
    {
        $groupMails = GroupMail::orderBy('group_mail_id', 'desc')->get();

        return view('admin.subcribe_email.edit', compact('groupMails', 'subcribeEmail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\SubcribeEmail  $subcribeEmail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubcribeEmail $subcribeEmail)
    {
        $subcribeEmail->update([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'group_id' => $request->input('group'),
        ]);

        return redirect(route('subcribe-email.index'));
    }

    public function anyDatatables(Request $request) {
        $subcribeEmail = new SubcribeEmail();
        $subcribeEmails = $subcribeEmail->orderBy('subcribe_email_id', 'desc');

        return Datatables::of($subcribeEmails)
            ->addColumn('action', function($subcribeEmail) {
                $string =  '<a href="'.route('subcribe-email.edit', ['subcribe_email_id' => $subcribeEmail->subcribe_email_id]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('subcribe-email.destroy', ['subcribe_email_id' => $subcribeEmail->subcribe_email_id]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })->make(true);
    }
    
    public function destroy(SubcribeEmail $subcribeEmail) {
        $subcribeEmails = new SubcribeEmail();
        $subcribeEmails->where('subcribe_email_id', $subcribeEmail->subcribe_email_id)->delete();

        return redirect(route('subcribe-email.index'));
    }

    public function send(Request $request) {
        $group = $request->input('group');
        $emailSetting = $request->input('setting');
        $subject = $request->input('subject');
        $message = $request->input('content');
        $from = $request->input('from');
        
        $this->sendMail($emailSetting, $group, $from, $subject, $message);

        return redirect(route('subcribe-email.index'));
    }
    private function sendMail($emailSetting, $group, $from, $subject, $message){
        if (!empty($emailSetting)) {
            $mailConfig = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
                ->select('posts.*')
                ->where('type_sub_post_slug', 'cau-hinh-email')
                ->where('posts.slug', 'mail-cho-nguoi-dat-hang')
                ->first();
            $from = $mailConfig['from'];
            $subject = $mailConfig['chu-de-(subject)'];
            $content = $mailConfig->content;
        } else {
            $subject = $subject;
            $content = $message;
        }

        // get email to
        $emails = SubcribeEmail::where('group_id', $group)->get();
        $emailSend = array();
        foreach($emails as $email) {
            $emailSend[] =  $email->email;
        }
        
        $mail = new Mail(
            $content
        );
        \Mail::to($emailSend)->send($mail->from($from)->subject($subject));

        return redirect(route('subcribe-email.index'));
    }

    public function exportToExcel(){
        $subcribeEmail = new SubcribeEmail();
        $subcribeEmails = $subcribeEmail->orderBy('subcribe_email_id', 'desc')->get();
        $data = array();
        $data[] = array(
            'Id',
            'email',
            'thời gian đăng ký'
        );
        foreach ($subcribeEmails as $item)
        {
            $date = date_create($item->created_at);

            $data[] = array(
                $item->subcribe_email_id,
                $item->email,
                date_format($date,"H:i d/m/Y ")
            );
        }
        $date = new \DateTime();
        $filename = 'dk-nhan-mail-'.$date->format("d/m/y");
        Excel::create($filename, function($excel) use ($data){
            $excel->sheet('sheetname', function($sheet) use ($data){
                $sheet->fromArray($data);
            });
        })->download('xls');

    }
}
