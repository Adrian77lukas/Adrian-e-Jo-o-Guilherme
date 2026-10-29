<?php
require_once __DIR__ . '/../models/Personagem.php';

class PersonagemController {
    private $model;
    public function __construct() { $this->model = new Personagem(); }

    public function executar() {
        $acao = $_GET['acao'] ?? 'listar';
        $erro = '';
        $personagem = null;
        $busca = trim($_GET['busca'] ?? '');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $dados = [
                'nome' => trim($_POST['nome'] ?? ''),
                'universo' => trim($_POST['universo'] ?? ''),
                'poder' => trim($_POST['poder'] ?? ''),
                'categoria' => trim($_POST['categoria'] ?? 'Outro'),
                'descricao' => trim($_POST['descricao'] ?? '')
            ];
            if ($dados['nome'] === '' || $dados['universo'] === '' || $dados['poder'] === '') {
                $erro = 'Preencha nome, universo e habilidade principal.';
                $personagem = array_merge($dados, ['id' => $id]);
                $acao = $id ? 'editar' : 'novo';
            } else {
                if ($id > 0) $this->model->atualizar($id, $dados);
                else $this->model->salvar($dados);
                header('Location: index.php?msg=' . ($id ? 'atualizado' : 'criado'));
                exit;
            }
        }

        if ($acao === 'excluir' && isset($_GET['id'])) {
            $this->model->excluir((int)$_GET['id']);
            header('Location: index.php?msg=excluido');
            exit;
        }
        if ($acao === 'editar' && !$personagem && isset($_GET['id'])) {
            $personagem = $this->model->buscarPorId((int)$_GET['id']);
            if (!$personagem) { header('Location: index.php'); exit; }
        }

        $personagens = $this->model->listar($busca);
        $mensagens = [
            'criado' => 'Personagem adicionado ao arquivo.',
            'atualizado' => 'Cadastro atualizado com sucesso.',
            'excluido' => 'Personagem removido do arquivo.'
        ];
        $mensagem = $mensagens[$_GET['msg'] ?? ''] ?? '';
        $tituloPagina = ($acao === 'novo' ? 'Novo personagem' : ($acao === 'editar' ? 'Editar personagem' : 'Arquivo de personagens'));
        require __DIR__ . '/../views/layout.php';
    }
}
