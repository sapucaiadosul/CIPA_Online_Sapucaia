<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Usuario;
use App\Candidatos;
use Illuminate\Support\Facades\Auth;

    Route::get('/','Controller@home')->name('CIPA_Online.Welcome');
    Route::get('/eleicoes','EleicaoController@index')->name('Eleicoes_Index')->middleware('auth');
    Route::get('/eleicoes/novo','EleicaoController@create')->name('Eleicoes_Create')->middleware('auth');
    Route::post('/eleicoes/salvar','EleicaoController@store')->name('Eleicoes_Store')->middleware('auth');
    Route::get('/eleicoes/listar','EleicaoController@list')->name('Eleicoes_Listar')->middleware('auth');
    Route::get('/eleicoes/editar/{id}','EleicaoController@edit')->name('Eleicoes_Edit')->middleware('auth');
    Route::get('/eleicoes/pdf-resultado/{id}/','VotacaoController@pdf_resultados')->name('Eleicoes_pdfResultado')->middleware('auth');
    Route::post('/eleicoes/editar','EleicaoController@update')->name('Eleicoes_Update')->middleware('auth');
    Route::get('/eleicoes/deletar/{id}', 'EleicaoController@destroy')->name('Eleicoes_Destroy')->middleware('auth');
    Route::get('/eleicoes/baixar_anexos/{id}','EleicaoController@baixar_anexos')->name('Eleicoes_BaixarAnexos')->middleware('auth');

    Route::get('/candidato','CandidatoController@index')->name('Candidato_Index');
    Route::post('/candidato/login_candidato', 'CandidatoController@login_candidato')->name('Candidato_Login');
    Route::get('/candidato/incricao', 'CandidatoController@inscricao')->name('Candidato.Inscricao');
    Route::get('/candidato/novo/','CandidatoController@create')->name('Candidato_Create');
    Route::post('/candidato/salvar','CandidatoController@store')->name('Candidato_Store');
    Route::get('/candidato/listar','CandidatoController@list')->name('Candidato_Listar');
    Route::get('/candidato/editar/{id}','CandidatoController@edit')->name('Candidato_Edit');
    Route::post('/candidato/editar','CandidatoController@update')->name('Candidato_Update');
    Route::get('/candidato/deletar/{id}','CandidatoController@destroy')->name('Candidato_Destroy');
    Route::get('/candidato/pdfInscricao/{id}','CandidatoController@pdf_inscricao')->name('Candidato_pdfInscricao');
    Route::get('/candidato/listagem_geral', 'CandidatoController@listagem_geral')->name('Candidato_ListagemGeral')->middleware('auth');
    Route::post('/candidato/filter_candidato', 'CandidatoController@filter_candidato')->name('Candidato_FilterCandidato')->middleware('auth');
    Route::get('/candidato/pdf_listagem_geral', 'CandidatoController@pdf_listagem_geral')->name('Candidato_pdfListagemGeral')->middleware('auth');
    Route::get('/candidato/logout','CandidatoController@logout')->name('Candidato_Logout');

    // Rotas utilizadas na importação de servidores
    Route::get('/importacoes', 'ImportacaoController@index')->name('importacoes')->middleware('auth');
    Route::post('/importar-servidor', 'ImportacaoController@importar_servidor')->middleware('auth');

    Route::get('/votacao','VotacaoController@index')->name('Votacao_Index');
    Route::post('/votacao/login','VotacaoController@login_votacao')->name('Votacao_Login');
    Route::get('/votacao/novo','VotacaoController@create')->name('Votacao_Create');
    Route::get('/votacao/verifica','VotacaoController@verificarPeriodoVotacao')->name('verificar_periodo_votacao');
    Route::post('/votacao/mostrar_candidatos','VotacaoController@mostrar_candidatos')->name('Votacao_MostrarCandidatos');
    Route::get('/votacao/resultados','VotacaoController@resultados')->name('Votacao_Resultados');

    Route::get('/votacao/resultados_votacao','VotacaoController@resultados_json')->name('Votacao_Resultados_Json');

    Route::get('/votacao/acompanhamento_votacao','VotacaoController@acompanhamentoVotacao')->name('acompanhamento.votacao');

    Route::get('/votacao/comprovante/{id_votacao}','VotacaoController@comprovante')->name('Votacao_Comprovante');
    Route::get('/votacao/logout','VotacaoController@logout_votacao')->name('Votacao_Logout');
    Route::get('/votacao/json','VotacaoController@votocaojson')->name('Votacao_Json');
    
    Route::post('/votacao/salvando/','VotacaoController@registrar_voto')->name('Votacao_Store');

    Route::get('/audits','AuditController@list_all_audits')->name('Audits_listAll')->middleware('auth');
    Route::post('/audits/filtro','AuditController@filter')->name('Audits_filter')->middleware('auth');
    Route::get('/audits/show/{id}','AuditController@show')->name('Audits_show')->middleware('auth'); 

    Route::get('/access','AccessController@list_all_access')->name('Access_listAll')->middleware('auth');
    Route::post('/access/filtro','AccessController@filter')->name('Access_filter')->middleware('auth');

    Route::get('/home','Controller@home')->name('home')->middleware('auth');
    Route::get('/usuarios/registrar','UsuarioController@create')->name('Usuarios_registeruser')->middleware('auth')->middleware(Usuario::class);
    Route::post('/usuarios/registrar/salvar','UsuarioController@store')->name('Usuarios_registerstore')->middleware('auth')->middleware(Usuario::class);
    Route::get('/listar/usuario','UsuarioController@index')->name('Usuarios_listUser')->middleware('auth')->middleware(Usuario::class);

    Route::put('/users/{user}','UsuarioController@usuario_ativo')->name('users.update')->middleware('auth');

    // Route::get('/listar/usuario','UsuarioController@index')->name('Usuarios_listUser')->middleware('auth')->middleware(usuario::class);
    Route::get('/usuarios/editar/{id}','UsuarioController@editar')->name('Usuarios_editar')->middleware('auth')->middleware(Usuario::class);
    Route::post('/usuarios/editar','UsuarioController@update')->name('Usuarios_update')->middleware('auth')->middleware(Usuario::class);
    Route::get('/usuarios/deletar/{id}','UsuarioController@destroy')->name('Usuarios_destroy')->middleware('auth')->middleware(Usuario::class);
    Route::get('/logout', function () {Auth::logout();return redirect("/login");});
    
Auth::routes();
