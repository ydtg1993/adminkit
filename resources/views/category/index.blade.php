@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body">

            <ul class="uk-list">
                <li>
                    <div>
                        <a href="javascript:void(0);" class="category_minus">
                            <span style="position: relative;" uk-icon="icon: minus-circle; ratio: 0.7"></span></a>
                        <label style="float: left">
                            <button class="uk-button uk-button-default">Default</button>
                        </label>
                        <a href="javascript:void(0);" class="category_plus">
                            <span style="position: relative;" uk-icon="icon: info; ratio: 0.7"></span></a>
                        <div class="clear_both"></div>
                    </div>
                    <ul class="uk-list">
                        <li>
                            <div>
                                <a href="javascript:void(0);" class="category_minus">
                                    <span style="position: relative;" uk-icon="icon: minus; ratio: 1"></span></a>
                                <label style="float: left">
                                    <button class="uk-button uk-button-default">Default</button>
                                </label>
                                <a href="javascript:void(0);" class="category_plus">
                                    <span style="position: relative;" uk-icon="icon: plus; ratio: 1"></span></a>
                                <div class="clear_both"></div>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a href="javascript:void(0);" class="category_minus">
                                    <span style="position: relative;" uk-icon="icon: minus; ratio: 1"></span></a>
                                <label style="float: left">
                                    <button class="uk-button uk-button-default">Default</button>
                                </label>
                                <a href="javascript:void(0);" class="category_plus">
                                    <span style="position: relative;" uk-icon="icon: plus; ratio: 1"></span></a>
                                <div class="clear_both"></div>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a href="javascript:void(0);" class="category_minus">
                                    <span style="position: relative;" uk-icon="icon: minus; ratio: 1"></span></a>
                                <label style="float: left">
                                    <button class="uk-button uk-button-default">Default</button>
                                </label>
                                <a href="javascript:void(0);" class="category_plus">
                                    <span style="position: relative;" uk-icon="icon: plus; ratio: 1"></span></a>
                                <div class="clear_both"></div>
                            </div>
                            <ul>
                                <li>
                                    <div>
                                        <a href="javascript:void(0);" class="category_minus">
                                            <span style="position: relative;" uk-icon="icon: minus; ratio: 1"></span></a>
                                        <label style="float: left">
                                            <button class="uk-button uk-button-default">Default</button>
                                        </label>
                                        <a href="javascript:void(0);" class="category_plus">
                                            <span style="position: relative;" uk-icon="icon: plus; ratio: 1"></span></a>
                                        <div class="clear_both"></div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div>
                                <a href="javascript:void(0);" class="category_minus">
                                    <span style="position: relative;" uk-icon="icon: minus; ratio: 1"></span></a>
                                <label style="float: left">
                                    <button class="uk-button uk-button-default">Default</button>
                                </label>
                                <a href="javascript:void(0);" class="category_plus">
                                    <span style="position: relative;" uk-icon="icon: plus; ratio: 1"></span></a>
                                <div class="clear_both"></div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>

@stop