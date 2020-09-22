<div class="commentBox">
    <?php $userCheck = \Illuminate\Support\Facades\Auth::check() ?>
    <div class="commentComment">
        <img class="avatar"
             src="{{ $userCheck ? asset(\Illuminate\Support\Facades\Auth::user()->image) : asset('site/images/no_person.png') }}" alt="avatar">
        <input type="hidden" class="username"
               value="{{ $userCheck ? \Illuminate\Support\Facades\Auth::user()->name : 'Ẩn Danh' }}">
        <div class="message form-group">
            {{ csrf_field() }}
            <input type="hidden"  class="parent" value="0" />
            <input type="hidden" name="post_id" class="post_id" value="{{ $post_id }}" />
            <textarea class="form-control messageContent" name="message" required></textarea>
            <buton class="submit btn btn-primary" onclick="return commentSubmit(this);">Bình luận</buton>
        </div>
    </div>
        
    <p class="evaluate">
        Đánh giá: <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>
    </p>

    <div class="commentShow">
        <p class="numberComment">Hiện có {{ \App\Entity\Comment::getCountComment($post_id) }} bình luận</p>
         <?php $commentDb = new \App\Entity\Comment();?>
        @foreach($commentDb->getAllComment($post_id) as $id => $comment)
        <div class="item">
            <div class="parent">
				<div class="avatar">
                    <img src="{{ empty($comment['user_image']) ? asset('site/images/no_person.png') : asset($comment['user_image']) }}" alt="avatar">
				</div>
                <div class="content">
                    <p><span class="username">{{ empty($comment['user_full_name']) ? 'Ẩn danh' : $comment['user_full_name'] }}</span>: {{ $comment['content'] }}</p>
                    <p><span class="reply" onclick="return repComment(this);">Trả lời</span> . <span class="date">{{ $comment['created_at'] }}</span></p>
                </div>
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if(!\App\Entity\User::isMember(\Illuminate\Support\Facades\Auth::user()->role) || \Illuminate\Support\Facades\Auth::user()->id == $comment['user_id'] )
                <input type="hidden" class="comment_id" value="{{ $comment['comment_id'] }}"/>
                <i class="fa fa-ban" aria-hidden="true"  data-toggle="modal" data-target="#myModalDelete" onclick="return submitDeleteComment(this);"></i>
                    @endif
                @endif
            </div>
            @if(!empty($comment['childrenComments']))               
            @foreach($comment['childrenComments'] as $child)
            <div class="children">
				<div class="avatar">
                    <img src="{{ empty($child->user_image) ? asset('site/images/no_person.png') : asset($child->user_image) }}" alt="avatar">
				</div>
                <div class="content">
                    <p><span class="username">{{ empty($child->user_full_name) ? 'Ẩn danh' : $child->user_full_name }}</span>: {{ $child->content }}</p>
                    <p><span class="reply" onclick="return repComment(this);">Trả lời</span> . <span class="date">{{ $child->created_at }}</span></p>
                </div>
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if(!\App\Entity\User::isMember(\Illuminate\Support\Facades\Auth::user()->role) || \Illuminate\Support\Facades\Auth::user()->id == $comment['user_id'] )
                    <input type="hidden" class="comment_id" value="{{ $child->comment_id }}"/>
                    <i class="fa fa-ban" aria-hidden="true"  data-toggle="modal" data-target="#myModalDelete" onclick="return submitDeleteComment(this);"></i>
                    @endif
                @endif
            </div>
            @endforeach
            @endif
        </div>
        <div class="commentComment child">
            <img class="avatar"
                 src="{{ $userCheck ? asset(\Illuminate\Support\Facades\Auth::user()->image) : asset('site/images/no_person.png') }}" alt="avatar">
            <input type="hidden" class="username"
                   value="{{ $userCheck ? \Illuminate\Support\Facades\Auth::user()->name : 'Ẩn Danh' }}">
            <div class="message form-group">
                {{ csrf_field() }}
                <input type="hidden" class="parent" value="{{ $comment['comment_id'] }}" />
                <input type="hidden" name="post_id" class="post_id" value="{{ $post_id }}" />
                <textarea class="form-control messageContent" name="message" required></textarea>
                <button class="submit btn btn-primary" onclick="return commentChildSubmit(this);">Bình luận</button>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
    function commentSubmit(e) {
        var image = $(e).parent().parent().find('.avatar').attr('src');
        var username = $(e).parent().parent().find('.username').val();
        var message = $(e).parent().parent().find('.messageContent').val();
        var postId = $(e).parent().parent().find('.post_id').val();
        var parent =  $(e).parent().parent().find('.parent').val();
        var token =  $(e).parent().parent().find('input[name=_token]').val();

        $.ajax({
            type: "POST",
            url: '{!! route('comment') !!}',
            data: {
                post_id: postId,
                parent: parent,
                message: message,
                _token: token
            },
            success: function(data){
                var obj = jQuery.parseJSON( data);
                
                var html = '<div class="item"><div class="parent">';
                html += '<img class="avatar" src="'+ obj.user_image +'" alt="avatar">';
                html += '<div class="content">';
                html += '<p><span class="username">'+ obj.user_full_name + '</span>: '+ message +'</p>';
                html += '<p><span class="reply" onclick="return repComment(this);">Trả lời</span>'
                    + ' . <span class="date">'+ obj.day + 'tháng ' + obj.month + ' năm ' + obj.year + '</span></p>';
                html += '</div>' +  '<input type="hidden" class="comment_id" value="'+obj.comment_id+'"/>' +
                    '<i class="fa fa-ban" aria-hidden="true" data-toggle="modal" data-target="#myModalDelete"  onclick="return submitDeleteComment(this);"></i></div></div>';

                html += '<div class="commentComment child">';
                html += '<img class="avatar" src="'+ obj.user_image +'" alt="avatar">';
                html += '<input type="hidden" class="username" value="'+obj.user_full_name+'">';
                html += '<div class="message form-group">';
                html += '{!! csrf_field() !!}';
                html += '<input type="hidden"  class="parent" value="'+obj.comment_id+'" />';
                html +=  '<input type="hidden" name="post_id" class="post_id" value="'+obj.post_id+'" />';
                html += '<textarea class="form-control messageContent"></textarea>';
                html +=  '<button class="submit btn btn-primary" onclick="return commentChildSubmit(this);">Bình luận</button>';
                html += '</div>';
                html += '</div>';

                $(e).parent().parent().find('.messageContent').val('');
                $('.commentShow').prepend(html);
            }
        });
    }

    function commentChildSubmit(e) {
        var image = $(e).parent().parent().find('.avatar').attr('src');
        var username = $(e).parent().parent().find('.username').val();
        var message = $(e).parent().find('.messageContent').val();
        var postId = $(e).parent().parent().find('.post_id').val();
        var parent =  $(e).parent().parent().find('.parent').val();
        var token =  $(e).parent().parent().find('input[name=_token]').val();

        $.ajax({
            type: "POST",
            url: '{!! route('comment') !!}',
            data: {
                post_id: postId,
                parent: parent,
                message: message,
                _token: token
            },
            success: function(data){
                var obj = jQuery.parseJSON( data);

                var html = '<div class="children">';
                html += '<img class="avatar" src="'+  obj.user_image  +'" alt="avatar">';
                html += '<div class="content">';
                html += '<p><span class="username">'+  obj.user_full_name  + '</span>: '+ message +'</p>';
                html += '<p><span class="reply" onclick="return repComment(this);">Trả lời</span> . <span class="date">'+ obj.day + 'tháng ' + obj.month + ' năm ' + obj.year + '</span></p>';
                html += '</div>' + '<input type="hidden" class="comment_id" value="'+obj.comment_id+'"/>' +
                    '<i class="fa fa-ban" aria-hidden="true" data-toggle="modal" data-target="#myModalDelete"  onclick="return submitDeleteComment(this);"></i></div>';

                $(e).parent().parent().find('.messageContent').val('');
                $(e).parent().parent().hide();
                $(e).parent().parent().prev().append(html);
            }
        });

    }

    function repComment(e) {
        $(e).parent().parent().parent().parent().next().show();
    }
</script>
@include('site.partials.popup_delete_comment')
