<?php

/* 
 * Erros catalogados:
 * 1 - ExcluirDados.php
 *  1000 - Nenhuma tabela foi definida, favor entrar em contato com o administrador.
 *  1001 - A classe que representa essa tabela não foi encontrada.
 * 
 * 
 * 2 - InserirDados.php
 *  2000 - A classe que representa essa tabela não foi encontrada.
 *  2001 - A instrução SQL para inserir dados retornou erros.
 * 
 * 
 * 3 - SelecionarDados.php
 *  3000 - Nenhuma tabela foi definida, favor entrar em contato com o administrador.
 *  3001 - A classe que representa essa tabela não foi encontrada.
 * 
 * 
 * 4 - Atualizar.php
 *  4000 - Nenhuma tabela foi definida, favor entrar em contato com o administrador.
 *  4001 - A classe que representa essa tabela não foi encontrada.
 * 
 * 5 - SDados.php
 *  5000 - Você não está autenticado, favor entrar em contato com o administrador.
 *  5001 - A pasta de sessões não foi encontrada, favor entrar em contato com o administrador.
 * 
 * 6 - ModeloTabelas.php
 *  6000 - O arquivo de configuração não foi encontrado.
 *  6001 - O arquivo Engines de configuração do banco de dados não foi localizado.
 *  6002 - Tabela de privilégios não foi encontrada
 *  6003 - Usuário definido não possui privilégios nessa tabela($this->NomeTabela) para essa operação: $Tipo - getVerificarPrivilegios()
 *  6004 - Usuário definido não possui privilégios nessa tabela($this->NomeTabela) para essa operação: $Tipo - getVerificarPrivilegios()
 *  6005 - Usuário definido não possui privilégios nessa tabela($this->NomeTabela) para essa operação: $Tipo - getVerificarPrivilegios()
 *  6006 - Nenhum usuário foi definido para que possa ser verificado o acesso.
 *  6007 - Inválido o número de parâmetros.

 * 7 - TabelaBancodeDados.php
 *  7000 - O arquivo de configuração não foi encontrado
 * 
 * 8 - cadastrar.php
 *  8000 - O arquivo de configuração não foi encontrado.
 *  8001 - O arquivo responsável pela base de dados e tabelas não foi encontrado.
 *  8002 - As senhas não são iguais, favor entrar em contato com o administrador!
 *  8003 - O dispositivo utilidado não foi informado.
 *  8004 - O dispositivo utilidado não é válido para esse sistema.
 *  8005 - Ocorreram erros ao cadastrar usuário. Favor entrar em contato com o administrador!
 * 
 * 9 - Cofiguracao.php
 *  9000
 * 
 * 10 - LoadPages/index.php/CLPaginasWEB.php
 *  10000 - O arquivo de Configuração não foi encontrado.
 *  10001 - A configuração do banco de dados não foi encontrado.
 *  10002 - O arquivo de configuração do código HTML não foi localizado.
 * 
 * 11 - SecurityPgs.php
 *  11000 - O arquivo de Configuração não foi encontrado.
 *  11001 - Error sessão.
 *  11002 - Usuário inválido para essa sessão, favor entrar em contato com o administrador!
 *  11003 - Tempos não estão sincronizados, favor entrar em contato com o administrador!.
 *  11004 - Tempo de sessão expirado, favor efetuar login novamente!.
 *  11005 - Login necessário, favor entrar em contato com o administrador!.
 * 
 * 
 * 12 - Cabecalho_Tabelas.php
 *  12000 - O arquivo de Configuração não foi encontrado.
 *  12001 - A configuração do banco de dados não foi encontrado.
 *  12002 - Nenhuma operação foi definida, favor entrar em contato com o administrador.
 *  12003 - Usuário inválido para essa sessão, favor entrar em contato com o administrador!.
 *  12004 - Tempos não estão sincronizados, favor entrar em contato com o administrador!.
 *  12005 - Tempo de sessão expirado, favor efetuar login novamente!.
 *  12006 - Login necessário, favor entrar em contato com o administrador!.
 * 
 * 13 - Tabelas.php
 *  13000 - O arquivo de configuração não foi encontrado.
 *  13001 - O arquivo responsável pela instrução selecionar dados não foi encontrado.
 *  13002 - O arquivo responsável pela instrução inserir dados não foi encontrado.
 *  13003 - O arquivo responsável pela instrução atualizar dados não foi encontrado.
 *  13004 - O arquivo responsável pela instrução excluir dados não foi encontrado.
 *  13005 - O arquivo responsável pela instrução upload não foi encontrado.
 *  13006 - O arquivo responsável pela instrução carregar páginas não foi encontrado.
 * 
 * 14 - Verify
 *  14000 - O arquivo de configuração não foi encontrado.
 *  14001 - A configuração do banco de dados não foi encontrado.
 *  14002 - O dispositivo utilidado não foi informado.
 *  14003 - O dispositivo utilidado não é válido para esse sistema.
 *  14004 - O usuário não existe ou não está habilitado no sistema. Favor entrar em contato com o administrador.
 *  14005 - Usuário bloqueado, favor entrar em contato com o administrador.
 *  14006 - Usuário ou senha inválidos.
 *  14007 - Esse usuário foi autenticado, mas não possui nenhum perfil de acesso. Favor entrar em contato com o administrador.
  * 4590  - Error sessão. Controller - Cabecalho_Tabelas.php
 * 
 * 15 - ValidarLigin.php
 *  15000 - O arquivo de configuração não foi encontrado.
 *  15001 - A configuração do banco de dados não foi encontrado.
 *  15002 - O dispositivo utilidado não foi informado.
 *  15003 - O dispositivo utilidado não é válido para esse sistema.
 *  15003 - Usuário inválido para essa sessão, favor entrar em contato com o administrador!.
 *  15004 - Tempos não estão sincronizados, favor entrar em contato com o administrador!.
 *  15005 - Tempo de sessão expirado, favor efetuar login novamente!.
 *  15006 - Login necessário, favor entrar em contato com o administrador!.
 * 
 * 
 * 16 - 
 * 
 * 
 * 
 * 17 - 
 * 3400 - A operação não foi encontrada. Controller
 * 3401 - A operação não foi encontrada. Controller
 * 3402 - A operação não foi encontrada. Controller
 * 3403 - A operação não foi encontrada. Controller
 * 3404 - A operação não foi encontrada. Controller - ExcluirDados.php
 * 3405 - Nenhuma tabela foi definida, favor entrar em contato com o administrador. SelecionarDados.php
 * 3406 - A classe que representa essa tabela não foi encontrada. SelecionarDados.php
 * 3407 - A classe que representa essa tabela não foi encontrada. InserirDados.php
 * 3409 - A classe que representa essa tabela não foi encontrada. AtualizarDados.php
 * 
 * 3585 - O arquivo Engines de configuração do banco de dados não foi localizado. Modelo de tabelas. - ModelosTabelas.php
 * 3586 - O arquivo de configuração não foi encontrado. Modelo de tabelas - ModelosTabelas.php
 * 
 * 3587 - O arquivo de configuração não foi encontrado. BDSQL - BDSQL_PDO.php
 * 
 * 3588 - O arquivo de configuração não foi encontrado. verify.php
 * 
 * 3590 - Error sessão. Controller - Cabecalho_Tabelas.php
 * 
 * 3591 - Esse usuário foi autenticado, mas não possui nenhum perfil de acesso. Favor entrar em contato com o administrador. verify.php
 * 3592 - O usuário não existe ou não está habilitado no sistema. Favor entrar em contato com o administrador. verify.php
 * 3593 - A configuração do banco de dados não foi encontrado. verify.php
 * 3594 - O dispositivo utilidado não foi informado. verify.php
 * 3595 - Usuário e senha inválidos. verify.php
 * 3596 - O dispositivo utilidado não é válido para esse sistema. verify.php.
 * 3599 - Usuario Bloqueado

 *  * 3594 - O dispositivo utilidado não foi informado. cadastrar.php
 *  * 3596 - O dispositivo utilidado não é válido para esse sistema. cadastrar.php.
* 3597 - Ocorreram erros ao cadastrar usuário. Favor entrar em contato com o administrador!. cadastrar.php
 * 3598 - As senhas não são iguais, favor entrar em contato com o administrador!. cadastrar.php

 * 3692 - Login necessário, favor entrar em contato com o administrador!. - Cabecalho_Tabelas.php
 * 3693 - Tempos não estão sincronizados, favor entrar em contato com o administrador!. - Cabecalho_Tabelas.php
 * 3694 - Tempo de sessão expirado, favor efetuar login novamente!. - Cabecalho_Tabelas.php
 * 3691 - Login necessário, favor entrar em contato com o administrador!. - Cabecalho_Tabelas.php
 * 3692 - O arquivo de Configuração não foi encontrado. Cabecalho_Tabelas
 * 
 * 35200 - Tabela de privilégios não foi encontrada. - ModeloTabelas.php
 * 35201 - Usuário definido não possui privilégios nessa tabela. - ModeloTabelas.php
 * 35202 - Nenhum usuário foi definido para que possa ser verificado o acesso. - ModeloTabelas.php
 * 35203 - PDO Erros diversos - getVerificarPrivilegios - ModeloTabelas.php
 * 35204 - InserirDadosTabela() - ModeloTabelas.php
 * 35205 - AtualizarDadosTabela() - ModeloTabelas.php
 * 
 * 40001 - O arquivo de cabecalho não foi encontrado. Cabeçalho Geral
 * 
 * 3692 - 
 * 3692 - 
 * 3692 - 
 * 3692 - 

 * ERROR ACIMA DE 10000 SÃO ERROS PERSONALIZADOS DAS FUNÇÕES DAS CLASSES DAS TABELAS EM SEUS MÉTODOS:
 * Jobs() - validarConteudoCampoRegex()
 * 
 * 50000 - 60000 => Erros gerados no CORAC Desktop
 * 
 * Page Servidor_HTTP.cs
 * 
 * 50000 - Esse comando não existe. 
 */

