<?php
require_once __DIR__ . '/../config/conexao.php';

class Personagem {
    private $db;
    public function __construct() { $this->db = Conexao::conectar(); }

    public function listar($busca = '') {
        if ($busca !== '') {
            $sql = "SELECT * FROM personagens
                    WHERE nome LIKE :busca OR universo LIKE :busca OR poder LIKE :busca
                    ORDER BY criado_em DESC, id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['busca' => '%' . $busca . '%']);
            return $stmt->fetchAll();
        }
        return $this->db->query("SELECT * FROM personagens ORDER BY criado_em DESC, id DESC")->fetchAll();
    }

    public function buscarPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM personagens WHERE id = ?");
        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }

    public function salvar($dados) {
        $stmt = $this->db->prepare(
            "INSERT INTO personagens (nome, universo, poder, categoria, descricao)
             VALUES (:nome, :universo, :poder, :categoria, :descricao)"
        );
        return $stmt->execute($dados);
    }

    public function atualizar($id, $dados) {
        $dados['id'] = (int)$id;
        $stmt = $this->db->prepare(
            "UPDATE personagens SET nome=:nome, universo=:universo, poder=:poder,
             categoria=:categoria, descricao=:descricao WHERE id=:id"
        );
        return $stmt->execute($dados);
    }

    public function excluir($id) {
        $stmt = $this->db->prepare("DELETE FROM personagens WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }
}
