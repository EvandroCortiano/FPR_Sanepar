@extends('templete')

@section(`title`)
	Usuários
@stop

@section('content')
<div class="container" style="min-height:400px;padding:15px;">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                Usuários Cadastrados
                <a class="btn btn-sm btn-success pull-right" href="../../user/users/create" data-toggle="tooltip" data-placement="top" data-title="Adicionar usuário">
                    <i class="fas fa-user-plus"></i>
                     Adicionar usuário
                </a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail/Login</th>
                                <th>Perfil</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->users_perfil->per_nome }}</td>
                                <td>
                                    <a class="btn btn-xs btn-info" style="margin-right:20px" href="../../user/users/edit/{{ $user->id }}" data-toggle="tooltip" data-placement="top" data-title="Editar">
                                        <i class="fa fa-pencil"></i> Editar
                                    </a>
                                    <a class="btn btn-xs btn-danger" href="../../user/users/destroy/{{ $user->id }}" data-toggle="tooltip" data-placement="top" data-title="Deletar">
                                        <i class="fa fa-trash"></i> Excluir
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{-- <div class="pull-right">
                        {{ $users->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
