@extends('site.layout.site')

@section('title','Thông tin tài khoản')
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    @include('site.partials.menu_main', ['classHome' => ''])
      <section class="user">
          <div class="container">
              <div class="row">
                  <div class="col-xs-12 col-md-3">
                        @include('site.partials.side_bar_user', ['active' => 'inforUser'])
                  </div>

                  <div class="col-xs-12 col-md-9">
                      <div class="breadrum mb20">
                          <a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                          <a href="/thong-tin-ca-nhan"> Trang cá nhân</a>
                      </div>

                      <div class="InformationPerson clearfix">
						<div class="mainTitle lineblue">
							<h3 class="titleV bgblue"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Thông tin cá nhân</h3>
						</div>
                          <div class="underline"></div>
                          <form action="/thong-tin-ca-nhan" method="post" enctype="multipart/form-data">
                              {!! csrf_field() !!}
                          <div class="col-xs-6 col-md-4">
                              <div class="userAvatar boxH5">
                                  <img id="blah" src="{{ (!empty($user->image)) ? $user->image : asset('site/images/no_person.png') }}" alt="trang cá nhân" width="150"/>
                                  <button class="btn btn-default addAvatar">TẢI LÊN AVATAR</button>
                                  <input type='file' id="imgInp" name="image" onchange="readURL(this)" style="display: none"/>
                                  <input type="hidden" value="{{ $user->image }}" name="avatar" />
                                  <script>
                                      function readURL(input) {
                                          if (input.files && input.files[0]) {
                                              var reader = new FileReader();

                                              reader.onload = function(e) {
                                                  $('#blah').attr('src', e.target.result);
                                              }

                                              reader.readAsDataURL(input.files[0]);
                                          }
                                      }
                                      $('.addAvatar').click(function() {
                                          $('#imgInp').click();
                                          return false;
                                      });
                                  </script>
                              </div>
                          </div>
                          <div class="col-xs-6 col-md-8">
                              <div class="formInformation boxH5">
                                  <div class="form-group">
                                      <input type="text" name="name" class="form-control" placeholder="Họ và tên: " value="{{ $user->name }}" />
                                  </div>
                                  <div class="form-group">
                                      <input type="text" name="phone" class="form-control" placeholder="Số điện thoại:"  value="{{ $user->phone }}" />
                                  </div>
                                  <div class="form-group">
                                      <input type="text" name="address" class="form-control" placeholder="Địa chỉ:" value="{{ $user->address }}" />
                                  </div>
                                  <div class="form-group">
                                      <input type="text" name="age" class="form-control" placeholder="Giới tính:" value="{{ $user->age }}" />
                                  </div>
                                  <div class="form-group">
                                      <input type="email" name="email" class="form-control" placeholder="Email:" value="{{ $user->email }}" />
                                  </div>
                                  <div class="form-group">
                                      <button type="submit" class="btn btn-danger">ĐỔI THÔNG TIN</button>
                                  </div>
                              </div>
                          </div>
                          </form>
                      </div>
                      <script>
						//Đồng bộ chiều cao các div
						$(function() {
							$('.boxH5').matchHeight();
						});
						</script>
                  </div>
              </div>
          </div>
      </section>
@endsection
