@extends('templete')

@section(`title`)
Bem vindo ao Blog Code-Laravel
@stop

@section('content')

<!-- MENU SECTION END-->
<div class="content-wrapper">
    <div class="container">
        {{-- <div class="row">
            <div class="col-md-12">
                <h4 class="page-head-line">Dashboard</h4>
            </div>
        </div> --}}
        
        <div class="row">
            @can('operador', Auth::user())
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="../../pessoas/">
                        <div class="dashboard-div-wrapper bk-clr-three">
                            <i class="fa fa-phone dashboard-div-icon" ></i>
                            <h3 style="margin:0px;">Lista para Contato</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="../../doador/doadores">
                        <div class="dashboard-div-wrapper bk-clr-one">
                            <i class="fa fa-child dashboard-div-icon" ></i>
                            <h3 style="margin:0px;">Doação / Doadores</h3>
                        </div>
                    </a>
                </div>
            @endcan
            @can('administrador', Auth::user())
            <div class="col-md-3 col-sm-3 col-xs-6">
                <a href="../../repasse">
                    <div class="dashboard-div-wrapper bk-clr-two">
                        <i class="fa fa-tasks dashboard-div-icon" ></i>
                        <h3 style="margin:0px;">Administrar Doações</h3>
                    </div>
                </a>
            </div>
            @endcan
            @can('supervisao', Auth::user())
            <div class="col-md-3 col-sm-3 col-xs-6">
                <a href="../../repasse">
                    <div class="dashboard-div-wrapper bk-clr-four">
                        <i class="fa fa-credit-card dashboard-div-icon" ></i>
                        <h3 style="margin:0px;">Cartão + Pró Renal</h3>
                    </div>
                </a>
            </div>
            @endcan
        </div>
    </div>
</div>

@stop