@extends('layouts.master')
@section('subtitle','管理员')

@section('container')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">管理员列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table role="grid" class="table table-bordered table-hover dataTable">
                                        <thead>
                                        <tr role="row">
                                            <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">
                                                ID
                                            </th><th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">
                                                帐号名
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">
                                                角色
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">
                                                联系人
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">
                                                联系人电话
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">
                                                最后一次登录时间
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">
                                                最后一次登录ip
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">
                                                登录次数
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"
                                                style="width: 310px;">
                                                操作
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($managers as $manager)
                                            <tr role="row" class="even">
                                                <td class="sorting_1">{{$manager->id}}</td>
                                                <td>{{$manager->account}}</td>
                                                <td>{{$manager->role_name}}</td>
                                                <td>{{$manager->contact or '未设置'}}</td>
                                                <td>{{$manager->contact_mobile  or '未设置'}}</td>
                                                <td>{{$manager->last_login_time}}</td>
                                                <td>{{long2ip($manager->last_login_ip)}}</td>
                                                <td>{{$manager->frequency}}</td>
                                                <td>
                                                    <div>
                                                        <button type="button" data-toggle="modal"
                                                                data-target="#modal-edit-user"
                                                                class="btn btn-block btn-info btn-xs"
                                                                style="width: 50px; float: left;">修改
                                                        </button>
                                                        <button type="button" data-toggle="modal"
                                                                data-target="#modal-edit-password"
                                                                class="btn btn-warning btn-xs"
                                                                style="width: 80px; float: left; margin-left: 10px;">
                                                            重置密碼
                                                        </button>
                                                        <button type="button" data-toggle="modal"
                                                                data-target="#modal-set-role"
                                                                class="btn btn-success btn-xs"
                                                                style="width: 50px; float: left; margin-left: 10px;">角色
                                                        </button>
                                                        <button type="button" data-toggle="modal"
                                                                data-target="#modal-delete-user"
                                                                class="btn btn-danger btn-xs"
                                                                style="width: 50px; float: left; margin-left: 10px;">删除
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                {{$managers->render()}}
                                {{--<div class="col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                        <ul class="pagination">
                                            <li class="paginate_button previous disabled" id="example2_previous"><a
                                                        href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a>
                                            </li>
                                            <li class="paginate_button active"><a href="#" aria-controls="example2"
                                                                                  data-dt-idx="1" tabindex="0">1</a>
                                            </li>
                                            <li class="paginate_button "><a href="#" aria-controls="example2"
                                                                            data-dt-idx="2" tabindex="0">2</a></li>
                                            <li class="paginate_button "><a href="#" aria-controls="example2"
                                                                            data-dt-idx="3" tabindex="0">3</a></li>
                                            <li class="paginate_button "><a href="#" aria-controls="example2"
                                                                            data-dt-idx="4" tabindex="0">4</a></li>
                                            <li class="paginate_button "><a href="#" aria-controls="example2"
                                                                            data-dt-idx="5" tabindex="0">5</a></li>
                                            <li class="paginate_button "><a href="#" aria-controls="example2"
                                                                            data-dt-idx="6" tabindex="0">6</a></li>
                                            <li class="paginate_button next" id="example2_next"><a href="#"
                                                                                                   aria-controls="example2"
                                                                                                   data-dt-idx="7"
                                                                                                   tabindex="0">Next</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@stop
@section('js-lib')
    @parent
@stop