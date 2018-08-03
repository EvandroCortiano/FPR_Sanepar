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
                <a href="../../doador/cadastro">
                    <div class="dashboard-div-wrapper bk-clr-three">
                        <i class="fa fa-edit dashboard-div-icon" ></i>
                        <h5>Cadastrar Doador </h5>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <a href="../../doador/doadores">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i class="fa fa-child dashboard-div-icon" ></i>
                        <h5>Cadastrar Doação </h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@stop