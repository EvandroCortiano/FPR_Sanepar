@extends('templete')

@section(`title`)
Bem vindo ao Blog Code-Laravel
@stop

@section('content')

<!-- MENU SECTION END-->
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-head-line">Dashboard</h4>
            </div>
        </div>
        
        <div class="row">
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
                        <h3 style="margin:0px;">Cadastrar Doação</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@stop