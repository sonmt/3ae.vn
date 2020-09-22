<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset(Auth::user()->image) }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        @if(!\App\Entity\User::isMember(\Illuminate\Support\Facades\Auth::user()->role))
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menu Chính</li>
            <li class="{{ Request::is('admin/posts', 'admin/posts/create', 'admin/categories') ? 'active' : null }} treeview">
                <a href="{{ route('posts.index') }}">
                    <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Bài viết</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/posts') ? 'active' : null }}">
                        <a href="{{ route('posts.index') }}"><i class="fa fa-circle-o"></i>Tất cả bải viết</a>
                    </li>
                    <li class="{{ Request::is('admin/posts/create') ? 'active' : null }}">
                        <a href="{{ route('posts.create') }}"><i class="fa fa-circle-o"></i>Thêm mới bài viết</a>
                    </li>
                    <li class="{{ Request::is('admin/categories') ? 'active' : null }}">
                        <a href="{{ route('categories.index') }}"><i class="fa fa-circle-o"></i>Chuyên mục</a>
                    </li>
                </ul>
            </li>

            {{--<li class="{{ Request::is('admin/products', 'admin/products/create', 'admin/category-products') ? 'active' : null }} treeview">
                <a href="{{ route('products.index') }}">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> <span>Sản phẩm</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/products') ? 'active' : null }}">
                        <a href="{{ route('products.index') }}"><i class="fa fa-circle-o"></i>Tất cả sản phẩm</a>
                    </li>
                    <li class="{{ Request::is('admin/products/create') ? 'active' : null }}">
                        <a href="{{ route('products.create') }}"><i class="fa fa-circle-o"></i>Thêm mới sản phẩm</a>
                    </li>
                    <li class="{{ Request::is('admin/category-products') ? 'active' : null }}">
                        <a href="{{ route('category-products.index') }}"><i class="fa fa-circle-o"></i>Chuyên mục</a>
                    </li>
                </ul>
            </li>--}}

            <li class="header">Quản lý nội dung</li>
            @foreach($typeSubPostsAdmin as $typeSubPost)
                <li class="{{ Request::is('admin/'.$typeSubPost->slug.'/sub-posts', 'admin/'.$typeSubPost->slug.'/sub-posts/create') ? 'active' : null }} treeview">
                    <a href="{{$typeSubPost->slug.'/sub-posts' }} ">
                        <i class="fa fa-th-list" aria-hidden="true"></i><span>{{ $typeSubPost->title }}</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('admin/'.$typeSubPost->slug.'sub-posts') ? 'active' : null }}">
                            <a href="{{ route('sub-posts.index', ['typePost' => $typeSubPost->slug]) }}"><i class="fa fa-circle-o"></i>Tất cả {{ $typeSubPost->title }}</a>
                        </li>
                        <li class="{{ Request::is('admin/'.$typeSubPost->slug.'sub-posts/create') ? 'active' : null }}">
                            <a href="{{ route('sub-posts.create', ['typePost' => $typeSubPost->slug]) }}"><i class="fa fa-circle-o"></i>Thêm mới {{ $typeSubPost->title }}</a>
                        </li>
                    </ul>
                </li>
            @endforeach

            {{--<li class="header">Thanh toán và đơn hàng</li>--}}
            {{--<li class="{{ Request::is('/hinh-thuc-thanh-toan') ? 'active' : null }} ">--}}
                {{--<a href="{{ route('method_payment') }}">--}}
                    {{--<i class="fa fa-info-circle" aria-hidden="true"></i> <span>Cài đặt thanh toán</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="{{ Request::is('/don-hang') ? 'active' : null }} ">--}}
                {{--<a href="{{ route('orderAdmin') }}">--}}
                    {{--<i class="fa fa-shopping-basket" aria-hidden="true"></i> <span>Đơn hàng</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            <li class="header">ĐK email và bình luận</li>
            <li class="{{ Request::is(route('book.index')) ? 'active' : null }} ">
                <a href="{{ route('book.index') }}">
                    <i class="fa fa-bookmark" aria-hidden="true"></i> <span>Quản lý đặt bàn</span>
                </a>
            </li>
            <li class="{{ Request::is('/subcribe-email') ? 'active' : null }} ">
                <a href="{{ route('subcribe-email.index') }}">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i> <span>Đăng ký nhận email</span>
                </a>
            </li>
            <li class="{{ Request::is('/comments') ? 'active' : null }} ">
                <a href="{{ route('comments.index') }}">
                    <i class="fa fa-comments" aria-hidden="true"></i> <span>Quản lý bình luận</span>
                </a>
            </li>
            <li class="{{ Request::is(route('contact.index')) ? 'active' : null }} ">
                <a href="{{ route('contact.index') }}">
                    <i class="fa fa-paper-plane" aria-hidden="true"></i> <span>Quản lý Liên hệ</span>
                </a>
            </li>
            
            <li class="header">Giao diện</li>
            <li class="{{ Request::is('admin/menus', 'admin/menus/create') ? 'active' : null }} treeview">
                <a href="{{ route('menus.index') }}">
                    <i class="fa fa-bars" aria-hidden="true"></i> <span>Menu</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is( 'admin/menus' ) ? 'active' : null }}">
                        <a href="{{ route('menus.index') }}"><i class="fa fa-circle-o"></i>Tất cả menu</a>
                    </li>
                    <li class="{{ Request::is('admin/menus/create') ? 'active' : null }}">
                        <a href="{{ route('menus.create') }}"><i class="fa fa-circle-o"></i>Thêm mới menu</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is( route('languages.index'), route('languages.create')) ? 'active' : null }} treeview">
                <a href="{{ route('languages.index') }}">
                    <i class="fa fa-language" aria-hidden="true"></i> <span>Ngôn ngữ</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is( route('languages.index')) ? 'active' : null }}">
                        <a href="{{ route('languages.index') }}"><i class="fa fa-circle-o"></i>Tất cả ngôn ngữ</a>
                    </li>
                    <li class="{{ Request::is( route('languages.create')) ? 'active' : null }}">
                        <a href="{{ route('languages.create') }}"><i class="fa fa-circle-o"></i>Thêm mới ngôn ngữ</a>
                    </li>
                </ul>
            </li>
            {{--<li class="{{ Request::is('admin/templates', 'admin/templates/create') ? 'active' : null }} treeview">--}}
                {{--<a href="{{ route('templates.index') }}">--}}
                    {{--<i class="fa fa-desktop" aria-hidden="true"></i> <span>Template</span>--}}
                    {{--<span class="pull-right-container">--}}
                      {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li class="{{ Request::is( 'admin/templates' ) ? 'active' : null }}">--}}
                        {{--<a href="{{ route('templates.index') }}"><i class="fa fa-circle-o"></i>Tất cả Template</a>--}}
                    {{--</li>--}}
                    {{--<li class="{{ Request::is('admin/templates/create') ? 'active' : null }}">--}}
                        {{--<a href="{{ route('templates.create') }}"><i class="fa fa-circle-o"></i>Thêm mới Template</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}


            <li class="header">Cài đặt dữ liệu</li>
            <li class="{{ Request::is('admin/type-sub-post', 'admin/type-sub-post/create') ? 'active' : null }} treeview">
                <a href="{{ route('type-sub-post.index') }}">
                    <i class="fa fa-wrench" aria-hidden="true"></i> <span>Dạng bài viết</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is( 'admin/type-sub-post' ) ? 'active' : null }}">
                        <a href="{{ route('type-sub-post.index') }}"><i class="fa fa-circle-o"></i>Tất cả dạng bài viết</a>
                    </li>
                    <li class="{{ Request::is('admin/type-sub-post/create') ? 'active' : null }}">
                        <a href="{{ route('type-sub-post.create') }}"><i class="fa fa-circle-o"></i>Thêm mới dạng bài viết</a>
                    </li>
                </ul>
            </li>

            <li class="{{ Request::is('admin/type-input', 'admin/type-input/create') ? 'active' : null }} treeview">
                <a href="{{ route('type-input.index') }}">
                    <i class="fa fa-wrench" aria-hidden="true"></i> <span>Trường dữ liệu</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is( 'admin/type-input' ) ? 'active' : null }}">
                        <a href="{{ route('type-input.index') }}"><i class="fa fa-circle-o"></i>Tất cả trường dữ liệu</a>
                    </li>
                    <li class="{{ Request::is('admin/type-input/create') ? 'active' : null }}">
                        <a href="{{ route('type-input.create') }}"><i class="fa fa-circle-o"></i>Thêm mới trường dữ liệu</a>
                    </li>
                </ul>
            </li>

            <li class="header">Thông tin trang web</li>
            <li class="{{ Request::is('admin/information') ? 'active' : null }} ">
                <a href="{{ route('information.index') }}">
                    <i class="fa fa-info-circle" aria-hidden="true"></i> <span>Thông tin trang</span>
                </a>
            </li>

            <li class="{{ Request::is('admin/type-information', 'admin/type-information/create') ? 'active' : null }} treeview">
                <a href="{{ route('type-information.index') }}">
                    <i class="fa fa-wrench" aria-hidden="true"></i> <span>Cài đặt Thông tin</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is( 'admin/type-information' ) ? 'active' : null }}">
                        <a href="{{ route('type-information.index') }}"><i class="fa fa-circle-o"></i>Tất cả Thông tin</a>
                    </li>
                    <li class="{{ Request::is('admin/type-information/create') ? 'active' : null }}">
                        <a href="{{ route('type-information.create') }}"><i class="fa fa-circle-o"></i>Thêm mới thông tin</a>
                    </li>
                </ul>
            </li>
            @endif
            @if(\App\Entity\User::isManager(\Illuminate\Support\Facades\Auth::user()->role))
            <li class="header">Thành viên</li>
            <li class="{{ Request::is('admin/users', 'admin/users/create') ? 'active' : null }} treeview">
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-wrench" aria-hidden="true"></i> <span>Quản lý thành viên</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is( 'admin/users' ) ? 'active' : null }}">
                        <a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i>Tất cả Thành viên</a>
                    </li>
                    <li class="{{ Request::is('admin/users/create') ? 'active' : null }}">
                        <a href="{{ route('users.create') }}"><i class="fa fa-circle-o"></i>Thêm mới thành viên</a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
