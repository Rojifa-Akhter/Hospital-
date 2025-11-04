<?php
/**
 * Created by PhpStorm.
 * User: jahid
 * Date: 11/3/16
 * Time: 6:59 PM
 */
?>
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">            
            <ul class="breadcrumb breadcrumb-caret position-right">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{route('dashboard')}}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                @for($i = 1; $i <= count(Request::segments()); $i++)
                    <li>
                        <a href="">{{Request::segment($i)}}</a>
                        @if($i < count(Request::segments()) & $i > 0)
                            {!!'<i class="fa fa-angle-right"></i>'!!}
                        @endif
                    </li>
                @endfor
            </ul>
            <h4><i class="icon-display4 position-left"></i> {!! $pageTitle !!}</h4>
        </div>
    </div>
</div>
<!-- /page header -->